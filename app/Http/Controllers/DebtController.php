<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Debt;
use App\Models\DueDateDebt;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DebtController extends Controller
{
    public function storeDebt(Request $request){
        $user = Auth::user();

        // Determina valores básicos
        $agreed = $request->agreed_value ? floatval(str_replace(',', '.', $request->agreed_value)) : null;
        $amountPaid = $request->amount_paid ? floatval(str_replace(',', '.', $request->amount_paid)) : 0;
        $type = $request->type ?? '';

        // Calcula amount_to_pay: prefer agreed_value quando presente
        $amountToPay = ($agreed !== null ? $agreed : floatval($request->initial_debt_amount)) - $amountPaid;

        // Cria a dívida inicialmente (sem o campo value calculado ainda)
        $debt = Debt::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'initial_debt_amount' => $request->initial_debt_amount,
            'agreed_value' => $agreed ?? null,
            'payment_method' => $type ?: 'Desconhecido',
            'amount_paid' => $amountPaid,
            'amount_to_pay' => $amountToPay ?? 0,
        ]);

        // Agora cria as datas de vencimento conforme a condição de pagamento
        if ($type === 'Parcelado') {
            $installments = max(1, intval($request->installment));
            $baseDate = $request->payment_date ? Carbon::parse($request->payment_date) : Carbon::now();
            $paymentDay = $request->payment_day ? intval($request->payment_day) : intval($baseDate->day);

            // calcula valor por parcela
            $perInstallment = $agreed !== null ? round($agreed / $installments, 2) : 0;

            // salva o campo value no registro da dívida
            $debt->value = $perInstallment;
            $debt->save();

            for ($i = 0; $i < $installments; $i++) {
                $dt = $baseDate->copy()->addMonths($i);
                $daysInMonth = $dt->daysInMonth;
                $dayToUse = min(max(1, $paymentDay), $daysInMonth);
                $dueDate = Carbon::create($dt->year, $dt->month, $dayToUse)->toDateString();

                DueDateDebt::create([
                    'id_debts' => $debt->id,
                    'date' => $dueDate,
                    'status' => 'À pagar'
                ]);
            }
        } elseif ($type === 'À vista' || $type === 'À Vista' || strtolower($type) === 'a vista') {
            // à vista: value = valor acordado (se houver) ou initial_debt_amount
            $value = $agreed !== null ? $agreed : floatval($request->initial_debt_amount);
            $debt->value = $value;
            $debt->save();

            $date = $request->avista_payment_date ?? $request->payment_date ?? Carbon::now()->toDateString();
            DueDateDebt::create([
                'id_debts' => $debt->id,
                'date' => Carbon::parse($date)->toDateString(),
                'status' => 'À pagar'
            ]);
        } else {
            // condição não informada: manter value 0 e sem datas adicionais
        }

        return redirect()->back()->with('success', 'Dívida adicionada com sucesso!');
    }
public function editDebt($id) { 
    $user = Auth::user();
    $debt = Debt::where('user_id', $user->id)->findOrFail($id);
    return view('edit-debt', compact('debt'));
}

public function updateDebt(Request $request, $id)
{
    $user = Auth::user();
    $debt = Debt::where('user_id', $user->id)->findOrFail($id);

    $validated = $request->validate([
        'name'                => 'required|string',
        'initial_debt_amount' => 'required|numeric|min:0',
        'agreed_value'        => 'nullable|numeric|min:0',
        'payment_method'      => 'nullable|string',
        'amount_paid'         => 'nullable|numeric|min:0',
    ]);

    // Validando se o usuário não colocar nada no campo "Valor já pago".
    $validated['amount_paid'] = $validated['amount_paid'] ?? 0;

    $validated['amount_to_pay'] = 
        ($validated['agreed_value'] ?? $validated['initial_debt_amount']) - $validated['amount_paid'];

    $debt->update($validated);

    return redirect('dashboard')->with('success', 'Dívida atualizada com sucesso!');
}
    public function destroyDebt($id)
    {
        $user = Auth::user();
        $debt = Debt::where('user_id', $user->id)->findOrFail($id);
        $debt->delete();

        return redirect()->back()->with('success', 'Dívida excluída com sucesso!');
    }
}