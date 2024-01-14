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
        <form class="row g-3" id="form-usuario" action="<?php echo !empty($_GET['i']) ? '/usuario/edita/'.$_GET['i'].'' : '/usuario/novo';?>" method="POST"  enctype="multipart/form-data" >
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4 d-flex justify-content-left">
                        <img id="displaySelectedImage" src="<?php echo !empty($_GET['i']) ? asset('/system/images/sistema/usuarios/'.$usuario->foto_perfil) : '/system/images/sistema/usuarios/generic_user.png'; ?>" class="img-thumbnail" alt="example placeholder" style="width: 200px; height: 200px;" />
                    </div>
                    <div class="mb-4 d-flex justify-content-left" style="margin: -20px 0px 10px 0px !important;">
                        <span id="foto_checagem" class="checagem">teste</span>
                    </div>
                    <div class="d-flex justify-content-left" style="margin-top: -10px;">
                        <a class="btn btn-blue btn-rounded" >
                            <label class="form-label text-white m-1" for="foto_perfil">Editar foto de perfil</label>
                            <input type="file" class="form-control d-none" id="foto_perfil" name="foto_perfil"/>
                            <input type="hidden" class="form-control d-none" id="foto_perfil_tamanho" name="foto_perfil_tamanho"/>
                            <input type="hidden" class="form-control d-none" id="foto_perfil_extensao" name="foto_perfil_extensao"/>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                    <label for="inputNome" class="form-label">Nome*:</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo !empty($_GET['i']) ? @$usuario->nome : NULL ; ?>" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" maxlength="256">
                    <span id="nome_checagem" class="checagem"></span> 
                </div>
                <div class="col-md-6">
                    <label for="inputSobrenome" class="form-label">Sobrenome*:</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?php echo !empty($_GET['i']) ? @$usuario->sobrenome : NULL ; ?>" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" maxlength="256">
                    <span id="sobrenome_checagem" class="checagem"></span> 
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <label for="inputDt_nascimento" class="form-label">Data de Nascimento*:</label>
                    <input type="date" class="form-control" id="dt_nascimento" name="dt_nascimento" value="<?php echo !empty($_GET['i']) ? @$usuario->dt_nascimento : NULL ; ?>">
                    <span id="dt_nascimento_checagem" class="checagem"></span> 
                </div>

                <div class="col-md-3">
                    <label for="inputCPF" class="form-label">CPF*:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="" value="<?php echo !empty($_GET['i']) ? @$usuario->cpf : NULL ; ?>">
                    <span id="cpf_checagem" class="checagem"></span> 
                </div>
                <div class="col-md-6">
                    <label for="grupo_usuario" class="form-label">Grupo*:</label>
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
                 <div class="col-md-6">
                    <label for="inputEmail" class="form-label">E-mail*:</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo !empty($_GET['i']) ? $usuario->email : NULL ; ?>">
                    <span id="email_checagem" class="checagem"></span> 
                </div>

                <div class="col-md-6">
                    @if(@$_GET['i'] == NULL)
                      <label class="form-label">Senha:*</label>
                        <div class="input-group">
                            <input class="form-control password" id="senha" class="block" type="password" name="senha" value="" />
                            <span class="input-group-text togglePassword" id="">
                                <i data-feather="eye" style="cursor: pointer"></i>
                            </span>
                        </div>
                        <span id="senha_checagem" class="checagem"></span> 
                    @else
                     <label class="form-label">Nova senha</label>
                      <div class="input-group">
                          <input class="form-control password" id="nova_senha" class="block" type="password" name="nova_senha" value="" />
                          <span class="input-group-text togglePassword" id="">
                              <i data-feather="eye" style="cursor: pointer"></i>
                          </span>
                      </div>
                      <span id="nova_senha_checagem" class="checagem"></span> 
                    @endif
                </div>
            </div>
            <div class="row">
                @if(@$_GET['i'] == NULL)
                    <div class="col-md-2" style="display:none;">
                        <label for="ativo" class="form-label">Situação:</label>
                        <select id='ativo' name='ativo' class="form-select" disabled>
                            <option value="1" selected>ATIVO</option>
                        </select>
                        <span id="ativo_checagem" class="checagem"></span> 
                    </div>
                @else
                    <div class="col-md-2">
                        <label for="ativo" class="form-label">Situação:</label>
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
                var regexp = /[^A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ^\s+]/g;

                if(this.value.match(regexp))
                {
                    $(this).val(this.value.replace(regexp,''));
                }
            });

            $("#sobrenome").on("change", function(){
                $(this).val($(this).val().toUpperCase());
                var regexp = /[^A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ^\s+]/g;

                if(this.value.match(regexp))
                {
                    $(this).val(this.value.replace(regexp,''));
                }
            });

            $('#btn_salvar').click(function(){
                
                spinner_loading(true);

                if(validacao_campos_formulario() == true)
                {   console.log('validou');
                    $('#form-usuario').submit();
                }

                spinner_loading(false);
            });

            feather.replace({ 'aria-hidden': 'true' });

            $(".togglePassword").click(function (e) {
                  
                e.preventDefault();
                var type = $(this).parent().parent().find(".password").attr("type");

                if(type == "password")
                {
                  $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
                  $(this).parent().parent().find(".password").attr("type","text");

                }else if(type == "text"){

                  $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
                  $(this).parent().parent().find(".password").attr("type","password");
                }
            });

            $("#foto_perfil").on("change", function(){
                  displaySelectedImage(event, 'displaySelectedImage');
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
            $("#senha_checagem").html("");
            $("#nova_senha_checagem").html("");
            $("#email_checagem").html("");
            $("#foto_checagem").html("");

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

            if(typeof $('#email').val() == 'undefined' || $('#email').val() == "" )
            {
                $("#email_checagem").html("obrigatório.");
                $("#email_checagem").css("display", "block");
                erros++;
            }else{

                const emailRegex = /^[a-z0-9.]+@[a-z0-9]+\.[a-z]+(\.[a-z]+)?$/i;

                if(emailRegex.test($('#email').val()) == true)
                {
                    try
                    {   
                        var id_usuario = '<?php echo (!empty($_GET['i'])) ? $_GET['i'] : "-1";?>';
                        var email_usuario = $('#email').val();

                        $.ajax({
                            type: "POST",
                            url: '/usuario/verifica_email',
                            data: {id: id_usuario, email: email_usuario,  _token: '{{csrf_token()}}'},
                            success: function (data) {

                                console.log('request sucesso: ',data);

                                if(data.status ==  "sucesso")
                                {   
                                    if(data.flag == "false" )
                                    {
                                        $("#email_checagem").html("E-mail já cadastrado em outro usuario");
                                        $("#email_checagem").css("display", "block");
                                        erros++; 
                                    }

                                }else{

                                    $("#email_checagem").html("Não foi possível verificar E-mail. Procure o administrador do sistema.");
                                    $("#email_checagem").css("display", "block");
                                    erros++; 
                                }
                            },
                            error: function (data, textStatus, errorThrown) {
                                
                                console.log('request erro: ',data);

                                $("#email_checagem").html("Não foi possível verificar E-mail. Procure o administrador do sistema.");
                                $("#email_checagem").css("display", "block");
                                 erros++; 
                            },
                        });

                    }catch(e){

                        $("#email_checagem").html("Não foi possível verificar E-mail. Procure o administrador do sistema.");
                        $("#email_checagem").css("display", "block");
                         erros++; 
                    }

                }else{
                    $("#email_checagem").html("E-mail inválido.");
                    $("#email_checagem").css("display", "block");
                     erros++; 
                }
            }

            @if(@$_GET['i'] == NULL)

                if(typeof $('#senha').val() !== 'undefined' && $('#senha').val() == "")
                {
                    $("#senha_checagem").html("obrigatório.");
                    $("#senha_checagem").css("display", "block");
                    erros++;

                }else{

                    let forca = valida_forca_senha($('#senha').val());

                    if(forca.forca  < 4)
                    {
                        $("#senha_checagem").html(forca.mensagem);
                        $("#senha_checagem").css("display", "block");
                        erros++;   
                    }
                }

            @else

                if(typeof $('#nova_senha').val() == 'undefined' || $('#nova_senha').val() !== "")
                {
                    let forca = valida_forca_senha($('#nova_senha').val());

                    if(forca.forca  < 4)
                    {
                        $("#nova_senha_checagem").html(forca.mensagem);
                        $("#nova_senha_checagem").css("display", "block");
                        erros++;   
                    }
                } 

            @endif

            if(typeof $('#foto_perfil').val() != 'undefined' && $('#foto_perfil').val() != "")
            {   
                let extencoes = ['jpeg', 'png', 'jpg', 'gif'];

                if($('#foto_perfil_tamanho').val() > 2048)
                {
                    $("#foto_checagem").html("O tamanho máximo permitido para o arquivo é de 2MB.");
                    $("#foto_checagem").css("display", "block");
                    erros++;
                }

                if(extencoes.includes($('#foto_perfil_extensao').val()) == false)
                {
                    $("#foto_checagem").html("O arquivo deve ter uma das seguintes extensões: jpeg, png, jpg, gif.");
                    $("#foto_checagem").css("display", "block");
                    erros++;
                }
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

        function valida_forca_senha(senha)
        {
            var forca = 0;
            var mensagens = [];

            if (senha.length >= 8)
            {
                forca += 1;
            } else {
                mensagens.push('<br> - A senha deve ter pelo menos 8 caracteres. ');
            }

            if (senha.match(/[0-9]/))
            {
                forca += 1;
            } else {
                mensagens.push('<br> -  A senha deve conter pelo menos um número.');
            }

            if (senha.match(/[a-z]/) && senha.match(/[A-Z]/))
            {
                forca += 1;
            } else {
                mensagens.push('<br> -  A senha deve conter letras maiúsculas e minúsculas.');
            }

            if (senha.match(/[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/))
            {
                forca += 1;
            } else {
                mensagens.push('<br> -  A senha deve conter caracteres especiais.');
            }

            return {forca: forca, mensagem: mensagens};
        }

        function displaySelectedImage(event, elementId)
        {
            const selectedImage = $('#' + elementId)[0];
            const fileInput = event.target;

            if (fileInput.files && fileInput.files[0])
            {
                const file = fileInput.files[0];

                // Verifica o tamanho do arquivo em bytes
                const fileSize = file.size;

                // Converte o tamanho para kilobytes
                const fileSizeInKB = fileSize / 1024;

                $('#foto_perfil_tamanho').val(fileSizeInKB);

                // Obtém o nome do arquivo
                const fileName = file.name;

                // Extrai a extensão do arquivo
                const fileExtension = fileName.split('.').pop();

                $('#foto_perfil_extensao').val(fileExtension);

                const reader = new FileReader();

                reader.onload = function(e)
                {
                    selectedImage.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        }
    </script> 
@endsection
