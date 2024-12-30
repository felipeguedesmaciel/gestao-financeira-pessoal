@extends('layout.main')

@section('title', 'GF - Dashboard')

@section('content')
@if (isset($user))
        <p style="color: white; padding-left:20px;">Olá, {{ $user->name }}.</p>
@endif
    <section>
        @php
        $saldo = 0.00;
        $saldoM = 0.00;
        $dateM = date("m/Y");
        foreach ($itens as $item){
            $saldo += $item->value;
            if(date("m/Y", strtotime($item->date)) == $dateM){
                $saldoM += $item->value;
            }
         }
        @endphp
        <h2>Saldo total: R${{$saldo}}</h2>     
    </section>
    <section>
        <h2>Este Mês:</h2>
        <ul class="list-dasboard">
            <li>Entradas <p>R$0.00</p></li>
            <li>Saídas <p>R$0.00</p></li>
            <li>Saldo <p>{{$saldoM}}</p></li>
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
    <div class="back-btn">
        <a href="#">
            <ion-icon id="btn-add" name="add-circle"></ion-icon>
        </a>
    </div>
@endsection