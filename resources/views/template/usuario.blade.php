<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  @yield('header')
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=App::make('url')->to('/');?>/resources/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?=App::make('url')->to('/');?>/resources/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=App::make('url')->to('/');?>/resources/assets/css/adminlte.min.css">
  <link rel="stylesheet" href="<?=App::make('url')->to('/');?>/resources/assets/css/carne.css">
  <link rel="stylesheet" href="<?=App::make('url')->to('/');?>/resources/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?=App::make('url')->to('/');?>/resources/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?=App::make('url')->to('/');?>/resources/assets/plugins/daterangepicker/daterangepicker.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    img {
      max-width: 100%;
      height: auto;
    }
    .select2-container .select2-selection--single{
      height: 40px !important;
    }
  </style>
  @yield('css')
</head>
<body style="background: #1f3772">
<!-- Site wrapper -->
<div class="wrapper">
  <div class="container" >
    <a href="<?=App::make('url')->to('/');?>"><img src="<?=App::make('url')->to('/');?>/resources/assets/topo.png"></a>
  </div>
  
  

</div>




@yield('conteudo')

  <div class="container" style="padding:20px; color: #fff">
        <center>Projeto desenvolvido por ACIPI/CDL, IFNMG Pirapora e SEBRAE</center>
   
  </div>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/moment/moment.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=App::make('url')->to('/');?>/resources/assets/js/adminlte.min.js"></script>
<!-- datatable -->
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js""></script>
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/jquery.priceformat.min.js"></script>
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/select2/js/select2.min.js"></script>
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/jquery.MultiFile.min.js"></script>
<script>
  $(function(){
    $('.select2').select2();

  })
</script>
@yield('js')
</body>
</html>
