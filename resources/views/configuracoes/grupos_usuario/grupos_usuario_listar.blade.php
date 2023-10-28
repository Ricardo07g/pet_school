@extends('layouts.main')
@section('title','Listagem de grupos de usuário')
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Grupos de usuário</h2>
        </div>
        <div class="itens-titulo-pagina">
            <div style="margin-right: 10px; width: 200px;">
                <select id='select_ativos' name='select_ativos' class="form-select form-select" aria-label=".form-select-lg example" style="text-align: center;">
                    <option value="-1" <?php echo ($parametro_busca == -1) ? 'selected' : '';?> >Todos</option>    
                    <option value="1"  <?php echo ($parametro_busca == 1) ? 'selected' : '';?>  >Nativo</option>
                    <option value="0"  <?php echo ($parametro_busca == 0) ? 'selected' : '';?>  >Personalizado</option>    
                </select>
            </div>
            <div class="btn-group " role="group" style="margin-right: 10px; width: 200px;">
                <button id="btnGroupDrop1" type="button" class="btn btn-blue dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Opções &nbsp
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item" href="/grupos_usuario_form">Novo Grupo de usuário</a></li>
                </ul>
            </div>
        </div>
    </div>
    


    @if(count($grupos_usuario) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">Descrição</th>
                <th scope="col">Nativo</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupos_usuario as $key => $grupo)
                    <tr>
                        <td><?php echo $grupo->descricao;?></td>
                        <td><?php echo ($grupo->nativo) ? "Sim" : "Não";?></td>
                        <td class="colum_options">
                            <span style="margin-right: 5px;">
                                <a 
                                    type="button" 
                                    class="btn btn-primary <?php echo ($grupo->nativo)? 'disabled ': '';?>" 
                                    href="/grupos_usuario_form?i=<?php echo $grupo->id_grupo_usuario;?>"
                                >
                                    <span class="bi bi-brush"></span> 
                                </a>
                            </span>
                            <span class="btn_remover_registro" id="<?php echo $grupo->id_grupo_usuario;?>">
                                <button 
                                    type="button" class="btn btn-danger 
                                    <?php echo ($grupo->nativo)? 'disabled ': '';?>"
                                >
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
            <strong>Não existem grupos de usuário a serem listados</strong>
        </div>
    @endif

<script>
    $( document ).ready(function() {
    
        $(".btn_remover_registro").on("click",function(){
            showModalRemove('Atenção!', 'Deseja realmente remover este Grupo de usuário?', "Remover", "Cancelar", () => {
                $(".modal-success-btn").prop('disabled', true);

                $.ajax({
                    type: "POST",
                    url: '/grupos_usuario/remove',
                    data: {id: $(this).attr('id'), _token: '{{csrf_token()}}'},
                    success: function (data) {
                        console.log(data);
                        $('#staticBackdrop').remove();
                        $('.modal-backdrop').remove();
                        
                        if(data.status ==  "sucesso")
                        {   
                            swal({
                                icon:'success',
                                text:"Grupo de usuário removido com sucesso!",
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