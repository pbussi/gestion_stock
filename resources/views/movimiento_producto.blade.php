@extends('layout')
@section('content')
 <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Movimientos de Productos</h1>
          <p class="mb-4">Ingresos y Egresos registrados</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><b> {{$producto->nombre}}</b></h6>
            </div>
      <div class="card-body">
         <?php $pos=1 ?>
   @foreach ($movimientos as $dep =>$movs)

      <div class="form-group row ">
              <div class="col-sm-12 mb-3 mb-sm-0 card border-left-info">
                <p></p>
                <h5 class="text-info font-weight-bold text-uppercase mb-4"> {{ $dep }} </h5>
                <table  class="table  table-striped small" id="dataTable_<?php print $pos; ?>" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>Fecha</th>
                         <th>Tipo movimiento</th>
                        <th>Lote</th>
                        <th>Vencimiento</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                  </thead>
                 <?php $subtotal=0 ?>
                 @foreach ($movs as $mov)
                <tr><td>{{date('d-m-Y', strtotime($mov->fecha)) }}</td>
                  <td > {{$mov->comprobante_asociado }}</td>
                  <td>{{$mov->lote }}</td><td>{{date('d-m-Y', strtotime($mov->vencimiento)) }}</td>
                  <td @if ($mov->cantidad<0) class='text-danger' @endif ><b>{{$mov->cantidad }}</b></td>
                    <td><?php $subtotal=$subtotal+$mov->cantidad; print $subtotal ?></td></tr>
           
                @endforeach
                 <tfoot>
                    <tr>
                        <th></th>
                         <th></th>
                        <th></th>
                        <th></th>
                        <th align="right">Saldo: </th>
                        <th class='text-info font-weight-bold'>{{ $saldosxdep[$mov->depositos_id]['saldo'] }}</th>
                    </tr>

                </table>
              </div>
    </div>

         <script>// Call the dataTables jQuery plugin
                $(document).ready(function() {
                  $('#dataTable_<?php print $pos ?>').DataTable({
               columnDefs: [
    { orderable: false, targets: '_all' }
]
                });
                });
                </script>
                <?php  $pos++; ?>
   @endforeach
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection