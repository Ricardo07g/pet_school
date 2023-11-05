@extends('layouts.main')
@section('title','Listagem de cargos')
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Listagem de cargos</h2>
        </div>
        <div class="itens-titulo-pagina">
            <div class="btn-group " role="group" style="margin-right: 10px; width: 200px;">
                <button id="btnGroupDrop1" type="button" class="btn btn-blue dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Opções &nbsp
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item" href="/funcoes_funcionario_form">Novo Cargo</a></li>
                </ul>
            </div>
        </div>
    </div>
    @if(count($cargos_funcionario) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Descrição</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cargos_funcionario as $key => $grupo)
                    <tr>
                        <td><?php echo $grupo->descricao;?></td>
                        <td class="colum_options">
                            <span style="margin-right: 5px;">
                                <a 
                                    type="button" 
                                    class="btn btn-primary" 
                                    href="/funcoes_funcionario_form?i=<?php echo $grupo->id_cargo;?>"
                                >
                                    <span class="bi bi-brush"></span> 
                                </a>
                            </span>
                            <span class="btn_remover_registro" id="<?php echo $grupo->id_cargo;?>">
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
            <strong>Não existem cargos a serem listados</strong>
        </div>
    @endif

<script>
    $( document ).ready(function() {
    
        $(".btn_remover_registro").on("click",function(){
            showModalRemove('Atenção!', 'Deseja realmente remover este cargo?', "Remover", "Cancelar", () => {
                $(".modal-success-btn").prop('disabled', true);

                $.ajax({
                    type: "POST",
                    url: '/funcoes_funcionario/remove',
                    data: {id: $(this).attr('id'), _token: '{{csrf_token()}}'},
                    success: function (data) {
                        console.log(data);
                        $('#staticBackdrop').remove();
                        $('.modal-backdrop').remove();
                        
                        if(data.status ==  "sucesso")
                        {   
                            swal({
                                icon:'success',
                                text:"Cargo de Funcionário removido com sucesso!",
                                type:'success'
                            }).then((value) => {
                                location.reload();
                            }).catch(swal.noop);

                        }else{
                            
                            let mensagem = (data.msg) ? data.msg : 'Algo não funcionou corretamente. \n Por favor, procure o administrador do sistema.';

                            swal({
                                icon: 'error',
                                text: mensagem,
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