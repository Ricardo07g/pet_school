@extends('layouts.main')
<?php $titulo = !empty($_GET['i']) ? 'Editar pet' : 'Cadastrar pet';?>
@section('title',$titulo)
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Formulário do pet</h2>
        </div>
    </div>
    
    <div class="content-page">
        <form class="row g-3" id="form-funcionario" action="<?php echo !empty($_GET['i']) ? '/funcionario/edita/'.$_GET['i'].'' : '/funcionario/novo';?>" method="POST">
            @csrf
            @if(!isset($id) && count($dados_pessoas) > 0)
            <div class="row">
                <div class="col-md-3">
                <label for="pessoaDataList" class="form-label">Pesquise uma pessoa</label>
                <input class="form-control" list="datalistOptions" id="pessoaDataList" placeholder="Digite para pesquisar...">
                <datalist id="datalistOptions">
                    @foreach ($dados_pessoas as $key => $pessoa)
                    <option 
                        id="<?php echo $pessoa->id_pessoa; ?>" 
                        value="Nome: <?php echo $pessoa->nome_completo; ?> CPF: <?php echo $pessoa->cpf; ?> " 
                        data-idpessoa = "<?php echo $pessoa->id_pessoa; ?>"
                        data-nome = "<?php echo $pessoa->nome_completo; ?>"
                        data-cpf = "<?php echo $pessoa->cpf; ?>"
                        data-dtnascimento = "<?php echo $pessoa->dt_nascimento; ?>"
                    >
                    @endforeach 
                </datalist>
                    <span id="pessoa_checagem" class="checagem"></span> 
                </div>
            </div>
            @endif
            <div id="div_content" class="<?php echo (empty(@$_GET['i'])) ? 'invisivel': ''; ?>" >
                <div class="row">
                    <div class="col-md-3">
                        <label for="inputCPF" class="form-label">cpf</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="cpf"  
                            value="<?php echo !empty($_GET['i']) ? $funcionario->cpf : NULL ; ?>" 
                            <?php echo !empty($_GET['i']) ? 'disabled': ''; ?>
                        >
                        <span id="cpf_checagem" class="checagem"></span> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        <label for="inputNome" class="form-label">Nome Completo</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="nome" 
                            value="<?php echo !empty($_GET['i']) ? $funcionario->nome_completo : NULL ; ?>" 
                            <?php echo !empty($_GET['i']) ? 'disabled': ''; ?>
                        >
                        <span id="nome_checagem" class="checagem"></span> 
                    </div>
                    <div class="col-md-3">
                        <label for="inputDt_nascimento" class="form-label">Data de Nascimento</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="dt_nascimento" 
                            value="<?php echo !empty($_GET['i']) ? $funcionario->dt_nascimento : NULL ; ?>"
                            <?php echo !empty($_GET['i']) ? 'disabled': ''; ?>
                        >
                        <span id="dt_nascimento_checagem" class="checagem"></span> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="cargo_funcionario" class="form-label">Função*</label>
                        <select id='cargo_funcionario' name='cargo_funcionario' class="form-select">
                        <option value=""></option>
                        @foreach ($cargos_usuario as $key => $cargo_usuario) 
                            <option value="<?php echo $cargo_usuario->id_cargo; ?>" 
                                <?php echo (@$funcionario->id_cargo !== NULL && $cargo_usuario->id_cargo == @$funcionario->id_cargo) ? 'selected' : '';?> 
                            > 
                                <?php  echo $cargo_usuario->descricao; ?>
                            </option>
                        @endforeach 
                        </select>
                        <span id="cargo_checagem" class="checagem"></span> 
                    </div>
                </div>

            </div>


            <div class="row">
                @if(@$_GET['i'] == NULL)
                    <input type="hidden" id="ativo" name="ativo" value="1">
                @else
                    <div class="col-md-6">
                        <label for="ativo" class="form-label">Ativo</label>
                        <select id='ativo' name='ativo' class="form-select">
                            <option value="-1"></option>
                            <option value="1" <?php echo (@$funcionario->ativo !== NULL && $funcionario->ativo == 1) ? 'selected': '';?> >ATIVO</option>
                            <option value="0" <?php echo (@$funcionario->ativo !== NULL && $funcionario->ativo == 0) ? 'selected': '';?>>INATIVO</option>
                        </select>
                        <span id="ativo_checagem" class="checagem"></span> 
                    </div>
                @endif
            </div>

             <input type="hidden" id="id_pessoa" name="id_pessoa" value="<?php echo @$funcionario->id_pessoa; ?>">

            <div class="col-12">
                <a class="btn btn-secondary" href="/funcionarios" role="button" style="width: 150px;">Voltar</a>
                <a 
                    id="btn_salvar"
                    class="btn btn-blue" 
                    style="width: 150px;"
                    <?php echo (!isset($id) && count($dados_pessoas) == 0) ? 'disabled' :'' ; ?> 
                >
                    Salvar
                </a>
            </div>
        </form>
    </div>

<script>
    $( document ).ready(function() {

        $('#btn_salvar').click(function(){
            if(validacao_campos_formulario() == true)
            {
                $('#form-funcionario').submit();
            }
        });

        $("#pessoaDataList").change(function(){

              var el=$("#pessoaDataList")[0];  //used [0] is to get HTML DOM not jquery Object
              var dl=$("#datalistOptions")[0];

              if(el.value.trim() != '')
              {
                var opSelected = dl.querySelector(`[value="${el.value}"]`);

                $("#cpf").val(opSelected.dataset.cpf);
                $("#cpf").attr('disabled',true);

                $("#nome").val(opSelected.dataset.nome);
                $("#nome").attr('disabled',true);

                $("#dt_nascimento").val(opSelected.dataset.dtnascimento);
                $("#dt_nascimento").attr('disabled',true);
                
                $("#id_pessoa").val(opSelected.dataset.idpessoa);
                $("#pessoaDataList").val('');
                $("#div_content").removeClass('invisivel');
             }
        });
    });

        function validacao_campos_formulario()
        {   
            let erros = 0;

            $("#cpf_checagem").html("");
            $("#nome_checagem").html("");
            $("#sobrenome_checagem").html("");
            $("#dt_nascimento_checagem").html("");
            $("#cargo_checagem").html("");

            if(typeof $('#cpf').val() == 'undefined' || $('#cpf').val() == "")
            {   
                $("#cpf_checagem").html("obrigatório.");
                $("#cpf_checagem").css("display", "block");
                erros++;

            }else{

                let validacao_cpf = valida_cpf($('#cpf').val());

                if(validacao_cpf == 0)
                {
                    $("#cpf_checagem").html("CPF inválido.");
                    $("#cpf_checagem").css("display", "block");
                    erros++;
                }
            }

            if(typeof $('#nome').val() == 'undefined' || $('#nome').val() == "")
            {   
                $("#nome_checagem").html("obrigatório.");
                $("#nome_checagem").css("display", "block");
                erros++;
            } 

            if(typeof $('#dt_nascimento').val() == 'undefined' || $('#dt_nascimento').val() == "")
            {   
                $("#dt_nascimento_checagem").html("obrigatório.");
                $("#dt_nascimento_checagem").css("display", "block");
                erros++;
            }else{
                
                let idade = calculaIdade($('#dt_nascimento').val());

                if(idade > 100)
                {
                    $("#dt_nascimento_checagem").html("Idade não pode ser maior que 100.");
                    $("#dt_nascimento_checagem").css("display", "block");
                    erros++;
                }

                if(idade < 18 && idade > 0)
                {
                    $("#dt_nascimento_checagem").html("Idade não pode ser menor que 18.");
                    $("#dt_nascimento_checagem").css("display", "block");
                    erros++;
                }

                if(idade < 0)
                {
                    $("#dt_nascimento_checagem").html("Data de Nascimento não pode ser uma data futura.");
                    $("#dt_nascimento_checagem").css("display", "block");
                    erros++;
                }

                if(idade == null || idade == 0)
                {
                    $("#dt_nascimento_checagem").html("data de nascimento inválida.");
                    $("#dt_nascimento_checagem").css("display", "block");
                    erros++;
                }
            } 

            if(typeof $('#cargo_funcionario').val() == 'undefined' || $('#cargo_funcionario').val() == "" || $('#cargo_funcionario').val() == "-1")
            {
                $("#cargo_checagem").html("obrigatório.");
                $("#cargo_checagem").css("display", "block");
                erros++;
            }

            if(typeof $('#ativo').val() == 'undefined' || $('#ativo').val() == "" || $('#ativo').val() == "-1")
            {
                $("#ativo_checagem").html("obrigatório.");
                $("#ativo_checagem").css("display", "block");
                erros++;
            } 

            return (erros == 0) ? true : false;
        }

        function calculaIdade(data)
        {  
            var result = null;
            try
            {
                const hoje = new Date();
                const aniversario = new Date(data);
                let idade = hoje.getFullYear() - aniversario.getFullYear();
                const mes = hoje.getMonth() - aniversario.getMonth();
                
                if (mes < 0 || (mes === 0 && hoje.getDate() < aniversario.getDate()))
                {
                    idade--;
                }

                result = idade;
            
            }catch(error){
                result = null;
            }
            finally{
                return result;
            }
        }

        function valida_cpf(strCPF)
        {   
            strCPF = strCPF.replace('.', '').replace('.', '').replace('-', '');

            var Soma;
            var Resto;
            Soma = 0;

            if (strCPF == "00000000000") return 0;

            if (strCPF == "11111111111") return 0;

            if (strCPF == "22222222222") return 0;

            if (strCPF == "33333333333") return 0;

            if (strCPF == "44444444444") return 0;

            if (strCPF == "55555555555") return 0;

            if (strCPF == "66666666666") return 0;

            if (strCPF == "77777777777") return 0;

            if (strCPF == "88888888888") return 0;

            if (strCPF == "99999999999") return 0;

            for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
            Resto = (Soma * 10) % 11;

                if ((Resto == 10) || (Resto == 11))  Resto = 0;
                if (Resto != parseInt(strCPF.substring(9, 10)) ) return 0;

            Soma = 0;
                for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
                Resto = (Soma * 10) % 11;

                if ((Resto == 10) || (Resto == 11))  Resto = 0;
                if (Resto != parseInt(strCPF.substring(10, 11) ) ) return 0;
                return 1;
        }
</script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script> -->

    
@endsection
