
@extends('layout')

@section('content')

 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Productos</h1>
          <p class="mb-4">Productos manejados por el sistema</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Modificar Producto </h6>
            </div>
            <div class="card-body">
              

 <form action="{{ url('/producto_edit') }}" id=producto_edit method=POST  enctype="multipart/form-data">
  @csrf
         <div class="form-group">
           <input type="hidden" name=id value="{{$producto->id}}">
           <label for="codigo">Codigo de barras</label>
          <input class="form-control"  type="text" placeholder="Codigo (de barra)" name=codigo readonly="readonly" value="{{$producto->codigo}}">
        </div>

         <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
               <label for="nombre">Nombre</label>
              <input class="form-control" type="text"  name=nombre value="{{$producto->nombre}}">
            </div>
            <div class="col-sm-3">
               <label for="marca">Marca</label>
              <input class="form-control" type="text" placeholder="Marca" name=marca value="{{$producto->marca}}">
            </div>
            <div class="col-sm-3 mb-3 mb-sm-0">
               <label for="unidad_medida">Unidad de Medida</label>
               <input class="form-control" type="text" placeholder="Unidad de Medida" name=unidad_medida value="{{$producto->unidad_medida}}">
            </div>
        </div>
         <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <label for="llevastk">Lleva Stock?</label>
              <input class="" type="checkbox" placeholder="" name=lleva_stock @if ($producto->lleva_stock==1) checked @endif>
            </div>
         </div>  
         <div class="form-group row"> 
              <div class="col-sm-6 mb-3 mb-sm-0">
                 <label for="tipo_prod">Tipo de Producto</label>
                 <select class="form-control"  name=tipo_producto_id>
                 @foreach ($tipos_producto as $p)
                  <option  @if ($p->id == $producto->tipo_producto_id) selected="selected" @endif  value={{$p->id}} >{{$p->nombre}}</option>
                @endforeach
                </select>
              </div>
          </div>
          <div class="form-group row"> 
              <div class="col-sm-4 mb-3 mb-sm-0">
           
                  <label for="stkmin">Stock Minimo</label>
                  <input class="form-control" type="text" placeholder="" name=stock_minimo value="{{$producto->stock_minimo}}">
              </div>
               <div class="col-sm-4 mb-3 mb-sm-0"> 
                <label for="stkmax">Stock Maximo</label>
                <input class="form-control" type="text" placeholder=""  name=stock_maximo value="{{$producto->stock_maximo}}">
              </div>
              <div class="col-sm-4 mb-3 mb-sm-0"> 
                 <label for="stkmin">Punto de Pedido</label>
                <input class="form-control" type="text" placeholder=""  name=punto_pedido value="{{$producto->punto_pedido}}">
              </div>
            </div>
          <div class="form-group row"> 
            <div class="col-sm-4 mb-3 mb-sm-0">
             <label for="precio_costo">Precio de Costo</label>
             <input class="form-control" type="text" placeholder="Precio de Costo" name=precio_costo value="{{$producto->precio_costo}}">
         </div>
       </div>
        <div class="form-group row"> 
            <div class="col-sm-4 mb-3 mb-sm-0">
              <label for="stkmax">Imagen</label>
             <img src='data:image/JPG;base64,{{base64_encode($producto->imagen)}}' width=200px;/>
              <input class="form-control" type="file"  name=foto>
            </div>
        </div>
       <div class="form-group row"> 
            <div class="col-sm-4 mb-3 mb-sm-0">
              <a href="#"  onclick="document.getElementById('producto_edit').submit();" class="btn btn-success btn-icon-split">
               <span class ="icon text-white-50">
                          <i class="fas fa-check-double"></i>
               </span>
               <span class="text">Modificar Producto</span>
              </a>
            </div>
          </div>     
    </form>






<!--
<div class="form-group">
        <input type=hidden name=id value="{{$producto->id}}"
         <label for="nombre">Nombre</label>
        <input class="form-control" type="text" placeholder="" style="width:50%;" name=nombre value="{{$producto->nombre}}">
        <br>
        <label for="marca">Marca</label>
        <input class="form-control" type="text" placeholder="" style="width:50%;" name=marca value="{{$producto->marca}}">
    

      </div>
        <a href="#"  onclick="document.getElementById('producto_edit').submit();" class="btn btn-success btn-icon-split">
         <span class ="icon text-white-50">
                      <i class="fas fa-check-double"></i>
                    </span>
                    <span class="text">Modificar</span>
        </a>
     
    </form>
-->
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection


