@extends('layout')
@section('content')
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Ventas no cumplidas por falta de Stock</h1>
          <p class="mb-4"></p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"></h6>
            </div>
            <div class="card-body">
 <form class="user" action="{{ url('/ventas_no_cumplidas_seleccion') }}" id=ventas_no_cumplidas_seleccion method=POST>
      @csrf
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <div class="form-check">
                 <input type="radio" class="form-check-input" id="opciones" name="opciones" value="1" checked onclick="$('#fechas').hide()">
                 <label class="form-check-label" for="historico" >Histórico</label>
              </div>

              <div class="form-check">
                <input type="radio" class="form-check-input" id="opciones" name="opciones" value="2" onclick="$('#fechas').show()">
                <label class="form-check-label" for="periodo">Por período</label>
              </div>          
            </div>
        </div>


      
       <div class="form-group row" id=fechas >
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label for="fecha_mov">Desde</label>
                <input class="form-control" type="date" name=fecha_desde value="{{date('d-m-Y') }}">
            </div>
            <div class="col-sm-3">
              <label for="fecha_mov">Hasta</label>
                <input class="form-control" type="date" name=fecha_hasta value="{{date('d-m-Y') }}">
            </div>       
        </div>


   
              <a href="#"  onclick="document.getElementById('ventas_no_cumplidas_seleccion').submit();" class="btn btn-success btn-icon-split">
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



<script>
  $(document).ready(function() { 
    $('#fechas').hide();
});
</script>
@endsection
