
@extends('layout')

@section('content')

 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Produccion</h1>
          <p class="mb-4">Gestion de la fabricacion de productos</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Nuevo lote de produccion</h6>
            </div>
            <div class="card-body">
              

 <form action="{{ url('/lote_produccion_nuevo') }}" id=nuevo_lote method=POST>
      @csrf
    
      <div class="form-group row">
          <div class="col-sm-3 mb-3 mb-sm-0">
            <label for="fecha">Fecha</label>
            <input class="form-control" type="date" name=fecha_lote id=fecha_lote value="{{ date('d-m-Y') }}">
          </div>    
      </div>

       <div class="form-group row"> 
              <div class="col-sm-6 mb-3 mb-sm-0">
                 <label for="tipo_prod">Tipo de Base</label>
                 <select class="form-control"  name=base>
                    <option value="Blanca">Base Blanca</option>
                    <option value="Chocolate">Base Chocolate</option>
                    <option value="Dulce de leche">Base Dulce de leche</option>
              </select>
              </div>
      </div>





        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
               <label for="fecha">Temperatura Pasteurización (°C)</label>
              <input class="form-control" type="number" name=pasteurizacion_temperatura>
            </div>
            <div class="col-sm-3">
               <label for="fecha">Tiempo Pasteurización (Min.)</label>
              <input class="form-control" type="number"  name=pasteurizacion_tiempo>
            </div>          
        </div>
         <div class="form-group row">
            <div class="col-sm-12 mb-6 mb-sm-0">
               <p>Observaciones</p>
               <textarea name="observaciones" style="width: 60%"></textarea>
            </div>
         </div>
        <a href="#"  onclick='
        if ($("#fecha_lote").val()==""){
          alert("Ingrese fecha valida");
          return;
        }
        document.getElementById("nuevo_lote").submit();


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

