@extends('layout')

@section('content')
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Catalogo de productos</h1>
          <p class="mb-4">Listas de productos manejados por el sistema</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Productos
              <a href="{{ url('/producto_nuevo') }}"  class=" btn btn-success btn-icon-split float-right">
                    <span class="icon text-white-50">
                      <i class="fas fa-check-double"></i>
                    </span>
                    <span class="text">Crear nuevo Producto</span>
                  </a>
           </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered small" id="dataTable" width="100%" cellspacing="0">
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
                        <th class="w-10">Accion</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($productos as $p)
                    <tr>
                      <th scope="row">{{ $p->codigo }}</th>
                      <td></td>
                      <td><a href="">{{ $p->nombre }}</a></td>
                      <td>{{ $p->marca }}</td>
                      <td>{{ $p->unidad_medida }}</td>
                      <td>{{ $p->tipo_nombre }}</td>
                      <td>{{ $p->precio_costo }}</td>
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
                      <td class="w-10"> 
                        <a href="{{ url('/producto_edit',$p->id) }}" class="float-left">
                        <span class="icon">
                          <i class="fas fa-edit"></i>
                        </span>
                      </a>
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
@endsection