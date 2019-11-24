
@extends('layout')

@section('content')
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
  <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Lote Producción  Nro. <B> <?php echo "PROD".str_pad($lote->id,6,"0", STR_PAD_LEFT); ?></B> </h1>


    <p class="mb-4">Gestion de ingredientes de la produccion</p>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0  text-primary"> Fecha:  <?php echo date('d/m/Y', strtotime($lote->fecha)); ?>
           <a href="{{ url('/lotes_produccion_pdf',$lote->id) }}" class=" btn btn-warning btn-icon-split float-right" style="margin-left: 10px;">
              <span class="icon text-white-50">
                  <i class="fas fa-print"></i>
              </span>
              <span class="text">Imprimir</span>
            </a>
          </h6>
        </div>
      </div>
    <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="{{ url('/lotes_produccion_gestion',$lote->id) }}">Insumos utilizados</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/lotes_produccion_gestion_terminados',$lote->id) }}">Productos terminados</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/lotes_produccion_gestion_info',$lote->id) }}">Información del Lote</a>
  </li>
  
</ul>  
        <div class="card-body">
         <div class="table-responsive">
          <table class="table table-bordered small" id="xxdataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th scope="col">Ingrediente</th>
              <th scope="col">Marca</th>
              <th scope="col">Lote</th>
              <th scope="col">U.M.</th>
              <th scope="col">Cantidad</th>
              <th scope="col"></th>
              <th scope="col" style="width: 20%;">Asignar</th>
                <th scope="col"></th>
            </tr>
          </thead>
       <tbody>
        @foreach ($ingredientes as $i)
          <tr>
            <td>{{ $i->nombre }}</td>
            <td> {{ $i->marca }}</td>
            <td>{{ $i->numero}}</td>
            <td>{{ $i->unidad_medida}}</td>
            <td>{{ $i->cantidad}}</td>
            <td class="w-10"> 
              @if ($lote->estado==1)
              @if ($i->movimiento_id>0)
              <a href="{{ url('/lotes_produccion_gestion',$lote->id) }}?borrar={{ $i->movimiento_id}}" class="float-left">
              @else
              <a href="{{ url('/lotes_produccion_gestion',$lote->id) }}?borrar_mp={{ $i->lp_id}}" class="float-left">
              @endif   
              <span class="icon"><i class="fas fa-trash"></i></span></a>
              @endif
            </td>
               <td> 
                <div >
                
                <select name=terminado id="terminado_{{$i->lp_id}}" class="float-left"

                   @if ($lote->estado==0) disabled @endif>
                <option    value=0 >Asignar a</option>
               @foreach ($terminados as $p)
                <option value={{$p->pt_id}} 
                @if ($p->pt_id==$i->id_lote_prod_terminado)
                  selected
                @endif
                  ><?php echo ucwords(strtolower($p->nombre)); ?>
                </option>
              @endforeach
            </select>
           
              <td> 
                 @if ($lote->estado==1)
                    <a id="icon2_{{$i->lp_id}}" class="float-left"  onClick="window.location.href='{{ url('/lotes_produccion_gestion',$lote->id) }}?asignar_mp={{ $i->lp_id}}&p_l_p='+$('#terminado_{{$i->lp_id}} option:selected').attr('value') " class="float-left" style="float:right;"><span class="float-left icon"><i class="far fa-thumbs-up"></i></span></a>
                 @endif  
              </td>


          </div></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

    

@if ($lote->estado==1)
<form action="{{ url('/lotes_produccion_gestion',$lote->id) }}" id=nuevo_lote method=POST>
<div class="form-group row">
      @csrf
        <div class="col-sm-3 mb-3 mb-sm-0">
          <label for="lote_numero">Producto</label>
             <select class="form-control"  name=producto id=producto>
               <option value=0 >Elija producto</option>
               @foreach ($productos as $p)
                <option value={{$p->id}} stock={{$p->lleva_stock}}>{{$p->nombre}}-{{$p->marca}}</option>
              @endforeach
            </select>
        </div>
        <div class="col-sm-3">
          <label for="lote_numero" id=ldeposito>Deposito</label>
            <select class="form-control"  name=deposito id=deposito></select>
        </div>
        <div class="col-sm-3 mb-3 mb-sm-0">
          <label for="lote_numero" id=llote>Lote del ingrediente</label>
            <select class="form-control"  name=lote id=lote></select>
        </div>
        <div class="col-sm-1 mb-3 mb-sm-0">
          <label for="unidad_medida">Cantidad</label>   
          <input class="form-control" type="text" name=cantidad id=cantidad >
        </div>
        <div class="col-sm-1 mb-3 mb-sm-0">
          <label for="unidad_medida"></label>
            <a href="#"  onclick="
                  if (!(parseFloat($('#cantidad').val())>0)){
                    alert('Ingrese cantidad');
                    return;
                  }
                  if ($('#producto option:selected').attr('stock')=='0'){
                    document.getElementById('nuevo_lote').submit(); 
                  }

                  if (parseFloat($('#lote option:selected')[0].attributes.cantidad.value)>=parseFloat($('#cantidad').val()))             
                    document.getElementById('nuevo_lote').submit(); 
                  else alert('Stock insuficiente');" 

                  class="btn btn-success btn-icon-split" style="margin-top: 7px;">
            <span class ="icon text-white-50">
                <i class="fas fa-check-double"></i>
            </span>
            <span class="text">Agregar</span></a>
        </div>
  
  </div>
</form>      <!-- /.container-fluid -->

<script>
  $(document).ready(function() { 


      $( "#producto" ).change(function() {
        if ( $("#producto option:selected").attr('stock')=="0"){
            $('#deposito').hide();
            $('#lote').hide();
            $('#ldeposito').hide();
            $('#llote').hide();
            return;
        }
        $('#deposito').show();
        $('#lote').show();
        $('#ldeposito').show();
        $('#llote').show();
        console.log(this);
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

@endif

@endsection