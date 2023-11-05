@extends('layouts.main')
@section('title','Configurações')
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Configurações</h2>
        </div>
    </div>
    
    <div class="content-page">

        <div class="row grid-config">
            <div class="col-sm">
              <a class="btn btn-secondary grid-btn" type="button" href="/grupos_usuario">Grupos de usuário</a>
            </div>

            <div class="col-sm">
              <a class="btn btn-secondary grid-btn" type="button" href="/funcoes_funcionario">Cargos do Funcionário</a>
            </div>

            <div class="col-sm">
             <button class="btn btn-secondary grid-btn" type="button" disabled>Em breve</button>
            </div>
        </div>

        <div class="row grid-config">
            <div class="col-sm">
              <button class="btn btn-secondary grid-btn" type="button" disabled>Em breve</button>
            </div>

            <div class="col-sm">
              <button class="btn btn-secondary grid-btn" type="button" disabled>Em breve</button>
            </div>

            <div class="col-sm">
             <button class="btn btn-secondary grid-btn" type="button" disabled>Em breve</button>
            </div>
        </div>

    </div>    
@endsection
