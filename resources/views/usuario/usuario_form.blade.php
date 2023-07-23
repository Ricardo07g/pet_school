@extends('layouts.main')
<?php $titulo = !empty($_GET['i']) ? 'Editar usuário' : 'Cadastrar usuário';?>
@section('title',$titulo)
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Formulário do usuário</h2>
        </div>
    </div>
    
    <div class="content-page">
        <form class="row g-3" id="form-usuario" action="<?php echo !empty($_GET['i']) ? '/usuario/edita/'.$_GET['i'].'' : '/usuario/novo';?>" method="POST">
            @csrf
            <div class="row">
            <div class="col-md-6">
                    <label for="inputNome" class="form-label">Nome*</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo !empty($_GET['i']) ? $usuario->nome : NULL ; ?>" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" maxlength="256">
                    <span id="nome_checagem" class="checagem"></span> 
                </div>
                <div class="col-md-6">
                    <label for="inputSobrenome" class="form-label">Sobrenome*</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?php echo !empty($_GET['i']) ? $usuario->sobrenome : NULL ; ?>" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" maxlength="256">
                    <span id="sobrenome_checagem" class="checagem"></span> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="inputDt_nascimento" class="form-label">Data de Nascimento*</label>
                    <input type="date" class="form-control" id="dt_nascimento" name="dt_nascimento" value="<?php echo !empty($_GET['i']) ? $usuario->dt_nascimento : NULL ; ?>">
                    <span id="dt_nascimento_checagem" class="checagem"></span> 
                </div>
                <div class="col-md-6">
                    <label for="inputCPF" class="form-label">CPF*</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="" value="<?php echo !empty($_GET['i']) ? $usuario->cpf : NULL ; ?>" <?php echo !empty($_GET['i']) ? 'disabled' : ''; ?> >
                    <span id="cpf_checagem" class="checagem"></span> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="grupo_usuario" class="form-label">Grupo*</label>
                    <select id='grupo_usuario' name='grupo_usuario' class="form-select">
                    <option value="-1"></option>
                    @foreach ($grupos_usuario as $key => $grupo_usuario) 
                        <option value="<?php echo $grupo_usuario->id_grupo_usuario; ?>" 
                            <?php echo (@$usuario->id_usuario_grupo !== NULL && $grupo_usuario->id_grupo_usuario == @$usuario->id_usuario_grupo) ? 'selected' : '';?> 
                        > 
                            <?php  echo $grupo_usuario->descricao; ?>
                        </option>
                    @endforeach 
                    </select>
                    <span id="grupo_usuario_checagem" class="checagem"></span> 
                </div>
            </div>
            <div class="row">
                @if(@$_GET['i'] == NULL)
                    <div class="col-md-6">
                        <label for="ativo" class="form-label">Ativo</label>
                        <select id='ativo' name='ativo' class="form-select" disabled>
                            <option value="1" selected>ATIVO</option>
                        </select>
                        <span id="ativo_checagem" class="checagem"></span> 
                    </div>
                @else
                    <div class="col-md-6">
                        <label for="ativo" class="form-label">Ativo</label>
                        <select id='ativo' name='ativo' class="form-select">
                            <option value="-1"></option>
                            <option value="1" <?php echo (@$usuario->ativo !== NULL && $usuario->ativo == 1) ? 'selected': '';?> >ATIVO</option>
                            <option value="0" <?php echo (@$usuario->ativo !== NULL && $usuario->ativo == 0) ? 'selected': '';?>>INATIVO</option>
                        </select>
                        <span id="ativo_checagem" class="checagem"></span> 
                    </div>
                @endif
            </div>
            <div class="col-12">
                <a class="btn btn-secondary" href="/usuarios" role="button" style="width: 150px;">Voltar</a>
                <a id="btn_salvar" class="btn btn-blue" style="width: 150px;">Salvar</a>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function(){

            $('#cpf').inputmask('999.999.999-99');

            $("#nome").on("change", function(){
                $(this).val($(this).val().toUpperCase());
                var regexp = /[^a-zA-Z^\s+]/g;

                if(this.value.match(regexp))
                {
                    $(this).val(this.value.replace(regexp,''));
                }
            });

            $("#sobrenome").on("change", function(){
                $(this).val($(this).val().toUpperCase());
                var regexp = /[^a-zA-Z^\s+]/g;

                if(this.value.match(regexp))
                {
                    $(this).val(this.value.replace(regexp,''));
                }
            });

            $('#btn_salvar').click(function(){
                if(validacao_campos_formulario() == true)
                {
                    $('#form-usuario').submit();
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
            $("#grupo_usuario_checagem").html("");

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

            if(typeof $('#sobrenome').val() == 'undefined' || $('#sobrenome').val() == "")
            {   
                $("#sobrenome_checagem").html("obrigatório.");
                $("#sobrenome_checagem").css("display", "block");
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

            if(typeof $('#grupo_usuario').val() == 'undefined' || $('#grupo_usuario').val() == "" || $('#grupo_usuario').val() == "-1")
            {
                $("#grupo_usuario_checagem").html("obrigatório.");
                $("#grupo_usuario_checagem").css("display", "block");
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
@endsection
