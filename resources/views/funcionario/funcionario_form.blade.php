@extends('layouts.main')

@section('title','Inicio')
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Formulário do usuário</h2>
        </div>
        <!--
        <div>
            <div class="btn-group" role="group" style="margin-right: 10px; width: 200px;">
                <a class="btn btn-blue" href="/usuarios" role="button">Voltar</a>
            </div>
        </div>
        -->
    </div>
    
    @if(isset($id))
       
    @endif
    <div class="content-page">
        <form class="row g-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="inputCPF" class="form-label">cpf</label>
                    <input type="text" class="form-control" id="cpf" placeholder="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="inputNome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome">
                </div>
                <div class="col-md-6">
                    <label for="inputSobrenome" class="form-label">Sobrenome</label>
                    <input type="text" class="form-control" id="sobrenome">
                </div>
                <div class="col-md-3">
                    <label for="inputDt_nascimento" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="dt_nascimento">
                </div>
            </div>
            <div class="col-12">
                <a class="btn btn-secondary" href="/usuarios" role="button">Voltar</a>
                <button type="submit" class="btn btn-blue">Salvar</button>
            </div>
        </form>
    </div>
    
    @endsection
