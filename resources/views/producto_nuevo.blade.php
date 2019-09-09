
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
              

 <form class="user" action="{{ url('/producto_nuevo') }}" id=producto_nuevo method=POST>
      @csrf
        <div class="form-group">
          <input class="form-control"  type="text" placeholder="Codigo (de barra)" name=codigo>
        </div>

         <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <input class="form-control" type="text" placeholder="Nombre" name=nombre>
            </div>
            <div class="col-sm-6">
              <input class="form-control" type="text" placeholder="Marca" name=marca>
            </div>
        </div>

        <div class="form-group">
        <label for="precioCosto">Precio de Costo</label>
        <input class="form-control" type="text" placeholder="" style="width:20%;" name=precioCosto>
        <label for="llevastk">Lleva Stock?</label>
        <input class="" type="checkbox" placeholder="" name=llevastk>
         <br>
         <label for="stkmin">Precio de Costo</label>
        <input class="form-control" type="text" placeholder="" style="width:20%;" name=precioCosto>
        <label for="stkmin">Stock Minimo</label>
        <input class="form-control" type="text" placeholder="" style="width:20%;" name=stkmin>
        <label for="stkmax">Stock Maximo</label>
        <input class="form-control" type="text" placeholder="" style="width:20%;" name=stkmax>
        <label for="stkmax">Unidad de Medida</label>
        <input class="form-control" type="text" placeholder="" style="width:20%;" name=unidadMedida>
        <label for="tipo_prod">Tipo de Producto</label>
        <select class="form-control"  style="width:30%;" name=tipo_Prod>
          @foreach ($tipos_producto as $p)
            <option value={{$p->id}}>{{$p->nombre}}</option>
          @endforeach
        </select>

        <label for="stkmax">foto</label>
        <input class="form-control" type="file" placeholder="" style="width:20%;" name=foto>


      </div>
        <a href="#"  onclick="document.getElementById('producto_nuevo').submit();" class="btn btn-success btn-icon-split">
         <span class ="icon text-white-50">
                      <i class="fas fa-check-double"></i>
                    </span>
                    <span class="text">Crear Producto</span>
        </a>
     
    </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection


{{--
<div class="row">
    <div class="col-sm">

      <h3 id="sizing" style="margin-top: 50px;"><span class="bd-content-title">Crear Nuevo Deposito</span></h3>

    <form action="{{ url('/deposito_nuevo') }}"  method=POST>
      @csrf
      <div class="form-group">
         <label for="nombre">Nombre</label>
        <input class="form-control" type="text" placeholder="" style="width:50%;" name=nombre>
        <br>
        <label for="nombre">Direccion</label>
        <input class="form-control" type="text" placeholder="" name=direccion>
      </div>
      <input type="submit" class="btn btn-primary" value=Crear>
    </form>
    </div>
</div>
--}}