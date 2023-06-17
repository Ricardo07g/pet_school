@extends('layouts.main')

@section('title','Inicio')
@section('content')
    <div class="titulo-pagina">
        <div>
            <h2 class="mb-4">Formulário do funcionário</h2>
        </div>
        <!--
        <div>
            <div class="btn-group" role="group" style="margin-right: 10px; width: 200px;">
                <a class="btn btn-blue" href="/usuarios" role="button">Voltar</a>
            </div>
        </div>
        -->
    </div>
    
    @if(isset($id))
       
    @endif
    <div class="content-page">
        <form class="row g-3">
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
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="cargo_funcionario" class="form-label">Função*</label>
                    <select id='cargo_funcionario' name='cargo_funcionario' class="form-select">
                    <option value="-1"></option>
                    @foreach ($cargos_usuario as $key => $cargo_usuario) 
                        <option value="<?php echo $cargo_usuario->id_cargo; ?>" 
                            <?php echo (@$funcionario->id_cargo !== NULL && $cargo_usuario->id_cargo == @$funcionario->id_cargo) ? 'selected' : '';?> 
                        > 
                            <?php  echo $cargo_usuario->descricao; ?>
                        </option>
                    @endforeach 
                    </select>
                    <span id="cargo_funcionario_checagem" class="checagem"></span> 
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
                            <option value="1" <?php echo (@$funcionario->ativo !== NULL && $funcionario->ativo == 1) ? 'selected': '';?> >ATIVO</option>
                            <option value="0" <?php echo (@$funcionario->ativo !== NULL && $funcionario->ativo == 0) ? 'selected': '';?>>INATIVO</option>
                        </select>
                        <span id="ativo_checagem" class="checagem"></span> 
                    </div>
                @endif
            </div>
            <div class="col-12">
                <a class="btn btn-secondary" href="/funcionarios" role="button">Voltar</a>
                <button type="submit" class="btn btn-blue">Salvar</button>
            </div>
        </form>
    </div>
    
    @endsection
