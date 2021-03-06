@extends('template.painel')
@section('header')
<title>Categorias</title>
@endsection
@section('conteudo')
<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Lista de Categorias <a href="{{ route('painel::categorias::cadastrar') }}" class="btn btn-xs btn-success">Cadastrar</a></h1>
        </div>    
    </div>
</div>
</section>

@include('msgs_listagem', ['palavra' => 'Categorias'])


<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Categorias</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
        </div>
    </div>
</section>
@endsection
@section('js')
    <script>
      $(document).ready(function() {
            var table = $('.table').DataTable( {
              "language":{
                "url": "<?=App::make('url')->to('/');?>/resources/assets/plugins/datatables/Portuguese-Brasil.json"
              },
                "procura": true,
                "serverSide": true,
                "ajax": {
                    "url": "",
                    "type": "GET"
                },
                "columns": [             
                    { "data": "id","name":"id"},
                    { "data": "nome","name":"nome"},
                    { "data": "acoes","name":"id" },                         
                ]
            } );
         
        } );    
    </script>  
@endsection