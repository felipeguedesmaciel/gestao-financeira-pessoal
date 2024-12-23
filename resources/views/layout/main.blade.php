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
                <li><a href="#">Adicionar Compra</a></li>
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
        <p>Desenvolvido por <a href="#">Felipe Maciel</a>&copy;</p>
    </footer>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>