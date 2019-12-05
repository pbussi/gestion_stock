@extends('layout')
@section('content')
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Ventas de un Lote específico de Producción</h1>
          <p class="mb-4"></p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"></h6>
            </div>
            <div class="card-body">
 <form class="user" action="{{ url('/ventasxlote_seleccion') }}" id=ventasxlote_seleccion method=POST>
      @csrf
         <div class="form-group row"> 
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label for="lote_numero">Producto</label>
                <select class="form-control"  name=producto id=producto>
                  <option value=0 >Elija producto</option>
                    @foreach ($productos as $p)
                      <option value={{$p->id}}>{{$p->nombre}}</option>
                    @endforeach
                </select>
        </div>
        <div class="col-sm-3">
          <label for="lote_numero" >Lote</label>
            <select class="form-control"  name=lote id=lote></select>
        </div>


          </div>

  

   
              <a href="#"  onclick="document.getElementById('ventasxlote_seleccion').submit();" class="btn btn-success btn-icon-split">
               <span class ="icon text-white-50">
                          <i class="fas fa-check-double"></i>
               </span>
               <span class="text">Consultar</span>
              </a>
            </div>            
            
        </div>     
    </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->


<script>
 $(document).ready(function() { 
   
    $( "#producto" ).change(function() {
        console.log(this);
        let dropdown = $('#lote');
        dropdown.empty();
        dropdown.append('<option selected="true" disabled>Seleccione lote a evaluar</option>');
        dropdown.prop('selectedIndex', 0);
        const url = '{{ url('/lotes_producto') }}/'+$('#producto').val();

        $.getJSON(url, function (data) {
              $.each(data, function (key, entry) {
                  dropdown.append($('<option></option>').attr('value', entry.id_lote_produccion).text(entry.comprobante));
              })
        });
      }); 
  });   
</script>
@endsection
