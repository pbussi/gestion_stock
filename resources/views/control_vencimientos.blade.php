@extends('layout')
@section('content')
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Vencimiento de Productos</h1>
          <p class="mb-4"> </p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 text-info font-weight-bold text-uppercase mb-4"><b> {{$titulo}}</b>
       
              </h6>
            </div>



            <div class="card-body">
              <div class="table-responsive">
                
                    <?php $titulo=""; ?>
                    @foreach ($saldos as $s)
                    <?php setlocale(LC_TIME, 'es_ES.UTF-8');$nuevo_titulo=strftime("%B %Y",strtotime($s->vencimiento));?>

                    <?php if ($titulo!=$nuevo_titulo) {
                      if ($titulo!="") {
                          echo "</table>";
                        }
                        echo "<h4 style='margin-top:30px;'>$nuevo_titulo</h4>"; 
                     ?>


                              <table class="table-bordered table-striped small" id="dataTableww" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th scope="col">Codigo</th>
                                <th>Nombre</th>
                                <th>Marca</th>
                                <th>U.M.</th>
                                <th>Tipo</th>
                                <th>Lote</th>
                                <th>Deposito</th>
                                <th>Vencimiento</th>
                                <th>Cantidad</th>
                            </tr>
                          </thead>
                          <tbody>
                    <?php } ?>  
                    <tr>
                      <th>{{$s->codigo}}</th>
                      
                      <td><a href="{{ url('/movimiento_producto',$s->codigo) }}">{{ $s->nombre }}</a></td>
                      <td>{{ $s->marca }}</td>
                      <td>{{ $s->unidad_medida }}</td>
                       <td>{{ $s->tipo }}</td>
                        <td>{{ $s->lote }}</td>
                        <td>{{ $s->deposito }}</td>
                         <td <?php if (strtotime("now")>=strtotime($s->vencimiento))
                          echo "class='text-danger'";
                          ?>
                         > {{ date('d-m-Y', strtotime($s->vencimiento))}}</td>
                         <td>{{$s->total}}</td>
                      
                    </tr>

                    <?php $titulo=$nuevo_titulo; ?>
                    @endforeach
                 
                  </tbody>
                </table>
              </div>
        
     


            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection