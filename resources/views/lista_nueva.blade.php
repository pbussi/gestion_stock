
@extends('layout')

@section('content')

 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Listas de Precios</h1>
          <p class="mb-4">Listas de Precios administradas por el sistema</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Nueva Lista</h6>
            </div>
            <div class="card-body">
              

 <form action="{{ url('/lista_nueva') }}" id=lista_nueva method=POST>
      @csrf
      <div class="form-group">
         <label for="nombre">Nombre</label>
        <input class="form-control" type="text" placeholder="" style="width:50%;" name=nombre>
      </div>
        <a href="#"  onclick="document.getElementById('lista_nueva').submit();" class="btn btn-success btn-icon-split">
         <span class ="icon text-white-50">
                      <i class="fas fa-check-double"></i>
                    </span>
                    <span class="text">Crear Lista</span>
        </a>
     
    </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection

