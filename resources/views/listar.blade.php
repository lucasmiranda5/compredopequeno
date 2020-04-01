@extends('template.usuario')
@section('header')
<title>Empresas Pirapora</title>

<style>
 @page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }
h2{
  background: #fdca0b;
  padding: 10px;
  color:#1f3772 !important;
  font-weight: bold !important;
}
body, html{
  background: #1f3772 !important;
  background-color: #1f3772 !important;
}

.card-empresa{
        background:#fff;
        border-radius:10px;
        padding: 10px 0px;
    height: 355px;
    margin-top:5px;
    }
    .card-empresa img{
        max-width:297px;
        max-height: 91px;
    }
    .card-empresa .topo{
        border-bottom: 1px solid #1f3772;
        padding-top:5px;
    }
    .card-empresa .card-contato .escrita{
        background: #fdca0b;
        padding: 5px;
        font-weight: bold;
        font-size: 28px;
        color: #1f3772;
        height:55px;
    }
    .card-empresa .card-contato .escrita img{
        height: 30px;
    }
    .card-empresa .card-contato .escrita span{
        font-size:20px;
    }
    .card-empresa .card-contato {
        margin-top: 0;
    }
    .card-empresa .card-contato .escrita1 {
        background: #1f3772;
    text-transform: uppercase;
    padding: 4px;
    font-weight: bold;
    color: #fff;
    font-size: 11px;
    margin-top: -15px;
    position: absolute;
    margin-left: 26px;
    height: 24px;
    }

    .card-empresa .conteudo{
        padding: 18px 45px 0px 45px
    }
    .imgclick{
        width: 45px;
    /* float: right; */
    margin-left: 95%;
    margin-top: -69px;
   /*  margin-right: -16px; */
    /*  display: inline-block; */
    }

</style>
@endsection
@section('conteudo')
<div class="container">
  <div class="form-group">
    <label style="color:#fff">Pesquisar Empresa</label>
    <form action="" method="get">
    <div class="row">
      <div class="col-md-5">
      <input type="text" name="pesquisa" value="{{ $pesquisa }}" class="form-control">
      </div>
      <div class="col-md-3">
        <input type="submit" class="btn btn-success">
      </div>
    </form>
  </div>
  <br>
<div style="background: #1f3772 ">
<!--<section class="container">-->
    @foreach($categorias as $categoria)
      <a href="{{ route('listar',['categoria'=> $categoria['id']]) }}"><h2>{{ $categoria['nome'] }}</h2>
    <div class="row" style="margin-bottom: 10px">       
      @foreach($categoria['empresas'] as $empresa)
        @include('card_empresa', ['empresa' => $empresa])
      @endforeach
    </div>
    @endforeach
<!--</section>-->
</div>
</div>
@endsection
@section('js')
@endsection