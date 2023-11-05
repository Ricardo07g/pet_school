@extends('layouts.main')
<?php $titulo = !empty($_GET['i']) ? 'Editar cargo do funcionário' : 'Cadastrar cargo do funcionário';?>
@section('title',$titulo)
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Formulário do cargo do funcionário</h2>
        </div>
    </div>
    
    <div class="content-page">
        @if(isset($id) && empty($cargo_funcionario))
        <div class="div_alert">
            Atenção! Cargo não encontrado.
        </div>
        @endif
        <form class="row g-3" id="form-cargo-funcionario" action="<?php echo !empty($_GET['i']) ? '/funcoes_funcionario/edita/'.$_GET['i'].'' : '/funcoes_funcionario/novo';?>" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <label for="inputDescricao" class="form-label">Descrição*:</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="descricao"  
                        name="descricao" 
                        value="<?php echo !empty($_GET['i']) ? $cargo_funcionario->descricao : NULL ; ?>" 
                    >
                    <span id="descricao_checagem" class="checagem"></span> 
                </div>
            </div>
            <div class="col-12">
                <a class="btn btn-secondary" href="/funcoes_funcionario" role="button" style="width: 150px;">Voltar</a>
                <a id="btn_salvar" class="btn btn-blue" style="width: 150px;"> Salvar </a>
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
                $('#form-cargo-funcionario').submit();
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
