<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS da Aplicação -->
    <link rel="stylesheet" href="style/style.css">
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <h1>Gestão Financeira Pessoal</h1>
        <p>Previsão: <button>on/off</button></p>
        <nav>

        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>Desenvolvido por <a href="#">Felipe Maciel</a>&copy;</p>
    </footer>
</body>
</html>