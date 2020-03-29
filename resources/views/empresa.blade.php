@extends('template.usuario')
@section('header')
<title>{{ $empresa['nome'] }}</title>
<style>

h2{
  background: #fdca0b;
  padding: 10px;
  color:#1f3772 !important;
  font-weight: bold !important;
}

  .card-contato .escrita{
        background: #fdca0b;
        padding: 5px;
        font-weight: bold;
        font-size: 28px;
        color: #1f3772;
        height:55px;
    }
    .card-contato .escrita img{
        height: 30px;
        margin-top:-8px
    }
     .card-contato .escrita span{
        font-size:20px;
    }
    .card-contato {
        margin-top: 20px;
    }
    .card-contato .escrita1 {
        background: #1f3772;
    text-transform: uppercase;
    padding: 4px;
    font-weight: bold;
    color: #fff;
    font-size: 11px;
    margin-top: -15px;
    position: absolute;
    margin-left: 26px;
    }

</style>
@endsection
@section('conteudo')
<section class="container" style="background: #fff;padding-top:10px; margin-top:20px">
   <div class="row">
      <div class="col-md-4">
        <img class="rounded" src="<?=App::make('url')->to('/');?>/uploads/{{$empresa['marca'] }}">
      </div>
      <div class="col-md-8">
        <h1>{{ $empresa['nome']}}</h1>
        <p>{{ $empresa['categoria'] }}</p>
      </div>
   </div>
   <div class="row">
    <div class="col-md-12">
      <h3>Contatos:</h3>
      
      @foreach($empresa['contatos'] as $contato)
      <div class="card-contato">
          <div class="escrita1">
              @if($contato['tipo'] == 'telefone') LIGUE
              @elseif($contato['tipo'] == 'site') ACESSE
              @else WHATSAPP @endif
          </div>
          <a href="{{ $contato['link'] }}" target="_blank">
          <div class="escrita">
              @if($contato['tipo'] != 'site')
                <span>{{ $contato['ddd'] }}</span> {{ $contato['escrita'] }}
              @else
                  <span style="font-size: 17px;">{{ $contato['escrita'] }}</span>
              @endif

              @if($contato['tipo'] == 'telefone') <img src="<?=App::make('url')->to('/');?>/resources/assets/telefone.png">
              @elseif($contato['tipo'] == 'site') <img src="<?=App::make('url')->to('/');?>/resources/assets/site.png">
              @else <img src="<?=App::make('url')->to('/');?>/resources/assets/whatsapp.png"> @endif        
          </div>
          </a>
      </div>
    @endforeach


    </div>

      <div class="col-md-12">
        <h3>Descrição:</h3>
        {{ $empresa['descricao'] }}
      </div>

      <div class="col-md-12">
        <h3>Hórario de Funcionamento:</h3>
        {{ $empresa['horario_funcionamento'] }}
      </div>
      <br>
      <div class="col-md-12">
        <h3>Cidades Atendidas:</h3>
        @foreach($empresa['cidades'] as $cidade)
          <b>{{ $cidade['cidade'] }}</b><br>
          Realiza Entrega: {{ ($cidade['entrega'] == 's' ? 'Sim' : 'Não')}}<br>
          Taxa de Entrega: {{ $cidade['taxa_entrega'] }}<br>
        @endforeach
      </div>
</section>
@endsection
@section('js')
@endsection