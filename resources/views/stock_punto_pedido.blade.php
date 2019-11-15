
@extends('layout')

@section('content')
 
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Productos Bajo Punto de Pedido</h1>

         <div class="card-header py-3">
              <h6 class="m-0 text-info font-weight-bold text-uppercase mb-4"><b> Fecha: {{date('d-m-Y')}} </b>

               <a href="{{ url('saldos_bajo_punto_pedido_pdf') }}"  class=" btn btn-warning btn-icon-split float-right" style="margin-left: 10px;">
                    <span class="icon text-white-50">
                      <i class="fas fa-print"></i>
                    </span>
                    <span class="text">Descargar PDF</span>
                  </a>
              
              </h6>
            </div>

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
                <th scope="col"  style="text-align:right;">Stock Minimo</th>   
                <th scope="col" style="text-align:right;">Punto de Pedido</th>
                <th scope="col"  style="text-align:right;">Stock Actual</th>
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
              <td style="text-align:right"> {{number_format($s->stock_minimo,2,",",".")}}</td>  
              <td style="text-align:right"> {{number_format($s->punto_pedido,2,",",".")}}</td>  
              <td style="text-align:right;"<?php if ($s->cantidad<=$s->stock_minimo) echo ' class="text-danger' ?>
                @if ($s->cantidad<=$s->stock_minimo)
                   data-toggle="tooltip" data-placement="left" title="Producto bajo Stock Mínimo"
                @endif
                > 
                {{number_format($s->cantidad,2,",",".")}}</td>    
              <?php $acum=$acum + $s->cantidad; ?>          
                     
            </tr>
            @endforeach
           
          </tbody>
        </table>
      </div>
    </div>
</div>
        <!-- /.container-fluid -->



@endsection

