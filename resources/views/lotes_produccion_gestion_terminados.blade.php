
@extends('layout')

@section('content')
<script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
  <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Lote Producción  Nro. <B> <?php echo "PROD".str_pad($lote->id,6,"0", STR_PAD_LEFT); ?></B> </h1>


    <p class="mb-4">Gestion de ingredientes de la produccion</p>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0  text-primary"> Fecha:  {{ $lote->fecha }} </h6>
           
        </div>
      </div>
    <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link " href="{{ url('/lotes_produccion_gestion',$lote->id) }}">Insumos utilizados</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="{{ url('/lotes_produccion_gestion_terminados',$lote->id) }}">Productos terminados</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/lotes_produccion_gestion_info',$lote->id) }}">Información del Lote</a>
  </li>
  
</ul>  
        <div class="card-body">
         <div class="table-responsive">
          <table class="table table-bordered small" id="xxdataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th scope="col">Codigo</th>
              <th scope="col">nombre</th>
              <th scope="col">Unidad de Medida</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Accion</th>
            </tr>
          </thead>
       <tbody>
        @foreach ($terminados as $t)
          <tr>
            <td>{{ $t->id }}</td>
            <td> {{ $t->nombre }}</td>
            <td>{{ $t->unidad_medida}}</td>
            <td>{{ $t->cantidad}}</td>
            <td class="w-10"> 
               @if ($lote->estado==1)
                 <a href="{{ url('/lotes_produccion_gestion_terminados',$lote->id) }}?borrar={{ $t->pt_id}}" class="float-left">
                 <span class="icon"><i class="fas fa-trash"></i></span></a>
              @endif
             </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

    

@if ($lote->estado==1)
<form action="{{ url('/lotes_produccion_gestion_terminados',$lote->id) }}" id=nuevo_sabor method=POST>
<div class="form-group row">
      @csrf
        <div class="col-sm-3 mb-3 mb-sm-0">
          <label for="lote_numero">Producto</label>
             <select class="form-control"  name=producto id=producto>
               <option value=0 >Elija producto</option>
               @foreach ($productos as $p)
                <option value={{$p->id}}>{{$p->nombre}}</option>
              @endforeach
            </select>
        </div>
        <div class="col-sm-1 mb-3 mb-sm-0">
          <label for="unidad_medida">Cantidad</label>   
          <input class="form-control" type="text" name=cantidad id=cantidad >
        </div>
        <div class="col-sm-1 mb-3 mb-sm-0">
          <label for="unidad_medida"></label>
            <a href="#"  onclick="
                  if (!(parseFloat($('#cantidad').val())>0)){
                    alert('Ingrese cantidad');
                    return;
                  }
                    document.getElementById('nuevo_sabor').submit(); "
                  class="btn btn-success btn-icon-split" style="margin-top: 7px;">
            <span class ="icon text-white-50">
                <i class="fas fa-check-double"></i>
            </span>
            <span class="text">Agregar</span></a>
        </div>
  
  </div>
</form>      <!-- /.container-fluid -->

<script>
  $(document).ready(function() { 



  });
</script>

@endif

@endsection