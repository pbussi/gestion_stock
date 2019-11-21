
@extends('layout')

@section('content')
 
<div class="container-fluid">
       <h1 class="h3 mb-2 text-gray-800">Informe</h1>

         <div class="card-header py-3" style="padding:0;">
              <h6 class="m-0 text-info font-weight-bold text-uppercase mb-3"><b> {{$lista->nombre}} </b>

                  <a href="{{ url('lista_pdf',$lista->id) }}"  class=" btn btn-warning btn-icon-split float-right" style="margin-left: 10px;">
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
                
                     <table class="table-bordered table-striped small"  width="100%" cellspacing="0">
                          <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                             <th scope="col">Marca</th>
                            <th scope="col">U.M.</th>
                            <th scope="col">Tipo</th>
                            <th scope="col" style="text-align:right;">$ Precio</th>
                          </tr>
                        </thead>
                         <tbody>
                          @foreach ($items as $s)
                            <tr>
                                <th scope="row">{{ $s->codigo }}</th>
                                <td> <b>{{ $s->nombre }}</b></td>
                                 <td>{{ $s->marca}}</td>
                                <td>{{ $s->unidad_medida }}</td>  
                                 <td>{{ $s->tipo }}</td>  
                                <td align=right>{{number_format($s->precio,2,",",".")}}
                                   </td>            
                           </tr>
                          @endforeach     
                          </tbody>
           
            <br><br>
              
                 
               </div>
          </div>
      </div>

   </div>       
        <!-- /.container-fluid -->

@endsection

