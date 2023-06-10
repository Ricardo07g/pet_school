@extends('layouts.main')

@section('title','Listagem de usuários')
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Listagem de Funcionários</h2>
        </div>
        <div class="itens-titulo-pagina">
            <div style="margin-right: 10px; width: 200px;">
                <select class="form-select form-select" aria-label=".form-select-lg example" style="text-align: center;">
                    <option value="-1">Todos</option>    
                    <option value="1">Ativos</option>
                    <option value="0">Inativos</option>    
                </select>
            </div>
            <div class="btn-group " role="group" style="margin-right: 10px; width: 200px;">
                <button id="btnGroupDrop1" type="button" class="btn btn-blue dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Opções &nbsp
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item" href="/usuario">Novo Funcionário</a></li>
                </ul>
            </div>
        </div>
    </div>
    @if(count($funcionarios) > 0)
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
            @foreach ($funcionarios as $key => $funcionario)
                <tr>
                    <td><?php echo $funcionario->nome.' '.$funcionario->sobrenome;?></td>
                    <td><?php echo $funcionario->cargo; ?></td>
                    <td><?php echo ($funcionario->ativo == 1) ? 'ATIVO' : 'INATIVO';?></td>
                    <td class="colum_options">
                        <span style="margin-right: 5px;" >
                            <a type="button" class="btn btn-primary" href="/funcionario?i=<?php echo $funcionario->id_funcionario;?>">
                                <span class="bi bi-brush"></span> 
                            </a>
                        </span>
                        <span class="btn_remover_registro" id="<?php echo $funcionario->id_funcionario;?>">
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
            <strong>Não existem Funcionários a serem listados</strong>
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
            showModalRemove('Atenção!', 'Deseja realmente remover este Funcionário?', "Remover", "Cancelar", () => {
                $(".modal-success-btn").prop('disabled', true);

                $.ajax({
                    type: "POST",
                    url: '/funcionario/remove',
                    data: {id: $(this).attr('id'), _token: '{{csrf_token()}}'},
                    success: function (data) {

                        $('#staticBackdrop').remove();
                        $('.modal-backdrop').remove();
                        
                        if(data.status ==  "sucesso")
                        {   
                            swal({
                                icon:'success',
                                text:"Funcionário removido com sucesso!",
                                type:'success'
                            }).then((value) => {
                                location.reload();
                            }).catch(swal.noop);

                        }else{
                            
                            swal({
                                icon: 'error',
                                text: 'Não foi possível remover este funcionário. \n Por favor, procure o administrador do sistema.',
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

        $('#select_ativos').on("change",function(){
            
            var url = window.location.href;    

            let value = $("#select_ativos").val();
            
            if(typeof value != 'undefined')
            {
                location.href = URL_add_parameter(url, 'a', value);
            }  
        });

    });
</script>
@endsection
