@extends('layouts.main')
<?php $titulo = !empty($_GET['i']) ? 'Editar pessoa' : 'Cadastrar pessoa';?>
@section('title',$titulo)
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Formulário da Pessoa</h2>
        </div>
    </div>
    
    <div class="content-page">
        <form class="row g-3" id="form-pessoa" action="<?php echo !empty($_GET['i']) ? '/pessoa/edita/'.$_GET['i'].'' : '/pessoa/novo';?>" method="POST" enctype="multipart/form-data" >
            @csrf

            <fieldset class="border rounded-3 p-3">
                <legend class="float-none w-auto px-3" >Informações Pessoais</legend>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4 d-flex justify-content-left">
                            <img id="displaySelectedImage" src="<?php echo !empty($_GET['i']) ? asset('/system/images/sistema/pessoas/'.$pessoa->foto_perfil) : '/system/images/sistema/pessoas/generic_user.png'; ?>" class="img-thumbnail" alt="example placeholder" style="width: 200px; height: 200px;" />
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
                    <div class="col-md-3">
                        <label for="inputCPF" class="form-label">cpf: *</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="cpf"  
                            name="cpf"
                            value="<?php echo !empty($_GET['i']) ? $pessoa->cpf : NULL ; ?>" 
                        >
                        <span id="cpf_checagem" class="checagem"></span> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="inputNome" class="form-label">Nome: *</label>
                        <input 
                            type="text" 
                            class="form-control uppercase" 
                            id="nome" 
                            name="nome"
                            pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" maxlength="256"
                            value="<?php echo !empty($_GET['i']) ? $pessoa->nome : NULL ; ?>" 
                        >
                        <span id="nome_checagem" class="checagem"></span> 
                    </div>
                    <div class="col-md-8">
                        <label for="inputDt_nascimento" class="form-label">Sobrenome: *</label>
                        <input 
                            type="text" 
                            class="form-control uppercase" 
                            id="sobrenome"
                            name="sobrenome"
                            pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" 
                            maxlength="256" 
                            value="<?php echo !empty($_GET['i']) ? $pessoa->sobrenome : NULL ; ?>"
                        >
                        <span id="sobrenome_checagem" class="checagem"></span> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <label for="inputDt_nascimento" class="form-label">Data de Nascimento: *</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="dt_nascimento" 
                            name="dt_nascimento"
                            value="<?php echo !empty($_GET['i']) ? $pessoa->dt_nascimento : NULL ; ?>"
                        >
                        <span id="dt_nascimento_checagem" class="checagem"></span> 
                    </div>
                    <div class="col-md-3">
                        <label for="sexo" class="form-label">Sexo: </label>
                        <select id='sexo' name='sexo' class="form-select">
                            <option value=""></option>
                            @foreach ($sexo_sistema as $key => $sexo) 
                                <option value="<?php echo $sexo->id_sexo; ?>" 
                                    <?php echo (@$pessoa->id_sexo !== NULL && $pessoa->id_sexo == @$sexo->id_sexo) ? 'selected' : '';?> 
                                > 
                                    <?php  echo $sexo->descricao; ?>
                                </option>
                            @endforeach 
                        </select>
                        <span id="sexo_checagem" class="checagem"></span> 
                    </div>
                    <div class="col-md-3">
                        <label for="cor_raca" class="form-label">Cor/Raça: </label>
                        <select id='cor_raca' name='cor_raca' class="form-select">
                            <option value=""></option>
                            @foreach ($cor_raca_sistema as $key => $cor_raca) 
                                <option value="<?php echo $cor_raca->id_cor_raca; ?>" 
                                    <?php echo (@$pessoa->id_cor_raca !== NULL && $pessoa->id_cor_raca == @$cor_raca->id_cor_raca) ? 'selected' : '';?> 
                                > 
                                    <?php  echo $cor_raca->descricao; ?>
                                </option>
                            @endforeach
                        </select>
                        <span id="cor_raca_checagem" class="checagem"></span> 
                    </div>
                    <div class="col-md-3">
                        <label for="estdo_civil" class="form-label">Estado civil: </label>
                        <select id='estdo_civil' name='estdo_civil' class="form-select">
                            <option value=""></option>
                            @foreach ($estado_civil_sistema as $key => $estdo_civil) 
                                <option value="<?php echo $estdo_civil->id_estdo_civil; ?>" 
                                    <?php echo (@$pessoa->id_estdo_civil !== NULL && $pessoa->id_estdo_civil == @$estdo_civil->id_estdo_civil) ? 'selected' : '';?> 
                                > 
                                    <?php  echo $estdo_civil->descricao; ?>
                                </option>
                            @endforeach
                        </select>
                        <span id="estdo_civil_checagem" class="checagem"></span> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <label for="escolaridade" class="form-label">Escolaridade: </label>
                        <select id='escolaridade' name='escolaridade' class="form-select">
                            <option value=""></option>
                            @foreach ($escolaridade_sistema as $key => $escolaridade) 
                                <option value="<?php echo $escolaridade->id_escolaridade; ?>" 
                                    <?php echo (@$pessoa->id_escolaridade !== NULL && $pessoa->id_escolaridade == @$escolaridade->id_escolaridade) ? 'selected' : '';?> 
                                > 
                                    <?php  echo $escolaridade->descricao; ?>
                                </option>
                            @endforeach
                        </select>
                        <span id="escolaridade_checagem" class="checagem"></span> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="inputEmail" class="form-label">E-mail: </label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo !empty($_GET['i']) ? $pessoa->email : NULL ; ?>">
                        <span id="email_checagem" class="checagem"></span> 
                    </div>
                    <div class="col-md-3">
                        <label for="inputTelefoneNotificacao" class="form-label">Telefone para contato: </label>
                        <input type="text" class="form-control" id="telefone_notificacao" name="telefone_notificacao" value="<?php echo !empty($_GET['i']) ? $pessoa->telefone_notificacao : NULL ; ?>">
                        <span id="telefone_notificacao_checagem" class="checagem"></span> 
                    </div>
                </div>

            </fieldset>

            <fieldset class="border rounded-3 p-3">
                <legend class="float-none w-auto px-3" >Endereço</legend>
                <div class="row">
                    <div class="col-md-2">
                        <label for="inputCep" class="form-label">CEP: </label>
                        <input type="text" class="form-control" id="cep" name="cep" flag="0" value="<?php echo !empty($_GET['i']) ? $pessoa->end_cep : NULL ; ?>">
                        <span id="cep_checagem" class="checagem"></span> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="inputEndTipoLogradouro" class="form-label">Tipo logradouro: </label>
                         <select id='end_tipo_logradouro' name='end_tipo_logradouro' class="form-select endereco">
                            <option value=""></option>
                            @foreach ($tipo_logradouro_sistema as $key => $tipo_logradouro) 
                                <option value="<?php echo $tipo_logradouro->id_tipo_logradouro; ?>" 
                                    <?php echo (@$pessoa->end_id_tipo_logradouro !== NULL && $pessoa->end_id_tipo_logradouro == @$tipo_logradouro->id_tipo_logradouro) ? 'selected' : '';?> 
                                > 
                                    <?php  echo $tipo_logradouro->descricao; ?>
                                </option>
                            @endforeach
                        </select>
                        <span id="end_tipo_logradouro_checagem" class="checagem"></span> 
                    </div>
                    <div class="col-md-7">
                        <label for="inputEmail" class="form-label">Logradouro: </label>
                        <input 
                            type="text" 
                            class="form-control endereco uppercase" 
                            id="logradouro" 
                            name="logradouro" 
                            value="<?php echo !empty($_GET['i']) ? $pessoa->end_logradouro : NULL ; ?>"
                            pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" 
                            maxlength="256" 
                        >
                        <span id="logradouro_checagem" class="checagem"></span> 
                    </div>
                    <div class="col-md-2">
                        <label for="inputEmail" class="form-label">Número: </label>
                        <input 
                            type="text"
                            class="form-control endereco"
                            id="numero"
                            name="numero"
                            value="<?php echo !empty($_GET['i']) ? $pessoa->end_numero : NULL ; ?>"
                            pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" 
                            maxlength="256" 
                        >
                        <span id="numero_checagem" class="checagem"></span> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="inputComplemento" class="form-label">Complemento: </label>
                        <input 
                            type="text"
                            class="form-control endereco uppercase"
                            id="complemento"
                            name="complemento" 
                            value="<?php echo !empty($_GET['i']) ? $pessoa->end_complemento : NULL ; ?>"
                        >
                        <span id="complemento_checagem" class="checagem"></span> 
                    </div>
                    <div class="col-md-6">
                        <label for="inptBairro" class="form-label">Bairro: </label>
                        <input type="text" class="form-control endereco uppercase" id="bairro" name="bairro" value="<?php echo !empty($_GET['i']) ? $pessoa->end_bairro : NULL ; ?>">
                        <span id="bairro_checagem" class="checagem"></span> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label for="inputEmail" class="form-label">Estado: </label>
                        <select id='estado' name='estado' class="form-select endereco">
                            <option value=""></option>
                            @foreach ($unidades_federativas as $key => $unidade_federativa) 
                                <option value="<?php echo $unidade_federativa->id_unidade_federativa; ?>"
                                    <?php echo (@$pessoa->end_uf !== NULL && $pessoa->end_uf == @$unidade_federativa->id_unidade_federativa) ? 'selected' : '';?> 
                                > 
                                    <?php  echo $unidade_federativa->sigla; ?>
                                </option>
                            @endforeach
                        </select>
                        <span id="estado_checagem" class="checagem"></span> 
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail" class="form-label">Cidade: </label>
                        <input 
                            type="text"
                            class="form-control endereco uppercase" 
                            id="municipio" 
                            name="municipio" 
                            value="<?php echo !empty($_GET['i']) ? $pessoa->end_municipio : NULL ; ?>"
                        >
                        <span id="municipio_checagem" class="checagem"></span> 
                    </div>
                </div>
            </fieldset>

            <div class="col-12">
                <a class="btn btn-secondary" href="/pessoas" role="button" style="width: 150px;">Voltar</a>
                <a id="btn_salvar" class="btn btn-blue"  style="width: 150px;" > Salvar </a>
            </div>
        </form>
    </div>

