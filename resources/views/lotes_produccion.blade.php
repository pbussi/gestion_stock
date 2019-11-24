@extends('layout')

@section('content')
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Lotes de Produccion</h1>
          <p class="mb-4">Gestion de Lotes de Produccion</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Lotes de Produccion
              <a href="{{ url('/lote_produccion_nuevo') }}"  class=" btn btn-success btn-icon-split float-right">
                    <span class="icon text-white-50">
                      <i class="fas fa-check-double"></i>
                    </span>
                    <span class="text">Crear nuevo Lote</span>
                  </a>
           </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped small" id="dataTableQ" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th scope="col">Numero</th>
                        <th>Fecha</th>
                        <th>Base</th>
                        <th>Temperatura Pasteurización</th>
                        <th>Tiempo Pasteurización</th>
                        <th>Estado</th>
                        <th class="w-10">Accion</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($lotes as $p)
                    <tr>
                      <td><a href="{{ url('/lotes_produccion_gestion',$p->id) }}">
                        <?php echo "PROD".str_pad($p->id,6,"0", STR_PAD_LEFT); ?>

                      </a></td>
                      <td class="date">{{date('d-m-Y', strtotime($p->fecha)) }}</td>
                      <td>{{ $p->base }}</td>     
                      <td>{{ $p->pasteurizacion_temperatura }}</td>
                      <td>{{ $p->pasteurizacion_tiempo }}</td>     
                      <td>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" 
                          id="{{$p->id}}" @if ($p->estado === 1) checked="true" @endif>
                          <label class="custom-control-label" for="{{$p->id}}"></label>
                        </div>
                      </td>
                      <td class="w-10"> 
                      <a href="#" class="float-right">
                        <span class="icon">
                          <i class="fas fa-trash"></i>
                        </span>
                      </a>
                      </td>
                    </tr>
                    @endforeach
                 
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

<script>
  $(document).ready(function() { 
    var x=$('#dataTableQ').DataTable();
    x.order( [ [ 1, 'desc' ]] ).draw();

    $('input:checkbox').change(function() {
      $.ajax({
      url: 'lote_produccion_cambiar_estado/'+this.id
      });
    });
});  
</script>
@endsection