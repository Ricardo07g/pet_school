@extends('layouts.main')
<?php $titulo = !empty($_GET['i']) ? 'Editar grupo de usuário' : 'Cadastrar grupo de usuário';?>
@section('title',$titulo)
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Formulário do grupo de usuário</h2>
        </div>
    </div>
    
    <div class="content-page">
        @if(!isset($id) && count($grupo_usuario) == 0)
        <div class="div_alert">
            Atenção! Grupo de usuário não encontrado.
        </div>
        @elseif(isset($id) && @$grupo_usuario->nativo == 1)
        <div class="div_alert" style="margin-bottom: 20px;">
            Atenção! Um grupo de usuário 'nativo' não pode ser editado.
        </div>
        @endif
        <form class="row g-3" id="form-grupo-usuario" action="<?php echo !empty($_GET['i']) ? '/grupos_usuario/edita/'.$_GET['i'].'' : '/grupos_usuario/novo';?>" method="POST">
            @csrf
            @if(isset($id) && @$grupo_usuario->nativo == 0 || !isset($id))
            <div class="row">
                <div class="col-md-3">
                    <label for="inputDescricao" class="form-label">Descrição*:</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="descricao"  
                        name="descricao" 
                        value="<?php echo !empty($_GET['i']) ? $grupo_usuario->descricao : NULL ; ?>" 
                    >
                    <span id="descricao_checagem" class="checagem"></span> 
                </div>
            </div>
            @endif
            <div class="col-12">
                <a class="btn btn-secondary" href="/grupos_usuario" role="button" style="width: 150px;">Voltar</a>
                @if(isset($id) && @$grupo_usuario->nativo == 0 || !isset($id))
                <a 
                    id="btn_salvar"
                    class="btn btn-blue" 
                    style="width: 150px;"
                    <?php echo (!isset($id) && count($grupo_usuario) == 0) ? 'disabled' :'' ; ?> 
                >
                    Salvar
                </a>
                @endif
            </div>
        </form>
    </div>

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

        $('#btn_salvar').click(function(){
            if(validacao_campos_formulario() == true)
            {
                $('#form-grupo-usuario').submit();
            }
        });
    });


    function validacao_campos_formulario()
    {   
        let erros = 0;

        $("#descricao_checagem").html("");

        if(typeof $('#descricao').val() == 'undefined' || $('#descricao').val() == "")
        {   
            $("#descricao_checagem").html("obrigatório.");
            $("#descricao_checagem").css("display", "block");
            erros++;
        } 

        return (erros == 0) ? true : false;
    }

</script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script> -->

    
@endsection
