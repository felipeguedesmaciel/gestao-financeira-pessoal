@extends('layout.main')

@section('title', 'Gestão Financeira')

@section('content')
@if (isset($user))
        <p style="color: white; padding-left:20px;">Olá, {{ $user->name }}.</p>
@endif
    <section>
        <h2>Saldo total: R$0.000,00</h2>
    </section>
    <section>
        <h2>Este Mês</h2>
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
                    <td>
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
            <input type="submit" class="btn btn-primary"  value="Editar Evento">
            </form>
        </div>
    </section>
    <section>
        <h2>Próximo Mês:</h2>
        <div>Entradas<p>R$0.00</p></div>
        <div>Saídas<p>R$0.00</p></div>
        <div>Saldo<p>R$0.00</p></div>
        <div>
            <h3>Categorias Inseridas</h3>
            <div class="categorias">
                <div class="item-categoria">
                    <p>Casa</p><p>R$0.00</p>
                </div>
                <div class="item-categoria">
                    <p>Carro</p><p>R$0.00</p>
                </div>
                <div class="item-categoria">
                    <p>Mercado</p><p>R$0.00</p>
                </div>
            </div>
        </div>
    </section>
    <section>
        <h2>Ano:2023</h2>
        <div>
            <h3>Categorias</h3>
            <div class="categorias">
                <div class="item-categoria">
                    <p>Casa</p><p>R$0.00</p>
                </div>
                <div class="item-categoria">
                    <p>Carro</p><p>R$0.00</p>
                </div>
                <div class="item-categoria">
                    <p>Mercado</p><p>R$0.00</p>
                </div>
            </div>
        </div>
    </section>
    <section>
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
    <section>
        <h2>Reserva de Oportunidades</h2>
        <p>Valor Depositado: R$0.00</p>
    </section>
@endsection