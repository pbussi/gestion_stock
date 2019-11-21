@extends('layout')

@section('content')
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Clientes</h1>
          <p class="mb-4">Clientes Heladería Rincón</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Gestion de datos de clientes


              <a href="{{ url('/clientes_pdf') }}" class=" btn btn-warning btn-icon-split float-right" style="margin-left: 10px;">
                    <span class="icon text-white-50">
                      <i class="fas fa-print"></i>
                    </span>
                    <span class="text">Listado Clientes</span>
                  </a>              
 
                               <a href="{{ url('/cliente_nuevo') }}"  class=" btn btn-success btn-icon-split float-right">
                    <span class="icon text-white-50">
                      <i class="fas fa-check-double"></i>
                    </span>
                    <span class="text">Crear nuevo</span>
                  </a>
           </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped small" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                        <th>Razon Social</th>
                        <th>CUIT</th>
                        <th>Direccion</th>
                        <th>Localidad</th>
                        <th>Provincia</th>
                        <th>Telefono</th>
                        <th>Mail</th>
                     <!--   <th>Lista asociada</th>  -->
                        <th class="w-10"></th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($clientes as $p)
                    <tr>
                      <th scope="row"><small>{{ $p->id }}</small></th>
                      <td class="text-uppercase" style="width:20%"><a href="{{ url('/cliente_edit',$p->id) }}"><B>{{ $p->razon_social }}</B></a></td>
                      <td  style="width:12%">{{ $p->cuit }}</td>
                      <td>{{ $p->direccion }}</td>
                      <td>{{ $p->localidad }}</td>
                      <td>{{ $p->provincia }}</td>
                      <td>{{ $p->telefono }}</td>
                      <td>{{ $p->mail }}</td>
                    <!--  <td>{{ $p->lista_precios_id }}</td>  -->
                      <td class="w-10"> 
                        <a href="{{ url('/cliente_edit',$p->id) }}" class="float-left">
                        <span class="icon">
                          <i class="fas fa-edit"></i>
                        </span>
                        </a>
                         <a href="{{ url('/clientes') }}?borrar={{$p->id}}" class="float-left">
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