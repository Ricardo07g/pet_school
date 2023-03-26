@extends('layouts.main')

@section('title','Listagem de usuários')
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Listagem de usuários</h2>
        </div>
        <div>
            <div class="btn-group " role="group" style="margin-right: 10px; width: 200px;">
                <button id="btnGroupDrop1" type="button" class="btn btn-blue dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Opções &nbsp
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item" href="/usuario">Novo usuário</a></li>
                </ul>
            </div>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Nome</th>
            <th scope="col">Cargo</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ricardo Pereira</td>
                <td>Administrador</td>
                <td class="colum_options">
                    <span style="margin-right: 5px;" >
                        <a type="button" class="btn btn-primary" href="/usuario?i=1">
                            <span class="bi bi-brush"></span> 
                        </a>
                    </span>
                    <span>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <span class="bi bi-trash"></span>
                        </button>
                    </span>
                </td>
            </tr>
            <tr>
                <td>Rayane Gabrielle vieira lemos</td>
                <td>Coordenador</td>
                <td class="colum_options">
                    <span style="margin-right: 5px;" >
                        <a type="button" class="btn btn-primary" href="/usuario?i=2">
                            <span class="bi bi-brush"></span> 
                        </a>
                    </span>
                    <span>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <span class="bi bi-trash"></span>
                        </button>
                    </span>
                </td>
            </tr>
            <tr>
                <td>Bento Paulo</td>
                <td>Instrutor</td>
                <td class="colum_options">
                    <span style="margin-right: 5px;" >
                        <a type="button" class="btn btn-primary" href="/usuario?i=3">
                            <span class="bi bi-brush"></span> 
                        </a>
                    </span>
                    <span>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <span class="bi bi-trash"></span>
                        </button>
                    </span>
                </td>
            </tr>
            <tr>
                <td>Vincent Paulo</td>
                <td>Instrutor</td>
                <td class="colum_options">
                    <span style="margin-right: 5px;" >
                        <a type="button" class="btn btn-primary" href="/usuario?i=4">
                            <span class="bi bi-brush"></span> 
                        </a>
                    </span>
                    <span>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <span class="bi bi-trash"></span>
                        </button>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>


<!-- Modal -->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Atenção!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body font-black">
        Deseja realmente remover este registro?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-blue" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger">Remover</button>
      </div>
    </div>
  </div>
</div>
@endsection