<script>
    $( document ).ready(function() {

        $('#cpf').inputmask('999.999.999-99');
        $('#telefone_notificacao').inputmask('(99) 9999-9999');
        $('#cep').inputmask('99999-999');

        $(".endereco").prop("disabled", true);

        var cpf = '<?php echo auth()->user()->cpf; ?>';
        var cep_old = '';
        //console.log('cpf', cpf);

        $("#cep").mouseleave(function () {
            
            var valorCep = $(this).val().replace(/\D/g, '');

            //console.log('CEP atual:', valorCep,'CEP old:',cep_old, 'flag_cep:', $('#cep').attr('flag'));

            if($('#cep').attr('flag') == 0 || $('#cep').attr('flag') == 1 && valorCep != cep_old)
            {
                if(valorCep !== "" && valorCep.length == 8)
                {   try
                    {   
                        spinner_loading(true, 1000);

                        var request = $.ajax({
                            type: "GET",
                            url: 'https://brasilapi.com.br/api/cep/v1/'+valorCep,
                            async: false,  // Definir a chamada como síncrona
                        });  

                        if (request.status === 200)
                        {   
                            $('#cep').attr('flag', 1);
                            console.log(request.responseJSON);

                            if(request.responseJSON.hasOwnProperty('cep'))
                            {   
                                $("#bairro").val(request.responseJSON.neighborhood.toUpperCase());
                                $("#municipio").val(request.responseJSON.city.toUpperCase());
                                $("#estado option:contains('" + request.responseJSON.state + "')").prop("selected", true);
                                $("#logradouro").val(request.responseJSON.street.replace(/^[\S]+\s/, '').toUpperCase());

                                $(".endereco").prop("disabled", false);
                            }

                        }else{

                            $('#cep').attr('flag', 1);
                            $(".endereco").prop("disabled", false);
                        }

                        spinner_loading(false, 500);

                    }catch(e){
                        spinner_loading(false, 500);
                    }
                } 
            }

            cep_old = valorCep;
        });

        $("#foto_perfil").on("change", function(){
              displaySelectedImage(event, 'displaySelectedImage');
        });

        $('#btn_salvar').click(function(){
            if(validacao_campos_formulario() == true)
            {
                $('#form-pessoa').submit();
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
        $("#email_checagem").html("");

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
        
        if(typeof $('#email').val() != 'undefined' && $('#email').val() != "")
        {
            const emailRegex = /^[a-z0-9.]+@[a-z0-9]+\.[a-z]+(\.[a-z]+)?$/i;

            console.log('Regex email: ', emailRegex.test($('#email').val()));

            if(emailRegex.test($('#email').val()) == true)
            {
                try
                {   
                    var email_pessoa = $('#email').val();
                    var id_pessoa = '<?php echo (!empty($_GET['i'])) ? $_GET['i'] : "-1";?>';
                    var url = '/pessoa/verifica_email';
                    var token = '{{ csrf_token() }}';

                    var request = $.ajax({
                        type: "POST",
                        url: url,
                        data: {id: id_pessoa, email: email_pessoa, _token: token},
                        async: false,  // Definir a chamada como síncrona
                    });

                    if (request.status === 200)
                    {
                        var data = JSON.parse(request.responseText);

                        if (data.status === "sucesso")
                        {
                            
                            if(data.flag == "false")
                            {   
                                $("#email_checagem").html("E-mail já cadastrado em outra pessoa");
                                $("#email_checagem").css("display", "block");
                                erros++;
                            }
                        }

                    } else {
                        $("#email_checagem").html("Não foi possível verificar E-mail. Procure o administrador do sistema.");
                        $("#email_checagem").css("display", "block");
                        erros++;
                    }

                }catch(e){

                    $("#email_checagem").html("Não foi possível verificar E-mail. Procure o administrador do sistema.");
                    $("#email_checagem").css("display", "block");
                     erros++; 
                }
            }else{

                $("#email_checagem").html("formato inválido");
                $("#email_checagem").css("display", "block");
                erros++;
            }

        }  

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
