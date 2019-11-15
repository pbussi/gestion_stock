@extends('layout')
@section('content')
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Alta de Clientes</h1>
          <p class="mb-4"></p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Nuevo Cliente</h6>
            </div>
            <div class="card-body">

 <form class="user" action="{{ url('/cliente_nuevo') }}" id=cliente_nuevo method=POST>
      @csrf
        
         <div class="form-group row">
            <div class="col-sm-5 mb-3 mb-sm-0">
              <input class="form-control m-0 text-info font-weight-bold text-uppercase mb-4" type="text" placeholder="Razón Social" name=razon_social >
            </div>

            <div class="col-sm-3">
              <input class="form-control" type="text" placeholder="CUIT (sin guiones)" name=cuit id=cuit>
            </div>
           <div class="col-sm-4 mb-3 mb-sm-0">
              <select class="form-control"  name=situacion_iva>
                 @foreach ($situacion_iva as $s)
                 <option value={{$s->id}}>{{$s->situacion}}</option>
                   @endforeach
              </select>
            </div>
            
        </div>
         
         <div class="form-group row"> 
             <div class="col-sm-4 mb-3 mb-sm-0">
               <label for="stkmin">Dirección</label>
               <input class="form-control" type="text" placeholder="Dirección" name=direccion>
             </div>
             <div class="col-sm-3 mb-3 mb-sm-0">
                  <label for="stkmin">Localidad</label>
                  <input class="form-control" type="text" placeholder="" name=localidad>
              </div>
               <div class="col-sm-4 mb-3 mb-sm-0"> 
                <label for="stkmax">Provincia</label>
                <input class="form-control" type="text" placeholder=""  name=provincia>
              </div>
              
          </div>
          <div class="form-group row">   
              <div class="col-sm-4 mb-3 mb-sm-0"> 
                 <label for="stkmin">Mail</label>
                 <input class="form-control" type="mail" placeholder=""  name=mail>
              </div>
              <div class="col-sm-2 mb-3 mb-sm-0"> 
                 <label for="stkmin">Telefono</label>
                 <input class="form-control" type="text" placeholder=""  name=telefono>
              </div>
              <div class="col-sm-6 mb-3 mb-sm-0">
                 <label for="tipo_prod">Lista de Precios Asociada</label>
                 <select class="form-control"  style="width:70%;" name=lista>
                   @foreach ($lista_precios as $p)
                    <option value={{$p->id}}>{{$p->nombre}}</option>
                   @endforeach
                 </select>
              </div>
          </div>
          <div class="form-group row">     
                <div class="col-sm-4 mb-3 mb-sm-0"> 
                   <label for="stkmin">Observaciones</label>
                   <input class="form-control" type="textarea" placeholder=""  name=observaciones>
                </div> 
          </div>  
         
<div class="form-group row"> 
            <div class="col-sm-4 mb-3 mb-sm-0">
              <a href="#"  onclick="
              
              if (esCUITValida($('#cuit').val()))
                    {}
              else{  alert('Ingrese un CUIT valido');  return false;}
              document.getElementById('cliente_nuevo').submit();

              " class="btn btn-success btn-icon-split">
               <span class ="icon text-white-50">
                          <i class="fas fa-check-double"></i>
               </span>
               <span class="text">Crear Cliente</span>
              </a>
            </div>
          </div>     
    </form>







            </div>
          </div>

        </div>



<!-- 


    <div class="form-group row"> 
            <div class="col-sm-4 mb-3 mb-sm-0">
              <a href="#"  onclick="
              if (esCUITValida($('#cuit').val()))
                    {}
              else{  alert('Ingrese un CUIT valido');  return false;}

              document.getElementById('cliente_nuevo').submit();" class="btn btn-success btn-icon-split">
               <span class ="icon text-white-50">
                          <i class="fas fa-check-double"></i>
               </span>
               <span class="text">Crear Cliente</span>
              </a>
            </div>
          </div>     
    </form>

            </div>
          </div>

        </div>
->


        <!-- /.container-fluid -->
<script type="text/javascript">
    function esCUITValida(inputValor) {
    inputString = inputValor.toString()
    if (inputString.length == 11) {
        var Caracters_1_2 = inputString.charAt(0) + inputString.charAt(1)
        if (Caracters_1_2 == "20" || Caracters_1_2 == "23" || Caracters_1_2 == "24" || Caracters_1_2 == "27" || Caracters_1_2 == "30" || Caracters_1_2 == "33" || Caracters_1_2 == "34") {
            var Count = inputString.charAt(0) * 5 + inputString.charAt(1) * 4 + inputString.charAt(2) * 3 + inputString.charAt(3) * 2 + inputString.charAt(4) * 7 + inputString.charAt(5) * 6 + inputString.charAt(6) * 5 + inputString.charAt(7) * 4 + inputString.charAt(8) * 3 + inputString.charAt(9) * 2 + inputString.charAt(10) * 1
            Division = Count / 11;
            if (Division == Math.floor(Division)) {
                return true
            }
        }
    }
    return false
}
    </script>
@endsection