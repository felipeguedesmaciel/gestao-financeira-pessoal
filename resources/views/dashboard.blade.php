@extends('layout.main')

@section('title', 'Gestão Financeira')

@section('content')
@foreach ($users as $user)
 
<p>{{ $user->name }}</p>

@endforeach
    <section>
        <h2>Saldo total: R$0.000,00</h2>
    </section>
    <section>
        <h2>Este Mês</h2>
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
                <div class="item-categoria">
                    <p>Internet</p><p>R$0.00</p>
                </div>
                <div class="item-categoria">
                    <p>Outros</p><p>R$0.00</p>
                </div>
                <div class="item-categoria">
                    <p>Viagens</p><p>R$0.00</p>
                </div>
            </div>
        </div>
        <div>
            <h3>Próximos Vencimento</h3>
            <table style="border: solid 1px black;">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Vencimento</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tr>
                    <td>Carro</td>
                    <td>10/02/2024</td>
                    <td>R$0.00</td>
                    <td>Pago</td>
                </tr>
                <tr>
                    <td>Casa</td>
                    <td>10/02/2024</td>
                    <td>R$0.00</td>
                    <td>Pago</td>
                </tr>
                <tr>
                    <td>Mercado</td>
                    <td>10/02/2024</td>
                    <td>R$0.00</td>
                    <td>Não Pago</td>
                </tr>
                <tr>
                    <td>Outros</td>
                    <td>10/02/2024</td>
                    <td>R$0.00</td>
                    <td>Não Pago</td>
                </tr>
                <tr class="butao">
                    <td>Internet</td>
                    <td>10/02/2024</td>
                    <td>R$0.00</td>
                    <td>Não Pago</td>
                </tr>
            </table>
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