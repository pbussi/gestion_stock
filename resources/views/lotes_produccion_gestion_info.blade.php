
@extends('layout')

@section('content')
  <script src=http://localhost/proyecto/gestion_stock/public/vendor/jquery/jquery.min.js></script>
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
    <a class="nav-link" href="{{ url('/lotes_produccion_gestion',$lote->id) }}">Insumos utilizados</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/lotes_produccion_gestion_terminados',$lote->id) }}">Productos terminados</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="{{ url('/lotes_produccion_gestion_info',$lote->id) }}">Información del Lote</a>
  </li>
  
</ul> 

 <div class=row>
 <div class="col-xl-5 col-md-4 mb-5">

              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold  text-uppercase mb-1">BASE</div>
                      <div class="h3 mb-0 font-weight-bold text-gray-800">Base {{$lote->base}}</div>
                         @if ($lote->estado==1)
                        <i class="fas fa-edit fa-2x text-gray-300 float-right" data-toggle="modal" data-target="#edita_base"></i>
                        @endif
                    </div> 
                  </div>
                </div>
              </div>
            </div>
</div>
        <div class=row>
            <div class="col-xl-3 col-md-6 mb-3">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Temp. Pasteurizacion</div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800">{{$lote->pasteurizacion_temperatura}}°C</div>
                        @if ($lote->estado==1)  
                         <i class="fas fa-edit fa-2x text-gray-300 float-right" data-toggle="modal" data-target="#edita_pasteurizacion"></i>
                        @endif
                    </div> 
                  </div>
                </div>
              </div>
            </div>


          <div class="col-xl-3 col-md-6 mb-3">

              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1 "style="color:#36b9cc;">Tiempo Pasteurizacion</div>
                      <div class="h7 mb-0 font-weight-bold text-gray-800">{{$lote->pasteurizacion_tiempo}} Min.</div>
                         @if ($lote->estado==1)
                        <i class="fas fa-edit fa-2x text-gray-300 float-right" data-toggle="modal" data-target="#edita_tiempo_pasteurizacion"></i>
                        @endif
                    </div> 
                  </div>
                </div>
              </div>
            </div>

             <div class="col-xl-5 col-md-6 mb-3">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Observaciones</div>
                      <div class="small mb-0 text-gray-800"><pre>{{$lote->observaciones}}</pre></div>
                       @if ($lote->estado==1)
                        <i class="fas fa-edit fa-2x text-gray-300 float-right" data-toggle="modal" data-target="#edita_observaciones"></i>
                       @endif
                    </div> 
                  </div>
                </div>
              </div>
            </div>

    </div>




<!-- Modal -->
<div class="modal fade" id="edita_pasteurizacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Temperatura de pasteurización</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/lotes_produccion_gestion_info',$lote->id) }}" id=xx method=GET>
      @csrf
        <div class="modal-body">
          <label for="fecha">Establecer temperatura</label>
          <input class="form-control" type="number" name=pasteurizacion_temperatura value={{$lote->pasteurizacion_temperatura}}>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <input type="submit" class="btn btn-primary" value=Guardar />
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="edita_tiempo_pasteurizacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tiempo de pasteurización</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/lotes_produccion_gestion_info',$lote->id) }}" id=xx method=GET>
      @csrf
        <div class="modal-body">
          <label for="fecha">Establecer tiempo</label>
          <input class="form-control" type="number" name=pasteurizacion_tiempo value={{$lote->pasteurizacion_tiempo}}>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <input type="submit" class="btn btn-primary" value=Guardar />
        </div>
      </form>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="edita_observaciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Observaciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/lotes_produccion_gestion_info',$lote->id) }}" id=xx method=GET>
      @csrf
        <div class="modal-body">
          <label for="fecha">Establecer observaciones</label>
          <textarea class="form-control" type="number" name=observaciones>
            {{$lote->observaciones}}
          </textarea> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <input type="submit" class="btn btn-primary" value=Guardar />
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="edita_base" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Base de Producción</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/lotes_produccion_gestion_info',$lote->id) }}" id=xx method=GET>
      @csrf
        <div class="modal-body">
           <label for="tipo_prod">Tipo de Base</label>
             <select class="form-control"  name=base>
                @foreach ($bases as $b)
                   <option value="{{$b}}"> Base {{$b}}</option>
                @endforeach
              </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <input type="submit" class="btn btn-primary" value=Guardar />
        </div>
      </form>
    </div>
  </div>
</div>


@endsection