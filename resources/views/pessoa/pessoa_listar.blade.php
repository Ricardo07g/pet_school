@extends('layouts.main')

@section('title','Listagem de usuários')
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Listagem de Pessoas</h2>
        </div>
        <div class="itens-titulo-pagina">
            <div class="btn-group " role="group" style="margin-right: 10px; width: 200px;">
                <button id="btnGroupDrop1" type="button" class="btn btn-blue dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Opções &nbsp
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item" href="/pessoa">Nova Pessoa</a></li>
                </ul>
            </div>
        </div>
    </div>
    @if(count($pessoas) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Nome</th>
                <th scope="col">Data de Nascimento</th>
                <th scope="col">CPF</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($pessoas as $key => $pessoa)
                <tr>
                    <td><?php echo $pessoa->nome?></td>
                    <td><?php echo date('d/m/Y', strtotime($pessoa->dt_nascimento)); ?></td>
                    <td><?php echo $pessoa->cpf?></td>
                    <td class="colum_options">
                        <span style="margin-right: 5px;" >
                            <a type="button" class="btn btn-primary" href="/pessoa?i=<?php echo $pessoa->id_pessoa;?>">
                                <span class="bi bi-brush"></span> 
                            </a>
                        </span>
                        <span class="btn_remover_registro" id="<?php echo $pessoa->id_pessoa;?>">
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
            <strong>Não existem Pessoas a serem listadas</strong>
        </div>
    @endif


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

<script>
    $( document ).ready(function() {
    
        $(".btn_remover_registro").on("click",function(){
            showModalRemove('Atenção!', 'Deseja realmente remover esta Pessoa?', "Remover", "Cancelar", () => {
                $(".modal-success-btn").prop('disabled', true);

                $.ajax({
                    type: "POST",
                    url: '/pessoa/remove',
                    data: {id: $(this).attr('id'), _token: '{{csrf_token()}}'},
                    success: function (data) {

                        $('#staticBackdrop').remove();
                        $('.modal-backdrop').remove();
                        
                        if(data.status ==  "sucesso")
                        {   
                            swal({
                                icon:'success',
                                text:"Pessoa removida com sucesso!",
                                type:'success'
                            }).then((value) => {
                                location.reload();
                            }).catch(swal.noop);

                        }else{
                            
                            swal({
                                icon: 'error',
                                text: 'Não foi possível remover esta pessoa. \n Por favor, procure o administrador do sistema.',
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
@endsection
