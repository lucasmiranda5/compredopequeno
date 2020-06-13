@extends('template.empresa')
@section('header')
<title>{{ $acao }} Empresa</title>
@endsection
@section('conteudo')
<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ $acao }} Empresa </h1>
        </div>    
    </div>
</div>
</section>
@include('msgs_listagem', ['palavra' => 'Empresa'])
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
              <form action="" method="post" enctype="multipart/form-data">
                <!-- /.card-header -->
                <div class="card-body">                  
                    @csrf
                  <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" value="{{ $retorno['nome'] ?? '' }}">
                  </div>
                  <div class="form-group">
                    <label>Categoria</label>
                    <select class="form-control" required name="categoria">
                      <option value="">--Selecione uma opção--</option>
                      @foreach($categorias as $categoria)
                        <option {{ ( ($acao == 'Editar' and $retorno['categoria'] == $categoria['id']) ? 'selected' : '') }} value="{{ $categoria['id'] }}">{{ $categoria['nome'] }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Descrição</label>
                    <textarea class="form-control" name="descricao">{{ $retorno['descricao'] ?? '' }}</textarea>
                  </div>
                  <div class="form-group">
                    <label>Marca</label>
                    <input type="file" name="marca">
                    @if($acao == 'Editar' and $retorno['marca'] != '')
                      <img src="<?=App::make('url')->to('/');?>/uploads/{{$retorno['marca'] }}" width="100">
                    @endif
                  </div>
                  <div class="form-group">
                    <label>Hórario de funcionamento</label>
                    <textarea class="form-control" name="horario_funcionamento">{{ $retorno['horario_funcionamento'] ?? '' }}</textarea>
                  </div>
                  <h3>Contatos</h3>
                  @for($x = 1; $x <= 3; $x++)
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Tipo</label>
                        <select class="form-control tipo" id="{{ $x }}" name="tipo[{{ $x }}]">
                          <option value="telefone" {{ ( ($acao == 'Editar' and !empty($contatos[$x]) and  $contatos[$x]['tipo'] == "telefone") ? 'selected' : '') }}>Telefone</option>
                          <option value="whatsapp" {{ ( ($acao == 'Editar' and !empty($contatos[$x]) and $contatos[$x]['tipo'] == "whatsapp") ? 'selected' : '') }}>WhatsApp</option>
                          <option value="site" {{ ( ($acao == 'Editar' and !empty($contatos[$x]) and $contatos[$x]['tipo'] == "site") ? 'selected' : '') }}>Site</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="labeltxt{{ $x }}">
                          @if($acao == 'Editar' and !empty($contatos[$x]) )
                            @if($contatos[$x]['tipo'] == 'telefone') Telefone
                            @elseif($contatos[$x]['tipo'] == 'whatsapp') WhatsApp
                            @else Escrita @endif
                          @else                         
                            Telefone
                          @endif
                        </label>
                      <input type="text" value="{{ $contatos[$x]['direcionamento'] ?? '' }}" name="direcionamento[{{ $x }}]" class="form-control direcionamento{{$x}} {{ ( ($acao == 'Editar' and !empty($contatos[$x]) and $contatos[$x]['tipo'] == "site") ? '' : 'telefone') }} ">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group link{{ $x }}" style="{{ ( ($acao == 'Editar' and !empty($contatos[$x]) and $contatos[$x]['tipo'] == "site") ? '' : 'display:none') }}" >
                        <label>Link</label>
                        <input type="text" name="link[{{ $x }}]" value="{{ $contatos[$x]['link'] ?? '' }}" class="form-control">
                      </div>
                    </div>
                </div>
                @endfor

            <div class="form-group">
              <label>Nome do Responsavel</label>
              <input type="text" name="nome_responsavel" class="form-control" value="{{ $retorno['nome_responsavel'] ?? '' }}">
            </div>
            <div class="form-group">
              <label>Telefone do Responsavel</label>
              <input type="text" name="telefone_responsavel" class="form-control" value="{{ $retorno['telefone_responsavel'] ?? '' }}">
            </div>
            <div class="form-group">
                <label>Status</label><br>
                {{ ($retorno['ativo'] == 's' ? 'Ativo' : 'Ainda não ativado - Nossa equipe irá válidar as informações e ativar na plataforma.') }}
              </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-success">{{ $acao }}</button>
                </div>
              </form>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
        </div>
    </div>
</section>
@endsection
@section('js')
    <script>
      $(function(){
        $('.telefone').inputmask('(99)[9]9999-9999')
        $('.tipo').change(function(){
          id = $(this).attr('id');
          if($(this).val() == 'site'){
            $('.link'+id).css('display','');
            $('.labeltxt'+id).html('Escrita');
            $('.direcionamento'+id).inputmask('remove');
          }else if($(this).val() == 'telefone'){
            $('.link'+id).css('display','none');
            $('.labeltxt'+id).html('Telefone');
            $('.direcionamento'+id).inputmask('(99)[9]9999-9999')
          }else if($(this).val() == 'whatsapp'){
            $('.link'+id).css('display','none');
            $('.labeltxt'+id).html('WhatsApp');
            $('.direcionamento'+id).inputmask('(99)[9]9999-9999')
          }
        })
      })
    </script>
@endsection