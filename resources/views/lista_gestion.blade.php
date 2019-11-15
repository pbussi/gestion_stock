
@extends('layout')

@section('content')
 
<div class="container-fluid">
       <h1 class="h3 mb-2 text-gray-800">Gestion de lista de Precios</h1>

         <div class="card-header py-3">
              <h6 class="m-0 text-info font-weight-bold text-uppercase mb-4"><b> {{$lista->nombre}} </b>

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
                  <form method=post  action="{{ url('/lista_gestion') }}" id=lista_gestion>
                     @csrf
                     <table class="table-bordered table-striped small" id="dataTable" width="100%" cellspacing="0">
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
                                <td align=right>
                                    <input style="text-align: right;<?php
                                        if ($s->precio==0){
                                          echo "background-color: #40e3a8;";
                                        } else {echo "background-color: white;";}
                                    ?>" type=text size=7 name=precios[{{ $s->id }}] value='{{number_format($s->precio,2,",",".")}}'>
                                   </td>            
                           </tr>
                          @endforeach     
                          </tbody>
                    </table>
                    <input type=hidden name=lista_id value={{ $lista->id }}>
                    <a href="#" onclick="document.getElementById('lista_gestion').submit();" class="btn btn-success btn-icon-split float-right">
                     <span class ="icon text-white-50">
                     <i class="fas fa-archive"></i>
                      </span>
                      <span class="text">Guardar</span></a>



                 
                </form>
            <br><br>
              
                 <form method=post  id=lista_gestion_agregar action="{{ url('/lista_gestion_agregar') }}">
                     @csrf
                     <label for="tipo_prod">Incorporar productos</label><BR>
                     <select class="form-control float-left"  name=item style="width: 50%">
                        @foreach ($faltantes as $f)
                           <option value="{{$f->id}}"> {{$f->nombre}}</option>
                        @endforeach
                    </select>
                    <input type=hidden name=lista_id value={{ $lista->id }}>
                    <a href="#" onclick="document.getElementById('lista_gestion_agregar').submit();" class="btn btn-info btn-icon-split float-left" style="margin-top: 0px;">
                     <span class ="icon text-white-50">
                     <i class="fas fa-plus"></i>
                      </span>
                      <span class="text">Agregar</span></a>
                 </form>  <br><Br>
               </div>
          </div>
      </div>

   </div>       
        <!-- /.container-fluid -->

@endsection

