<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS da Aplicação -->
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/medias.css">
    <!-- Font do Google -->
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- JS da Aplicação -->
    <script src="js/management.js" defer></script>
    <title>@yield('title')</title>
</head>
<body>
    <header>
        @guest
        <h1 id="initial-title">Gestão Financeira Pessoal</h1>
        @endguest
        @auth
        <ion-icon onclick="clickMenu()" id="burguer" name="reorder-three-sharp"></ion-icon>
        <h1>Gestão Financeira Pessoal</h1>
        <p>Previsão: <button>on/off</button></p>
        <menu id="itens">
            <ion-icon onclick="clickMenu()" name="close" id="close"></ion-icon>
            <ul>
                <li><a href="#itemModal" data-bs-toggle="modal" data-bs-target="#itemModal">Adicionar Compra</a></li>
                <li><a href="#">Adicionar Recebimento</a></li>
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <a href="/logout"
                            onclick="event.preventDefault();
                            this.closest('form').submit();"
                        >
                        Sair<ion-icon name="log-out-outline"></ion-icon> </a>
                    </form>
                </li>
            </ul>
        </menu>
        @endauth
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>Desenvolvido por <a href="https://felipeguedesmaciel.github.io/portifolio/" target="_blank">Felipe Maciel</a>&copy;</p>
    </footer>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <script>
    document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('category_select');
    const otherGroup = document.getElementById('category_other_group');
    const otherInput = document.getElementById('category_other');
    const hidden = document.getElementById('category_input');

    function updateHidden() {
        if (!select) return;
        if (select.value === 'nova') {
        otherGroup.style.display = '';
        hidden.value = otherInput.value || '';
        } else {
        otherGroup.style.display = 'none';
        hidden.value = select.value;
        }
    }

    if (select) {
        select.addEventListener('change', updateHidden);
        if (otherInput) otherInput.addEventListener('input', function () {
        if (select.value === 'nova') hidden.value = otherInput.value;
        });
        // inicializa
        updateHidden();
    }
    });

    //Condição de Pagamento type  Parcelado
    document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const installmentGroup = document.getElementById('installment_other_group');
    const installmentInput = document.getElementById('installment');

    if (!typeSelect || !installmentGroup || !installmentInput) return;

    function toggleInstallment() {
        if (typeSelect.value === 'Parcelado') {
        installmentGroup.style.display = '';
        installmentInput.required = true;
        } else {
        installmentGroup.style.display = 'none';
        installmentInput.required = false;
        // opcional: limpar valor quando não é parcelado
        // installmentInput.value = '';
        }
    }

    typeSelect.addEventListener('change', toggleInstallment);
    toggleInstallment();
    });


    // Placeholder do Dia do Vencimento pegando a data da primeira parcela

        document.addEventListener('DOMContentLoaded', function () {
            const firstDate = document.getElementById('payment_date');
            const payDay = document.getElementById('payment_day');

            if (firstDate && payDay) {
                firstDate.addEventListener('change', function (e) {
                    const v = e.target.value; // formato esperado: YYYY-MM-DD
                    if (!v) return;
                    const parts = v.split('-');
                    if (parts.length !== 3) return;
                    const day = parseInt(parts[2], 10);
                    if (isNaN(day)) return;
                    payDay.value = day;
                });
            }
        });
    </script>
</body>
</html>