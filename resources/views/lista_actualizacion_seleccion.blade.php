@extends('layout')
@section('content')
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Actualización de Listas de Precios </h1>
          <p class="mb-4">Actualización Global por Lista</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Lista a actualizar</h6>
            </div>
            <div class="card-body">
 <form class="user" action="{{ url('/lista_actualizacion_seleccion') }}" id=lista_actualizacion_seleccion method=POST>
      @csrf
         <div class="form-group row">
            <div class="col-sm-0 mb-0 mb-sm-0">
            </div>
            <div class="col-sm-5">
            
                 <select class="form-control"  name=lista>
                 @foreach ($listas as $l)
                  <option  value={{$l->id}} >{{$l->nombre}}</option>
                @endforeach
                </select>
              </div>
             
              <a href="#"  onclick="document.getElementById('lista_actualizacion_seleccion').submit();" class="btn btn-success btn-icon-split">
               <span class ="icon text-white-50">
                          <i class="fas fa-check-double"></i>
               </span>
               <span class="text">Ingresar</span>
              </a>
            </div>

            
            
        </div>
      
    </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection