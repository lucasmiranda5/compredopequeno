@extends('template.painel')
@section('header')
<title>{{ $acao }} Cidade</title>
@endsection
@section('conteudo')
<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ $acao }} Cidade </h1>
        </div>    
    </div>
</div>
</section>
@include('msgs_listagem', ['palavra' => 'Categoria'])
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
              <form action="" method="post">
                <!-- /.card-header -->
                <div class="card-body">                  
                    @csrf
                  <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="cidade" class="form-control" value="{{ $retorno['cidade'] ?? '' }}">
                  </div>
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