
@extends('layout')

@section('content')
 
<div class="container-fluid">
       <h1 class="h3 mb-2 text-gray-800">Stock Valorizado de Productos</h1>

         <div class="card-header py-3">
              <h6 class="m-0 text-info font-weight-bold text-uppercase mb-4"><b> Fecha: {{date('d-m-Y')}} </b>

                  <a href="{{ url('stock_valorizado_pdf') }}"  class=" btn btn-warning btn-icon-split float-right" style="margin-left: 10px;">
                    <span class="icon text-white-50">
                      <i class="fas fa-print"></i>
                    </span>
                    <span class="text">Descargar PDF</span>
                  </a>
              
              </h6>
          </div>

      

</div>
        
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            
            <div class="card-body">
               <div class="table-responsive">
                   <table class="table-bordered table-striped small" id="dataTable" width="100%" cellspacing="0">
                   <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nombre</th>
                       <th scope="col">Marca</th>
                      <th scope="col">U.M.</th>
                      <th scope="col" style="text-align:right;">Stock</th>
                      <th scope="col" style="text-align:right;">$ Costo</th>
                      <th scope="col" style="text-align:center;">$ Total</th>
                    </tr>
                  </thead>
                   <tbody>
                     <?php $total=0 ?>
                    @foreach ($stock as $s)
                      <tr>
                          <th scope="row">{{ $s->id_producto }}</th>
                          <td><a href=""> <b>{{ $s->nombre }}</b></a></td>
                           <td>{{ $s->marca}}</td>
                          <td>{{ $s->unidad_medida }}</td>
                          <td align=right> {{number_format($s->cantidad,2)}}</td>      
                          <td align=right>$ {{number_format($s->precio_costo,2,",",".")}}</td>   
                          <td align=right> $ {{number_format($s->total,2,",",".")}}</td>     
                          <?php $total=$total+$s->total;?>                 
                     </tr>
                    @endforeach     
                      <tr style="height: 50px;  ">
                        <td colspan=7 align=right class="text-success"><b>TOTAL:  $ <?php echo number_format($total,2,",","."); ?></b></td>
                      </tr>           
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <!-- /.container-fluid -->

@endsection

