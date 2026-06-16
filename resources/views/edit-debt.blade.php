@extends('layout.main')

@section('title', 'GF - Dashboard')

@section('content')
    <h2>Editar Dívida</h2>

<form action="{{ route('debts.update', $debt->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
            <h5 class="modal-title" id="dividaModalLabel">Editar Dívida</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-6">
                <label class="form-label" for="name">Nome da Dívida</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $debt->name) }}" required>
                </div>
                <div class="col-md-6">
                <label class="form-label" for="initial_debt_amount">Valor Inicial</label>
                <input type="number" step="0.01" name="initial_debt_amount" class="form-control" value="{{ old('initial_debt_amount', $debt->initial_debt_amount) }}" required>
                </div>
             
                <div class="mb-3">
                    <label for="agreed_value" class="form-label">Ouve Acordo?:</label>
                        @if($debt->agreed_value!== null)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="agreed_value" id="agreed_yes" value="1" checked ><!-- "Sim" marcado por padrão -->
                            <label class="form-check-label" for="agreed_yes">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="agreed_value" id="agreed_no" value="0"> 
                            <label class="form-check-label" for="agreed_no">Não</label>
                        </div>
                        @else
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="agreed_value" id="agreed_yes" value="1">
                            <label class="form-check-label" for="agreed_yes">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="agreed_value" id="agreed_no" value="0" checked> <!-- "Não" marcado por padrão -->
                            <label class="form-check-label" for="agreed_no">Não</label>
                        </div>
                       @endif
                </div>
                <div id="agreement_fields" style="display:none;">
                    <div class="col-md-6">
                        <label class="form-label" for="debt_agreed_value">Valor Acordado</label>
                        <input type="number" step="0.01" name="agreed_value" id="debt_agreed_value" class="form-control" value="{{ old('agreed_value', $debt->agreed_value) }}">
                    </div>
                    <div class="col-md-6" style="margin-top:8px;">
                        <label class="form-label" for="settlement_condition">Condição de pagamento</label>
                        <select class="form-control" name="type" id="debt_type">
                           @if($debt->payment_method === 'Parcelado' )
                            <option value="Parcelado">Parcelado</option>
                            <option value="À vista">À vista</option>
                            <option value="">Selecione...</option>

                           @elseif ($debt->payment_method === 'À vista' )
                            <option value="À vista">À vista</option>
                            <option value="Parcelado">Parcelado</option>
                            <option value="">Selecione...</option>

                           @else
                            <option value="">Selecione...</option>
                            <option value="À vista">À vista</option>
                            <option value="Parcelado">Parcelado</option>
                           @endif
                        </select>
                        <div id="debt_avista_payment_date_group" style="display:none; margin-top:8px;">
                            <label class="form-label" for="avista_payment_date">Data de Pagamento</label>
                            <input type="date" name="avista_payment_date" id="avista_payment_date" class="form-control">
                        </div>
                        <div id="debt_installment_other_group" style="{{ old('type') == 'Parcelado' ? '' : 'display:none' }}; margin-top:8px;">
                            <label for="title">Número de Parcelas</label>
                            <input type="number" name="installment" id="debt_installment_number" min="1" class="form-control" placeholder="Número de parcelas" value="{{ old('installment') }}">
                            <div class="col-md-6">
                            <label class="form-label">Data da primeira Parcela</label>
                            <!-- id adicionado e name alterado para não conflitar com o campo principal 'date' -->
                            <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', old('date')) }}" class="form-control">
                                @error('date') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6" style="margin-top:8px;">
                                <label class="form-label">Dia do vencimento das Parcelas</label>
                                <input type="number" name="payment_day" id="payment_day" style="max-width:180px" min="1" max="31" class="form-control" placeholder="{{ old('payment_day') ?? '' }}" value="{{ old('payment_day') }}">
                            </div>
                            <div class="col-md-6" style="margin-top:8px;">Valor da Parcela: <span id="debt_installment_value_display">-</span></div>
                        </div>
                        @error('installment') 
                            <div class="text-danger small">{{ $message }}</div> 
                        @enderror
                            <!-- <label class="form-label" for="installment_value">Valor da Parcela</label>
                            <input type="number" name="installment_value" step="0.01" class="form-control">

                            <label class="form-label" for="amount_paid">Valor já pago:</label>
                            <input type="number" name="amount_paid" step="0.01" class="form-control"> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </form>
@endsection