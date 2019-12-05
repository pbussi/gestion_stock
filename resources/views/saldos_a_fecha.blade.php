
@extends('layout')

@section('content')
 
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Stock Actual de Productos</h1>

         <div class="card-header py-3">
              <h6 class="m-0 text-info font-weight-bold text-uppercase mb-4"><b> Saldos al {{date('d-m-Y')}} </b>

               <a href="{{ url('saldos_a_fecha_pdf') }}"  class=" btn btn-warning btn-icon-split float-right" style="margin-left: 10px;">
                    <span class="icon text-white-50">
                      <i class="fas fa-print"></i>
                    </span>
                    <span class="text">Descargar PDF</span>
                  </a>
              
              </h6>
            </div>

          <p class="mb-4">En todos los depósitos administrados por el sistema</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            
            <div class="card-body">
             <div class="table-responsive">
             <table class="table  small" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                 <th scope="col">Marca</th>
                <th scope="col">U.M.</th>
                <th scope="col"  style="text-align:center;">Saldo</th>
              </tr>
            </thead>
           <tbody>
            <?php $acum=0; ?>
            @foreach ($stock as $s)
              <tr>

              <th scope="row">{{ $s->id_producto }}</th>
              <td><a href=""> <b>{{ $s->nombre }}</b></a></td>
               <td>{{ $s->marca}}</td>
              <td>{{ $s->unidad_medida }}</td>
              <td style="text-align:right"> {{number_format($s->cantidad,2,",",".")}}</td>    
              <?php $acum=$acum + $s->cantidad; ?>          
                     
            </tr>
            @endforeach
            <thead>
             <tr style="height: 50px;">
                        <td colspan=7  style="text-align:right" >CANTIDAD TOTAL: <b>  <?php echo number_format($acum,2,",","."); ?></b></td></tr>
            <thead>
          </tbody>
        </table>
      </div>
    </div>
</div>
        <!-- /.container-fluid -->



@endsection

