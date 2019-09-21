@extends('layout')
@section('content')
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Movimientos</h1>
          <p class="mb-4">Entradas y Salidas de Materias Primas e Insumos</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Egreso de MP</h6>
            </div>
            <div class="card-body">
 <form class="user" action="{{ url('/movimiento_mp_salida_seleccion') }}" id=movimiento_mp_salida_seleccion method=POST>
      @csrf
         <div class="form-group row">
            <div class="col-sm-0 mb-0 mb-sm-0">
            </div>
            <div class="col-sm-3">
              <input class="form-control" type="text" placeholder="Buscar Productos" name=buscar>
            </div>
            <div class="col-sm-3 mb-3 mb-sm-0">
              <a href="#"  onclick="document.getElementById('movimiento_mp_salida_seleccion').submit();" class="btn btn-success btn-icon-split">
               <span class ="icon text-white-50">
                          <i class="fas fa-check-double"></i>
               </span>
               <span class="text">Buscar</span>
              </a>
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
              
                 @foreach ($productos as $p)
                    <li><a href="{{ url('/movimiento_mp_salida',$p->id) }}" >{{ $p->nombre }} </a></li>    
                 @endforeach


            </div>
            
        </div>
      
    </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection