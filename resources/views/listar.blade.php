@extends('template.usuario')
@section('header')
<title>Empresas Pirapora</title>

<style>

h2{
  background: #fdca0b;
  padding: 10px;
  color:#1f3772 !important;
  font-weight: bold !important;
}

</style>
@endsection
@section('conteudo')
<div style="background: #1f3772 ">
<section class="container">
    @foreach($categorias as $categoria)
      <h2>{{ $categoria['nome'] }}</h2>
    <div class="row" style="margin-bottom: 10px">       
      @foreach($categoria['empresas'] as $empresa)
        @include('card_empresa', ['empresa' => $empresa])
      @endforeach
    </div>
    @endforeach
</section>
</div>
@endsection
@section('js')
@endsection