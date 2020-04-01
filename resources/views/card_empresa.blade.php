
<div class="col-md-4 col-lg-4 col-xs-4 col-sm-4 coluna" >
    <div class="card-empresa">
    <div class="topo">
        @if($empresa['marca'] == '')
            <h3>{{ $empresa['nome'] }}</h3>
        @else
            <center><img src="<?=App::make('url')->to('/');?>/uploads/{{$empresa['marca'] }}"></center>
        @endif
    </div>
    <div class="conteudo">
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
        <img class="imgclick" src="<?=App::make('url')->to('/');?>/resources/assets/click.png">            
        </a>
    </div>
    @endforeach

   <!-- <a href="{{ route('getEmpresa',$empresa['id']) }}">
    <div class="card-contato">
        <div class="escrita">+ Informações</div>
    </div>
-->
</a>
</div>
</div>
</div>