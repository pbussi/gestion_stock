@extends('layout')
@section('content')
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Productos</h1>
          <p class="mb-4">Materias Primas, Insumos y Productos Elaborados</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Nuevo producto</h6>
            </div>
            <div class="card-body">
 <form class="user" action="{{ url('/producto_nuevo') }}" id=nuevo_prod method=POST>
      @csrf
        <div class="form-group">
          <input class="form-control"  type="text" placeholder="Codigo (de barra)" name=codigo id=codigo>
        </div>

         <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <input class="form-control" type="text" placeholder="Nombre" name=nombre id=nombre>
            </div>
            <div class="col-sm-3">
              <input class="form-control" type="text" placeholder="Marca" name=marca>
            </div>
            <div class="col-sm-3 mb-3 mb-sm-0">
               <input class="form-control" type="text" placeholder="Unidad de Medida" name=unidad_medida id=unidad_medida>
            </div>
        </div>
         <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <label for="llevastk">Lleva Stock?</label>
              <input class="" type="checkbox" placeholder="" name=lleva_stock>
            </div>
         </div>  
         <div class="form-group row"> 
              <div class="col-sm-6 mb-3 mb-sm-0">
                 <label for="tipo_prod">Tipo de Producto</label>
                 <select class="form-control"  style="width:30%;" name=tipo_producto_id>
                 @foreach ($tipos_producto as $p)
                  <option value={{$p->id}}>{{$p->nombre}}</option>
                @endforeach
              </select>
              </div>
          </div>
          <div class="form-group row"> 
              <div class="col-sm-4 mb-3 mb-sm-0">
           
                  <label for="stkmin">Stock Minimo</label>
                  <input class="form-control" type="number" min=0 placeholder="" name=stock_minimo id=stock_minimo>
              </div>
               <div class="col-sm-4 mb-3 mb-sm-0"> 
                <label for="stkmax">Stock Maximo</label>
                <input class="form-control" type="number" min=0 placeholder=""  name=stock_maximo id=stock_maximo>
              </div>
              <div class="col-sm-4 mb-3 mb-sm-0"> 
                 <label for="stkmin">Punto de Pedido</label>
                <input class="form-control" type="number" min=0 placeholder=""  name=punto_pedido id=punto_pedido>
              </div>
            </div>
          <div class="form-group row"> 
            <div class="col-sm-4 mb-3 mb-sm-0">
             <input class="form-control" type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="" data-type="currency" placeholder="Precio de Costo" name=precio_costo id=precio_costo>
         </div>
       </div>
        <div class="form-group row"> 
            <div class="col-sm-4 mb-3 mb-sm-0">
              <label for="foto">Imagen</label>
              <input class="form-control" type="file"  name=foto>
          </div>
        </div>
      </div>
       <div class="form-group row"> 
            <div class="col-sm-4 mb-3 mb-sm-0">
              <a href="#"  onclick="
              if (!(document.getElementById('codigo').value != '')){
                alert('ingrese codigo del producto');
                return false;
              }

               if (!(document.getElementById('nombre').value != '')){
                alert('ingrese Nombre del Producto');
                return false;
              }
                if (!(document.getElementById('unidad_medida').value != '')){
                alert('ingrese unidad de Medida del Producto');
                return false;
              }

              if (!(document.getElementById('stock_minimo').value>0)){
                alert('ingrese stock Minimo');
                return false;
              }
               if (!(document.getElementById('stock_maximo').value>0)){
                alert('ingrese stock Maximo');
                return false;
              }
               if (!(document.getElementById('punto_pedido').value>0)){
                alert('ingrese Punto de Pedido');
                return false;
              }
               if (!(document.getElementById('precio_costo').value!='')){
                alert('ingrese Precio de Costo');
                return false;
              }

              document.getElementById('nuevo_prod').submit();

              " class="btn btn-success btn-icon-split">
               <span class ="icon text-white-50">
                          <i class="fas fa-check-double"></i>
               </span>
               <span class="text">Crear Producto</span>
              </a>
            </div>
          </div>     
    </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection