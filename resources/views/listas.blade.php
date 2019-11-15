
@extends('layout')

@section('content')
 
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Listas de Precios</h1>
          <p class="mb-4">Listas de Precios manejadas por el sistema</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Disponibles para Clientes Heladería Rincón
              <a href="{{ url('/lista_nueva') }}" class=" btn btn-success btn-icon-split float-right">
                    <span class="icon text-white-50">
                      <i class="fas fa-check-double"></i>
                    </span>
                    <span class="text">Crear nueva Lista</span>
                  </a>
              </h6>
            
            </div>
            <div class="card-body">
             <div class="table-responsive">
             <table class="table table-bordered small" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
              
                <th scope="col">Nombre</th>
                <th scope="col">Accion</th>
              </tr>
            </thead>
           <tbody>
            @foreach ($listas as $l)
              <tr>
     
              <td><a href="{{ url('/lista_gestion',$l->id) }}"> {{ $l->nombre }}</a></td>
            
              <td class="w-10"> 
                        <a href="{{ url('/lista_edit',$l->id) }}" class="float-left">
                        <span class="icon">
                          <i class="fas fa-edit"></i>
                        </span>
                      </a>
                      &nbsp;  &nbsp;
                      <a href="{{ url('/lista_borrar',$l->id) }}" class="">
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
        <!-- /.container-fluid -->



@endsection

