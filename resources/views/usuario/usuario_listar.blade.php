@extends('layouts.main')

@section('title','Listagem de usuários')

@section('content')

    <script>
        $( document ).ready(function() {

            function remover_registro(id_usuario)
            {
                console.log("registro_a_ser_removido: "+$this);
            }
        
            $(".btn_remover_registro").on("click",function(){
                showModalRemove('Atenção!', 'Deseja realmente remover este usuário?', "Remover", "Cancelar", () => {
                    $(".modal-success-btn").prop('disabled', true);

                    $.ajax({
                        type: "POST",
                        url: '/usuario/remove',
                        data: {id: $(this).attr('id'), _token: '{{csrf_token()}}'},
                        success: function (data) {

                            console.log("response_remover_usuario: "+data);

                            $('#staticBackdrop').remove();
                            $('.modal-backdrop').remove();
                            
                            if(data.status ==  "sucesso")
                            {   
                                swal({
                                    icon:'success',
                                    text:"Usuário removido com sucesso!",
                                    type:'success'
                                }).then((value) => {
                                    location.reload();
                                }).catch(swal.noop);
                            }else{
                               
                                swal({
                                    icon: 'error',
                                    text: 'Não foi possível remover este usuário. \n Por favor, procure o administrador do sistema.',
                                    type:'error'
                                }) 
                                
                            }
                        },
                        error: function (data, textStatus, errorThrown) {
                            $('#staticBackdrop').remove();
                            $('.modal-backdrop').remove();
                            swal({
                                    icon:'error',
                                    title: 'Oops...',
                                    text:"Algo não funcionou corretamente. \n Por favor, procure o administrador do sistema.",
                                    type:'error'
                            })
                        },
                    });

                    $(".modal-success-btn").prop('disabled', false);

                    return true;
                });
            });
    
        });
    </script>

    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Listagem de usuários</h2>
        </div>
        <div class="itens-titulo-pagina">
            <div style="margin-right: 10px; width: 200px;">
                <select class="form-select form-select" aria-label=".form-select-lg example" style="text-align: center;">
                    <option value="1" selected>Ativos</option>
                    <option value="2">Inativos</option>
                    <option value="-1">Todos</option>
                </select>
            </div>
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

    @if(count($usuarios) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Nome</th>
                <th scope="col">Cargo</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($usuarios as $key => $usuario)
                <tr>
                    <td><?php echo $usuario->nome.' '.$usuario->sobrenome;?></td>
                    <td>Administrador</td>
                    <td>status</td>
                    <td class="colum_options">
                        <span style="margin-right: 5px;" >
                            <a type="button" class="btn btn-primary" href="/usuario?i=<?php echo $usuario->id_usuario;?>">
                                <span class="bi bi-brush"></span> 
                            </a>
                        </span>
                        <span class="btn_remover_registro" id="<?php echo $usuario->id_usuario;?>">
                            <button type="button" class="btn btn-danger">
                            <span class="bi bi-trash"></span>
                            </button>
                        </span>
                    </td>
                </tr>
            @endforeach 
            </tbody>
        </table>
    @else
        <div id="infongMessage" class="alert alert-info alert-block" style="text-align:center"> 
            <strong>Não existem usuários a serem listados</strong>
        </div>
    @endif
@endsection
