<style>
    .card-empresa{
        background:#fff;
        border-radius:10px;
        padding: 10px 0px;
    height: 367px;
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
        margin-top:-8px
    }
    .card-empresa .card-contato .escrita span{
        font-size:20px;
    }
    .card-empresa .card-contato {
        margin-top: 20px;
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
    }

    .card-empresa .conteudo{
        padding: 0 45px;
    }
    .imgclick{
        width: 45px;
    float: right;
    margin-top: -37px;
    margin-right: -16px;
    }
</style>
<div class="col-md-4" >
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
</div>
</div>
</div>