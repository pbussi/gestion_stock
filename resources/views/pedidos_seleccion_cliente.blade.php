@extends('layout')
@section('content')
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Ventas por Cliente </h1>
          <p class="mb-4"></p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Cliente a evaluar</h6>
            </div>
            <div class="card-body">
 <form class="user" action="{{ url('/pedidos_seleccion_cliente') }}" id=pedidos_seleccion_cliente method=POST>
      @csrf
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
               <label for="fecha_mov">Seleccione Cliente: </label>
               <select class="form-control text-uppercase"  name=cliente>
                 @foreach ($clientes as $c)
                  <option  value={{$c->id}} >{{$c->razon_social}}</option>
                @endforeach
                </select>
            </div>
        </div>

      
       <div class="form-group row">
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label for="fecha_mov">Desde</label>
                <input class="form-control" type="date" name=fecha_desde value="{{ date('d-m-Y') }}">
            </div>
            <div class="col-sm-3">
              <label for="fecha_mov">Hasta</label>
                <input class="form-control" type="date" name=fecha_hasta value="{{ date('d-m-Y') }}">
            </div>       
        </div>
              <a href="#"  onclick="document.getElementById('pedidos_seleccion_cliente').submit();" class="btn btn-success btn-icon-split">
               <span class ="icon text-white-50">
                          <i class="fas fa-check-double"></i>
               </span>
               <span class="text">Consultar</span>
              </a>
            </div>

     

            
            
        </div>
      
    </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection