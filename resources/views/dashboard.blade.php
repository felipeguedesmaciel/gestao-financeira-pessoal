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
                        @foreach ($itens as $item)
                            <div class="col-4 col-md-4">
                                <div class="card bg-main">
                                    <div id="card-category" class="card-body">
                                        <p>{{$item->category}}</p>
                                        <p>{{$item->value}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>Casa</p><p>R$0.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>Carro</p><p>R$0.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>Mercado</p><p>R$0.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>Internet</p><p>R$0.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>Outros</p><p>R$0.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>Viagens</p><p>R$0.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div>
            <h3>Próximos Vencimento</h3>
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Vencimento</th>
                        <th>Valor</th>
                        <th>Pago</th>
                    </tr>
                </thead>
                <tr>
                    <td>Carro</td>
                    <td>10/02/2024</td>
                    <td>R$0.00</td>
                    <td class="col-table">
                        <div class="btn-checkbox">
                            <input type="checkbox" name="pago" id="pago" >
                            <label for="pago"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Casa</td>
                    <td>10/02/2024</td>
                    <td>R$0.00</td>
                    <td>
                        <div class="btn-checkbox">
                            <input type="checkbox" name="pago" id="pago" >
                            <label for="pago"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Mercado</td>
                    <td>10/02/2024</td>
                    <td>R$0.00</td>
                    <td>
                        <div class="btn-checkbox">
                            <input type="checkbox" name="pago" id="pago" >
                            <label for="pago"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Outros</td>
                    <td>10/02/2024</td>
                    <td>R$0.00</td>
                    <td>
                        <div class="btn-checkbox">
                            <input type="checkbox" name="pago" id="pago" >
                            <label for="pago"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Internet</td>
                    <td>10/02/2024</td>
                    <td>R$0.00</td>
                    <td>
                        <div class="btn-checkbox">
                            <input type="checkbox" name="pago" id="pago" >
                            <label for="pago"></label>
                        </div>
                    </td>
                </tr>
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
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>Casa</p><p>R$0.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>Carro</p><p>R$0.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>Mercado</p><p>R$0.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>Internet</p><p>R$0.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>Outros</p><p>R$0.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="card bg-main">
                                <div id="card-category" class="card-body">
                                    <p>Viagens</p><p>R$0.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
    <section>
        <h2>Ano:2023</h2>
            <div>
                <h3>Categorias Inseridas</h3>
                    <div class="container my-5">
                        <div class="row g-3">
                            <div class="col-4 col-md-4">
                                <div class="card bg-main">
                                    <div id="card-category" class="card-body">
                                        <p>Casa</p><p>R$0.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-4">
                                <div class="card bg-main">
                                    <div id="card-category" class="card-body">
                                        <p>Carro</p><p>R$0.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-4">
                                <div class="card bg-main">
                                    <div id="card-category" class="card-body">
                                        <p>Mercado</p><p>R$0.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    </section>
    <section class="box-extra">
        <h2>Reserva de Emergência</h2>
        <table>
            <tr>
                <td>Valor Depositado:</td>
                <td>R$0.00</td>
            </tr>
            <tr>
                <td>Meta de Valor:</td>
                <td>R$0.00</td>
            </tr>
            <tr>
                <td>Ainda Falta</td>
                <td>R$0.00</td>
            </tr>
        </table>
    </section>
    <section class="box-extra">
        <h2>Reserva de Oportunidades</h2>
        <table>
            <tr>
                <td>Valor Depositado:</td>
                <td>R$0.00</td>
            </tr>
        </table>
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

    <div class="modal fade" id="opcoesItems" aria-hidden="true" aria-labelledby="opcoesItemsLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="opcoesItemsLabel">Opções</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Escolha uma das 2 opções para adicionar.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#itemModal" data-bs-toggle="modal">Adicionar Compra</button>
                    <button class="btn btn-success" data-bs-target="#itemModal2" data-bs-toggle="modal">Adicionar Recebimento</button>
                </div>
            </div>
        </div>
    </div>

@endsection