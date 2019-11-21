
@extends('layout')

@section('content')

 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Gestión de Ventas</h1>
          <p class="mb-4">Ingreso de Pedidos</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Nueva venta</h6>
            </div>
            <div class="card-body">
              

 <form action="{{ url('/venta_nueva') }}" id=nueva_venta method=POST>
      @csrf
    
      <div class="form-group row">
          <div class="col-sm-3 mb-3 mb-sm-0">
            <label for="fecha">Fecha</label><br>
            <input type="date" name=fecha value="<?php echo date('Y-m-d'); ?>" />
          </div>    
      </div>

       <div class="form-group row"> 
              <div class="col-sm-6 mb-3 mb-sm-0">
                 <label for="tipo_prod">Elija cliente</label>
                 <select class="form-control" name=cliente>
                 @foreach ($clientes as $p)
                  <option value={{$p->id}}>{{$p->razon_social}}</option>
                @endforeach
              </select>
              </div>
          </div>

   <div class="form-group row"> 
              <div class="col-sm-6 mb-3 mb-sm-0">
                 <label for="tipo_prod">Lista de Precios</label>
                 <select class="form-control" name=lista>
                 @foreach ($listas as $p)
                  <option value={{$p->id}} >{{$p->nombre}}</option>
                @endforeach
              </select>
              </div>
          </div>


         <div class="form-group row">
            <div class="col-sm-12 mb-6 mb-sm-0">
               <p>Observaciones</p>
               <textarea name="observaciones" style="width: 60%"></textarea>
            </div>
         </div>
        <a href="#"  onclick='
        if ($("#fecha").val()==""){
          alert("Ingrese fecha valida");
          return;
        }
        document.getElementById("nueva_venta").submit();


        ' class="btn btn-success btn-icon-split">
         <span class ="icon text-white-50">
                      <i class="fas fa-check-double"></i>
                    </span>
                    <span class="text">Crear</span>
        </a>
     
    </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection

