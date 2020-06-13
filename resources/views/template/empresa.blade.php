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
  <link rel="stylesheet" href="<?=App::make('url')->to('/');?>/resources/assets/plugins/summernote/summernote-bs4.css">
  
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
  .select2-container .select2-selection--single{
      height: 40px !important;
    }
    </style>
  @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('empresas::dashboard') }}" class="brand-link">     
      <span class="brand-text font-weight-light">Compre do Pequeno</span><br>
      Painel Empresa
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
     

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         
               <li class="nav-item">
                <a href="{{ route('empresas::dashboard') }}" class="nav-link">
                  <i class="nav-icon fas fa-store"></i>
                  <p>
                    Minha Empresa
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('empresas::produtos::listar') }}" class="nav-link">
                  <i class="nav-icon fas fa-boxes"></i>
                  <p>
                    Meus Produtos
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('empresas::perfil') }}" class="nav-link">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                    Perfil
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('empresas::sair') }}" class="nav-link">
                  <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>
                   Sair 
                  </p>
                </a>
              </li>

             

          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        @yield('conteudo')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer no-print">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2020-{{ date('Y') }} ACIAPI/CDL.</strong> Todos os diretos reservados
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
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
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function(){
    $('.select2').select2();

  })
</script>
@yield('js')
</body>
</html>
