<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Heladeria RINCON</title>

  <!-- Custom fonts for this template-->
  <link href={{ asset('/vendor/fontawesome-free/css/all.min.css') }} rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href={{ asset('/css/sb-admin-2.css') }} rel="stylesheet">

</head>
<body id="page-top">

  <!-- Page Wrapper -->
    <div id="wrapper">

       @include('sidebar')
       
        <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column" style="margin-top: 30px">


      <!-- Main Content -->
      <div id="content">
       {{-- @include('topbar') --}}
        @include('flash-message')
        @yield('content')



    </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
  <script src={{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}></script>

  <!-- Core plugin JavaScript-->
  <script src={{ asset('/vendor/jquery-easing/jquery.easing.min.js') }}></script>

  <!-- Custom scripts for all pages-->
  <script src={{ asset('/js/sb-admin-2.min.js') }}></script>

 <script src={{ asset('/vendor/chart.js/Chart.min.js') }}></script>
  <!-- Page level custom scripts -->
 <script src={{ asset('/js/demo/chart-area-demo.js') }}></script>
  <!--script src={{ asset('/js/demo/chart-pie-demo.js') }}></script-->


  <script src={{ asset('vendor/datatables/jquery.dataTables.min.js') }}></script>
  <script src={{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}></script>

  <!-- Page level custom scripts -->
  <script src={{ asset('js/demo/datatables-demo.js') }}></script>

</body>

</html>

 {{-- 
 <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>
--}}













{{--
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <title>Heladeria Rincon</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light"  style="background-color: #e3f2fd;">
  <a class="navbar-brand" href="#">
    <img src="/proyecto/heladeria_rincon/public/images/rincon.jpeg" width="50" height="50" alt="">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Stock
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ url('/productos') }}">Productos</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Ingreso de Insumos</a>
          <a class="dropdown-item" href="#">Salida de Insumos</a>
           <div class="dropdown-divider"></div>
           <a class="dropdown-item" href="#">Ingreso de Productos Elaborados</a>
           <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Informes</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Produccion
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Lotes de Produccion</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Informes</a>
          
        </div>
      </li>

 <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Ventas
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Pedidos</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Informes</a>
          
        </div>
      </li>

    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

      <div class="container">
            @yield('content')
        </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
--}}