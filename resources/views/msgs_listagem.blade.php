
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @if(\Request::input('resposta') == 'sucesso_cadastro')
            <div class="alert alert-success alert-dismissible">
                <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                {{ $palavra}} cadastrado com sucesso
            </div>
            @endif

            @if(\Request::input('resposta') == 'sucesso_editar')
            <div class="alert alert-success alert-dismissible">
                <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                {{ $palavra }} editado com sucesso!
            </div>
            @endif

            @if(\Request::input('resposta') == 'sucesso_excluir')
            <div class="alert alert-success alert-dismissible">
                <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                {{ $palavra }} excluido com sucesso
            </div>
            @endif

            @if(\Request::input('resposta') == 'erro_preco_cadastro')
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Erro!</h5>
                {{ $palavra }} editado com sucesso!
            </div>
            @endif

            @if(\Request::input('resposta') == 'error_usuario')
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Erro!</h5>
                Já existe um outro usuario com esse nome de usuario por favor escolha outro.
            </div>
            @endif

            
   
    </div>
    </div>
    </section>