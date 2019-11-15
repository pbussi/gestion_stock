@extends('layout')
@section('content')
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Productos sin Stock</h1>
          <p class="mb-4">Listado por tipo de Productos</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Productos a listar</h6>
            </div>
            <div class="card-body">
 <form class="user" action="{{ url('/productos_sin_stock_seleccion') }}" id=productos_sin_stock_seleccion method=POST>
      @csrf
         <div class="form-group row">
            <div class="col-sm-0 mb-0 mb-sm-0">
            </div>
            <div class="col-sm-3">
              
                 <select class="form-control"  name=grupo>
                 @foreach ($agrupacion as $a)
                  <option  value="{{$a}}">{{$a}}</option>
                @endforeach
                </select>
              </div>

              <a href="#"  onclick="document.getElementById('productos_sin_stock_seleccion').submit();" class="btn btn-success btn-icon-split">
               <span class ="icon text-white-50">
                          <i class="fas fa-check-double"></i>
               </span>
               <span class="text">Listar</span>
              </a>
            </div>

            
            
        </div>
      
    </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection