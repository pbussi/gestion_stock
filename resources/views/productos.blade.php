@extends('layout')

@section('content')
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">{{$titulos[0]}}</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-4">
              <h6 class="m-0 font-weight-bold text-primary">{{$titulos[2]}}
<a href="{{ url('/productos_saldos_pdf') }}?tipo=<?php echo Request::path(); ?>" class=" btn btn-warning btn-icon-split float-right" style="margin-left: 10px;">
                    <span class="icon text-white-50">
                      <i class="fas fa-print"></i>
                    </span>
                    <span class="text">Saldos</span>
                  </a>
              <a href="{{ url('/producto_nuevo') }}"  class=" btn btn-success btn-icon-split float-right" style="margin-left: 10px;">
                    <span class="icon text-white-50">
                      <i class="fas fa-check-double"></i>
                    </span>
                    <span class="text">Crear nuevo</span>
                  </a>
 <a href="{{ url('/productos_pdf') }}?tipo=<?php echo Request::path(); ?>" class=" btn btn-info btn-icon-split float-right">
                    <span class="icon text-white-50">
                      <i class="fas fa-file-pdf"></i>
                    </span>
                    <span class="text">Catalogo</span>
                  </a>
                   
                 
           </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped small" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>U.M.</th>
                        <th>Tipo</th>
                        <th>Precio Costo</th>
                        <th>Lleva Stock</th>
                        <th>Stock Minimo</th>
                        <th>Stock Maximo</th>
                        <th>Punto Pedido</th>
                        <th class="w-10"></th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($productos as $p)
                    <tr>
                      <th scope="row"><small>{{ $p->codigo }}</small></th>
                      <td>
                        @if ($p->imagen != '')
                        <img src='data:image/JPG;base64,{{base64_encode($p->imagen)}}' width=60px;/>
                        @endif
                      </td>
                      <td class="text-uppercase" style="width:30%"><a href="{{ url('/movimiento_producto',$p->id) }}"><B>{{ $p->nombre }}</B></a></td>
                      <td  style="width:5%">{{ $p->marca }}</td>
                      <td>{{ $p->unidad_medida }}</td>
                      <td>{{ $p->tipo_nombre }}</td>
                      <td style="text-align: right;">${{ $p->precio_costo }}</td> 
                      <td>
                        @if ($p->lleva_stock === 1)
                        SI
                        @else
                        NO
                        @endif
                      </td>
                      <td>{{ $p->stock_minimo }}</td>
                      <td>{{ $p->stock_maximo }}</td>
                      <td>{{ $p->punto_pedido }}</td>
                      <td class="w-10" style="width:20%"> 
                        <a href="{{ url('/producto_edit',$p->id) }}" class="float-left">
                        <span class="icon">
                          <i class="fas fa-edit">  &nbsp;  &nbsp;</i>
                        </span>
                        </a>
                       
                        <a href="{{ url('/productos') }}?borrar={{$p->id}}" class="float-left">
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
@endsection