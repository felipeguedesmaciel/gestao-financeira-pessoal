@extends('layout.main')

@section('title', 'Gestão Financeira')

@section('content')
<div class="login">
    <h1>Entre:</h1>
    <form action="/" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" placeholder="Login">
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha">
        </div>
        <input type="submit" class="btn btn-primary" value="Entrar">
    </form>
</div>
@endsection