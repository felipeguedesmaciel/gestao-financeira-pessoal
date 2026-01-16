@extends('layout.main')

@section('title', 'GF - Dashboard')

@section('content')
@if (isset($user))
        <p style="color: white; padding-left:20px;">Olá, {{ $user->name }}.</p>
@endif
    <section>
        <h2>Saldo total: R${{ number_format($saldo, 2, ',', '.') }}</h2>
    </section>
    <section>
        <h2>Este Mês:</h2>
        <ul class="list-dasboard">
            <li>Entradas <p>R$0.00</p></li>
            <li>Saídas <p>R$0.00</p></li>
            <li>Saldo <p>{{ number_format($saldoM, 2, ',', '.') }}</p></li>
        </ul>
        <div>
            <h3>Categorias Inseridas</h3>
                <div class="container my-5">
                    <div class="row g-3">
                        @forelse ($categoryTotals as $category => $data)
                            <div class="col-4 col-md-4">
                                <div class="card bg-main">
                                    <div id="card-category" class="card-body">
                                        <p>{{ $category }}</p>
                                        <p>R$ {{ number_format($data->total, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>Sem categorias neste mês</p>
                      @endforelse
                    </div>
            </div>
            
            <h3>Próximos Vencimento</h3>
                <form action="{{ route('itens.updateStatus') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Descrição</th>
                        <th>Vencimento</th>
                        <th>Valor</th>
                        <th>Pago</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($upcomingPayments as $payment)
                        <tr>
                            <td>{{ $payment->category }}</td>
                            <td>{{ $payment->description }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                            <td>R$ {{ number_format($payment->value, 2, ',', '.') }}</td>
                            <td class="col-table">
                                <div class="btn-checkbox">
                                    <input type="checkbox" name="item_ids[]" value="{{ $payment->id }}" class="item-checkbox">
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Sem pagamentos pendentes</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
                <div class="btn-list-sv">
                    <a href="#" class="btn btn-outline-primary">Editar direto na lista <img src="img/write.png" alt=""></a>
                    <button class="btn btn-primary btn-line" type="submit"><span>Salvar</span><ion-icon id="icon-btn" class="ms-2" name="checkbox"></ion-icon></button>
                </div>
            </form>
        </div>
    </section>
    <section>
        <h2>Próximo Mês:</h2>
        <ul class="list-dasboard">
            <li>Entradas <p>R$0.00</p></li>
            <li>Saídas <p>R$0.00</p></li>
            <li>Saldo <p>R$0.00</p></li>
        </ul>
        <div>
            <h3>Categorias Inseridas</h3>
            <div class="container my-5">
                <div class="row g-3">
                    @forelse ($nextCategoryTotals as $category => $data)
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>{{ $category }}</p>
                                    <p>R$ {{ number_format($data->total, 2, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">Sem categorias com vencimento no próximo mês</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <section id="year">
        <h2>
            Ano:
            <!-- botão que abre modal para alterar ano -->
            <a href="#" data-bs-toggle="modal" data-bs-target="#selectYearModal" style="color:inherit; text-decoration:underline;">
                {{ $selectedYear }}
            </a>
        </h2>

        <!-- Modal para selecionar ano -->
        <div class="modal fade" id="selectYearModal" tabindex="-1" aria-labelledby="selectYearModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
            <form action="{{ route('dashboard') }}#year" method="GET"> <!-- envia year via query -->
                <div class="modal-header">
                <h5 class="modal-title" id="selectYearModalLabel">Selecionar Ano</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                <label class="form-label">Ano</label>
                <input type="number" name="year" class="form-control" min="1900" max="3000" value="{{ $selectedYear }}">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Selecionar</button>
                </div>
            </form>
            </div>
        </div>
        </div>

        <div>
            <h3>Categorias Inseridas</h3>
            <div class="container my-5">
                <div class="row g-3">
                    @forelse ($yearCategoryTotals as $category => $data)
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>{{ $category }}</p>
                                    <p>R$ {{ number_format($data->total, 2, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">Sem categorias registradas para {{ $selectedYear }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- SEÇÕES DE RESERVAS DINÂMICAS -->
    @forelse ($sectionsWithTransactions as $section)
        <section class="box-extra">
            <h2>{{ $section['section']->name }}</h2>
            <table>
                <tr>
                    <td>Valor Depositado:</td>
                    <td>R${{ number_format($section['depositedAmount'] ?? 0, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Valor Sacado:</td>
                    <td>R${{ number_format($section['totalWithdrawals'] ?? 0, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Valor Total:</td>
                    <td>R${{ number_format($section['section']->total_value, 2, ',', '.') }}</td>
                </tr>
                @if ($section['section']->target_value)
                <tr>
                    <td>Meta:</td>
                    <td>R${{ number_format($section['section']->target_value, 2, ',', '.') }}</td>
                </tr>
                @endif
            </table>
        </section>
    @empty
        <section class="box-extra">
            <h2>Nenhuma Reserva Criada</h2>
            <p>Clique no botão "+" para adicionar uma reserva.</p>
        </section>
    @endforelse
    
    <!-- SEÇÃO DE DÍVIDAS DINÂMICAS -->
    <section class="box-extra">
        <h2>Dívidas a Quitar</h2>
        @forelse ($debts as $debt)
            <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                <h4>{{ $debt->name }}</h4>
                <table style="width: 100%;">
                    <tr>
                        <td><strong>Valor Inicial:</strong></td>
                        <td>R${{ number_format($debt->initial_value, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Valor Acordado:</strong></td>
                        <td>R${{ number_format($debt->agreed_value ?? 0, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diferença:</strong></td>
                        <td>R${{ number_format($debt->initial_value - ($debt->agreed_value ?? 0), 2, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        @empty
            <p>Nenhuma dívida registrada.</p>
        @endforelse
    </section>
    <!-- <div class="back-btn">
        <a href="#">
            <ion-icon id="btn-add" name="add-circle"></ion-icon>
        </a>
    </div> -->
    <div class="back-btn">
        <a href="#" data-bs-toggle="modal" data-bs-target="#opcoesItems">
            <ion-icon id="btn-add" name="add-circle"></ion-icon>
        </a>
    </div>
    <!-- Modal de cadastro de item COMPRA -->
    <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form action="/itens" method="POST">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="itemModalLabel">Nova Compra</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Categoria</label>

                  <select id="category_select" class="form-control">
                      <option value="">Selecione...</option>
                      @foreach($categories as $cat)
                          <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>
                             {{ $cat }}
                          </option>
                      @endforeach
                      <option value="nova" {{ (old('category') && !in_array(old('category'), $categories->toArray())) ? 'selected' : '' }}>Adicionar nova Categoria</option>
                  </select>

                  <!-- valor final enviado -->
                  <input type="hidden" name="category" id="category_input" value="{{ old('category') }}">

                  <!-- campo para categoria livre -->
                  <div id="category_other_group" style="{{ (old('category') && !in_array(old('category'), $categories->toArray())) ? '' : 'display:none' }}; margin-top:8px;">
                      <input type="text" id="category_other" class="form-control" placeholder="Digite a nova categoria" value="{{ (old('category') && !in_array(old('category'), $categories->toArray())) ? old('category') : '' }}">
                  </div>

                   @error('category') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label">Valor</label>
                  <input type="number" step="0.01" name="value" value="{{ old('value') }}" class="form-control">
                  @error('value') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label">Data da Compra</label>
                  <input type="date" name="date" value="{{ old('date') }}" class="form-control">
                  @error('date') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label">Método de Pagamento</label>
                  <input type="text" name="payment_method" value="{{ old('payment_method') }}" class="form-control">
                </div>
                    <!-- Status: checkbox (Pago por padrão) -->
                <div class="mb-3">
                <label class="form-label">Status</label>

                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status_paid" value="Paid" checked>
                    <label class="form-check-label" for="status_paid">Pago</label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="status_tobepaid" value="To be paid">
                    <label class="form-check-label" for="status_tobepaid">A pagar</label>
                  </div>
                </div>

                <!-- Condição de pagamento: select puxando payment_terms + opção Adicionar outra -->
                 <div class="col-md-6">
                    <label for="title">Condição de Pagamento</label>
                    <select class="form-control" name="type" id="type">
                        <option value="">Selecione...</option>
                        <!-- @foreach($type as $ty)
                          <option value="{{ $ty }}" {{ old('category') === $ty ? 'selected' : '' }}>
                             {{ $ty }}
                          </option>
                      @endforeach -->
                      <option value="Á Vista">Á Vista</option>
                      <option value="Mensal">Mensal</option>
                      <option value="Parcelado">Parcelado</option>
                    </select>
                    <div id="installment_other_group" style="{{ old('type') == 'Parcelado' ? '' : 'display:none' }}; margin-top:8px;">
                        <label for="title">Número de Parcelas</label>
                        <input type="number" name="installment" id="installment" min="1" class="form-control" placeholder="Número de parcelas" value="{{ old('installment') }}">
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
                    </div>
                    @error('installment') 
                        <div class="text-danger small">{{ $message }}</div> 
                    @enderror
                </div>
                <div class="col-12">
                  <label class="form-label">Descrição</label>
                  <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
                <!-- campos opcionais -->
                <input type="hidden" name="unit_id" value="{{ old('unit_id', 1) }}">
                <input type="hidden" name="condition_id" value="{{ old('condition_id', 1) }}">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

     <!-- Modal de cadastro de item 2  RECEBIMENTO -->
    <div class="modal fade" id="itemModal2" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form action="{{ route('itens.store') }}" method="POST">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="recebimentoModalLabel">Novo Recebimento</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Categoria</label>
                  <input type="text" name="category" value="{{ old('category') }}" class="form-control">
                  @error('category') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label">Valor</label>
                  <input type="number" step="0.01" name="value" value="{{ old('value') }}" class="form-control">
                  @error('value') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label">Data</label>
                  <input type="date" name="date" value="{{ old('date') }}" class="form-control">
                  @error('date') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label">Método de Pagamento</label>
                  <input type="text" name="payment_method" value="{{ old('payment_method') }}" class="form-control">
                </div>
                <div class="col-12">
                  <label class="form-label">Descrição</label>
                  <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
                <!-- campos opcionais -->
                <input type="hidden" name="unit_id" value="{{ old('unit_id', 1) }}">
                <input type="hidden" name="condition_id" value="{{ old('condition_id', 1) }}">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal de opções de Itens -->
    <div class="modal fade" id="opcoesItems" aria-hidden="true" aria-labelledby="opcoesItemsLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="opcoesItemsLabel">Opções</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Escolha uma das opções para adicionar.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#itemModal" data-bs-toggle="modal">Adicionar Compra</button>
                    <button class="btn btn-success" data-bs-target="#itemModal2" data-bs-toggle="modal">Adicionar Recebimento</button>
                    <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Criar Nova Sessão
                    </button>
                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item" type="button"  data-bs-target="#reservaModal" data-bs-toggle="modal">Reserva</button></li>
                        <li><button class="dropdown-item" type="button"  data-bs-target="#dividaModal" data-bs-toggle="modal">Divida / Renegociação</button></li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de cadastro de RESERVA -->
    <div class="modal fade" id="reservaModal" tabindex="-1" aria-labelledby="reservaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form action="{{ route('sections.store') }}" method="POST">
            @csrf
            <div class="modal-header">
            <h5 class="modal-title" id="reservaModalLabel">Adicionar Reserva</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-6">
                <label class="form-label" for="name">Nome da Reserva</label>
                <select name="name" class="form-control" required>
                    <option value="">Selecione...</option>
                    <option value="Reserva de Emergência">Reserva de Emergência</option>
                    <option value="Reserva de Oportunidade">Reserva de Oportunidade</option>
                </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="total_value">Depósito Inicial</label>
                    <input type="number" name="total_value" step="0.01" class="form-control" required>
                </div>
                <div class="col-md-6">
                <label for="target_value" class="form-label">Meta</label>
                <input type="number" step="0.01" name="target_value" class="form-control" placeholder="Ex: 5000.00">
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </form>
        </div>
    </div>
    </div>
    <!-- Modal de cadastro de DÍVIDA -->
    <div class="modal fade" id="dividaModal" tabindex="-1" aria-labelledby="dividaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form action="{{ route('debts.store') }}" method="POST">
            @csrf
            <div class="modal-header">
            <h5 class="modal-title" id="dividaModalLabel">Adicionar Dívida</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-6">
                <label class="form-label" for="name">Nome da Dívida</label>
                <input type="text" name="name" class="form-control" placeholder="Ex: TV, Casa" required>
                </div>
                <div class="col-md-6">
                <label class="form-label" for="initial_debt_amount">Valor Inicial</label>
                <input type="number" step="0.01" name="initial_debt_amount" class="form-control" placeholder="Ex: 2500.00" required>
                </div>
                <label for="agreed_value" class="form-label">Ouve Acordo?:</label>
                <select name="agreed_value" id="agreed_value">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
                <div id="agreement_fields" style="display:none;">
                    <div class="col-md-6">
                        <label class="form-label" for="agreed_value">Valor Acordado</label>
                        <input type="number" step="0.01" name="agreed_value" class="form-control" placeholder="Ex: 1500.00">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="payment_method">Condição de pagamento</label>
                        <select name="payment_method">
                            <option value="À vista">À vista</option>
                            <option value="Parcelado">Parcelado</option>
                        </select>
                        <div id="installment_fields" style="display:none;">
                            <label class="form-label" for="installments">Número de parcelas</label>
                            <input type="number" name="installments">

                            <label class="form-label" for="installment_value">Valor da Parcela</label>
                            <input type="number" name="installment_value" step="0.01">

                            <label class="form-label" for="amount_paid">Valor já pago:</label>
                            <input type="number" name="amount_paid" step="0.01">
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </form>
        </div>
    </div>
    </div>
@endsection