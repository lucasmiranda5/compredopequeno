@extends('template.empresa')
@section('header')
<title>{{ $acao }} Produto</title>
@endsection
@section('conteudo')
<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">Produto
            <h1>{{ $acao }} Empresa </h1>
        </div>    
    </div>
</div>
</section>
@include('msgs_listagem', ['palavra' => 'Produto'])
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
                    <label>Categoria <small>Caso não tenha a categoria do seu produto por favor mande a categoria desejada para (38) 99141-4228 - Lucas Miranda</small></label>
                    <select class="form-control" required name="categoria">
                      <option value="">--Selecione uma opção--</option>
                      @foreach($categorias as $categoria)
                        <option {{ ( ($acao == 'Editar' and $retorno['categoria'] == $categoria['id']) ? 'selected' : '') }} value="{{ $categoria['id'] }}">{{ $categoria['nome'] }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Descrição</label>
                    <textarea class="form-control textarea" name="descricao">{{ $retorno['descricao'] ?? '' }}</textarea>
                  </div>
                  <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto">
                    @if($acao == 'Editar' and $retorno['foto'] != '')
                      <img src="<?=App::make('url')->to('/');?>/uploads/{{$retorno['foto'] }}" width="100">
                    @endif
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
  $('.textarea').summernote()
})
</script>
@endsection