
@extends('layout')

@section('content')
  <script src=http://localhost/proyecto/heladeria_rincon/public/vendor/jquery/jquery.min.js></script>
  <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Lotes de produccion</h1>
    <p class="mb-4">Gestion de ingredientes de la produccion</p>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">LOTE DE PRODUCCION Nro. {{ $lote->id }} / Fecha:  {{ $lote->fecha }} </h6>
        </div>
        <div class="card-body">
         <div class="table-responsive">
          <table class="table table-bordered small" id="xxdataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th scope="col">Ingrediente</th>
              <th scope="col">Marca</th>
              <th scope="col">Lote</th>
              <th scope="col">Unidad de Medida</th>
              <th scope="col">Cantidad</th>
            </tr>
          </thead>
       <tbody>
        @foreach ($ingredientes as $i)
          <tr>
            <td>{{ $i->nombre }}</td>
            <td> {{ $i->marca }}</td>
            <td>{{ $i->lotes_mp_id}}</td>
            <td>{{ $i->unidad_medida}}</td>
            <td>{{ $i->cantidad}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

    
</div>
<form action="{{ url('/lotes_produccion_gestion',$lote->id) }}" id=nuevo_lote method=POST>
<div class="form-group row">
   
      @csrf
        <div class="col-sm-3 mb-3 mb-sm-0">
          <label for="lote_numero">Producto</label>
             <select class="form-control"  name=producto id=producto>
               @foreach ($productos as $p)
                <option value={{$p->id}}>{{$p->nombre}}-{{$p->marca}}</option>
              @endforeach
            </select>
        </div>
        <div class="col-sm-3">
          <label for="lote_numero">Deposito</label>
            <select class="form-control"  name=deposito id=deposito></select>
        </div>
        <div class="col-sm-3 mb-3 mb-sm-0">
          <label for="lote_numero">Lote del ingrediente</label>
            <select class="form-control"  name=lote id=lote></select>
        </div>
        <div class="col-sm-1 mb-3 mb-sm-0">
          <label for="unidad_medida">Cantidad</label>   
          <input class="form-control" type="text" name=cantidad id=cantidad >
        </div>
        <div class="col-sm-1 mb-3 mb-sm-0">
          <label for="unidad_medida"></label>
            <a href="#"  onclick="
if (parseFloat($('#lote option:selected')[0].attributes.cantidad.value)>=parseFloat($('#cantidad').val()))             document.getElementById('nuevo_lote').submit(); else alert('Complete todos los datos');" class="btn btn-success btn-icon-split" style="margin-top: 7px;">
            <span class ="icon text-white-50">
                <i class="fas fa-check-double"></i>
            </span>
            <span class="text">Crear</span></a>
        </div>
  
  </div>
    </form>      <!-- /.container-fluid -->
<script>
  $(document).ready(function() { 


      $( "#producto" ).change(function() {
        let dropdown = $('#deposito');
        let dropdown2 = $('#lote');
        dropdown.empty();
        dropdown2.empty();
        dropdown.append('<option selected="true" disabled>Elija deposito</option>');
        dropdown.prop('selectedIndex', 0);
        const url = '{{ url('/producto_depositos_saldo') }}/'+this.value;
        $.getJSON(url, function (data) {
              $.each(data, function (key, entry) {
                  dropdown.append($('<option></option>').attr('value', entry.id_deposito).text(entry.nombre));
              })
        });
      });

      $( "#deposito" ).change(function() {
        let dropdown = $('#lote');
        dropdown.empty();
        dropdown.append('<option selected="true" disabled>Elija lote</option>');
        dropdown.prop('selectedIndex', 0);
        const url = '{{ url('/producto_lotes_saldo') }}/'+$('#producto').val()+'/'+this.value;
        $.getJSON(url, function (data) {
              $.each(data, function (key, entry) {
                  dropdown.append($('<option></option>').attr('value', entry.id_lote).attr('cantidad', entry.cantidad).text(entry.numero+' ('+entry.cantidad+')'));
              })
        });
      });


  });
</script>


@endsection