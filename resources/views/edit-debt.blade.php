@extends('layouts.app')
@section('title', 'Gestão Financeira')
@section('content')
    <h2>Editar Dívida</h2>

    <form action="{{ route('debts.update', $debt->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nome</label>
        <input type="text" name="name" value="{{ old('name', $debt->name) }}" required>

        <label>Valor inicial</label>
        <input type="number" step="0.01" name="initial_debt_amount"
               value="{{ old('initial_debt_amount', $debt->initial_debt_amount) }}" required>

        <label>Valor acordado</label>
        <input type="number" step="0.01" name="agreed_value"
               value="{{ old('agreed_value', $debt->agreed_value) }}">

        <label>Forma de pagamento</label>
        <input type="text" name="payment_method"
               value="{{ old('payment_method', $debt->payment_method) }}">

        <label>Valor já pago</label>
        <input type="number" step="0.01" name="amount_paid"
               value="{{ old('amount_paid', $debt->amount_paid) }}">

        <button type="submit">Atualizar</button>
    </form>
@endsection