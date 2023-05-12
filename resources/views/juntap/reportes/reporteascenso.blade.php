@extends('layouts.user_type.auth')
@section('title', 'Personal Civil')
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger mx-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success mx-4" role="alert">
            <span class="text-white">{{ $message }}</span>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 mb-2">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Reporte de Ascenso</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ route('juntap.reportes.index') }}">Volver</a>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                <div class="row justify-content-end">

                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">


                            <form method="POST" name="form_reporte"  id="form_reporte" action="{{ route('juntap.reportes.ascrreporte') }}" >

                                @csrf
                                <div class="row align-items-center"
                                    style="
                            display: flex;
                            justify-content: center;
                        ">

                                    <div class="col-3">

                                        <div class="form-group">
                                            <h6 for="Grado">Tipo de Archivo: <small></small></h6>
                                            <select class="form-select" name="select_tipo"
                                                id="select_tipo" aria-label="Default select example">
                                                <option selected>Seleccionar...</option>
                                                <option value="excel">Excel</option>
                                                <option value="pdf">PDF</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <h6 for="Grado">Periodo de Ascenso: <small></small></h6>
                                            <select class="form-select" name="periodo"
                                                id="periodo" aria-label="Default select example">
                                                <option selected>Seleccionar...</option>
                                                <option value="julio">Julio</option>
                                                <option value="diciembre">Diciembre</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <h6 for="Grado">Categoria: <small></small></h6>
                                            <select class="form-select" name="select_categoria"
                                                id="select_categoria"aria-label="Default select example">
                                                <option selected>Seleccionar...</option>
                                                <option value="4">Oficiales de Comando</option>
                                                <option value="5">Oficiales Técnicos</option>
                                                <option value="7">Oficiales de Tropa</option>
                                                <option value="6">Oficiales Asimilado Técnico</option>
                                                <option value="2">Oficiales Asimilados</option>
                                                <option value="8">Tropa Profesional</option>

                                            </select>



                                        </div>
                                    </div>

                                    <div class="col-3" name="select_OF" id="select_OF" style="display:none;">

                                        <div class="form-group">
                                            <h6 for="Grado">Grado: <small></small></h6>
                                            <select class="form-select" name="select_gradoOF"
                                                id="select_gradoOF"aria-label="Default select example">
                                                <option selected>Seleccionar...</option>
                                                <option value="15">MY</option>
                                                <option value="020">GD</option>
                                                <option value="030">GB</option>
                                                <option value="040">CNEL</option>
                                                <option value="050">TCNEL</option>
                                                <option value="060">MAY</option>
                                                <option value="070">CAP</option>
                                                <option value="080">PTTE</option>
                                                <option value="090">TTE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3" name="select_TP" id="select_TP" style="display:none;">

                                        <div class="form-group">
                                            <h6 for="Grado">Grado: <small></small></h6>
                                            <select class="form-select" name="select_gradoTP"
                                                id="select_gradoTP"aria-label="Default select example">
                                                <option selected>Seleccionar...</option>
                                                <option value="420">SA</option>
                                                <option value="430">SM1</option>
                                                <option value="440">SM2</option>
                                                <option value="450">SM3</option>
                                                <option value="460">S1</option>
                                                <option value="470">S2</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>
                            </form>
                         
                            @if (isset($mensaje))
    <div id="mensaje" name="mensaje" class="alert alert-warning" style="margin: 10px 0 0 0; ">
        {{ $mensaje }}
    </div>
   

@endif
                            <div id="error" name="error" class="alert alert-danger" style="display:none;  margin: 10px 0 0 0;">

                            </div>
                            <div class="alert alert-warning" id="aviso" name="aviso"style="display:none;  margin: 10px 0 0 0;" >
                              
                             </div>
                        </div>









                    </div>
                </div>
            </div>
        </div>
        <hr class="horizontal dark my-0">


    </div>
    </div>
    </div>
    {{-- Modal para suspender --}}

@endsection

@section('scripts')
    @parent
    <script>
var mensaje = document.getElementById("mensaje");
    
    // Mostrar el mensaje
   // mensaje.style.display = "block";
    
    // Ocultar el mensaje después de 3 segundos (3000 milisegundos)
    setTimeout(function(){
        mensaje.style.display = "none";
    }, 3000);

/*
@if (session('mensaje'))
        alert("{{ session('mensaje') }}");

       
    @endif



$('#form_reporte').submit(function(event) {
    event.preventDefault();

    var select_tipo = $('select[name="select_tipo"]').val();
    var select_categoria = $('input[name="select_categoria"]').val();
    var periodo = $('input[name="periodo"]').val();
    var select_gradoOF = $('input[name="select_gradoOF"]').val();
    var select_gradoTP = $('input[name="select_gradoTP"]').val();
    var num0 = 0; // Iniciar el contador en 0
    var num1 = 0;
    var num2 = 0;
    
    $.ajax({
      type: 'POST',
      url: '{{ route('juntap.reportes.ascrreporte') }}',
      data: {
        select_tipo: select_tipo,
    select_categoria: select_categoria,
    periodo: periodo,
    select_gradoOF: select_gradoOF,
    select_gradoTP: select_gradoTP,somefield: "Some field value", _token: '{{csrf_token()}}'
},
 dataType: 'json',
      success: function(data) {
        if (data.success==false) {
            $('#error').hide();
        $('#mensaje').hide();

            $('#form_ascender').hide();
        $('#comando').hide();
       
        var mensajeDiv = document.getElementById("aviso");
// Mostrar mensaje de éxito
mensajeDiv.style.display = "block";

        $('#aviso').html(data.message);
    } else {
        $('#error').hide();
        $('#mensaje').hide();
        var mensajeDiv = document.getElementById("aviso");

mensajeDiv.style.display = "none";
        var formasc = document.getElementById("form_ascender");
formasc.style.display = "block";
var formasc = document.getElementById("comando");
formasc.style.display = "block";


var a = document.createElement('a');
            var url = window.URL.createObjectURL(data);
            a.href = url;
            a.download = 'ReportePersonalMilitarTentativoAscenso.xlsx';
            a.click();
            window.URL.revokeObjectURL(url);



    }

      },
      error: function(xhr, status, error) {
        alert('Error en la solicitud Ajax. Por favor, inténtalo de nuevo más tarde.');
        console.log(xhr.responseText);
        console.log('Error en la solicitud Ajax:');
        console.log('Estado:', status);
        console.log('Error:', error);
        console.log('Respuesta:', xhr.responseText);
      }
    });
  });

 



var url = data.url;
        window.location = url;


//window.location.href = '{{ route('juntap.reportes.ascrreporte') }}?select_tipo=' + select_tipo + '&select_categoria=' + select_categoria + '&periodo=' + periodo + '&select_gradoOF=' + select_gradoOF + '&select_gradoTP=' + select_gradoTP;
       
var url = data.url;
        var link = document.createElement('a');
        link.href = url;
        link.download = 'ReportePersonalMilitarTentativoAscenso.xlsx';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
*/


        const categoriaSelect = document.getElementById("select_categoria");
        const ofSelect = document.getElementById("select_OF");
        const tpSelect = document.getElementById("select_TP");
        const selectPeriodo = document.getElementById("periodo");
        const selectCategoria = document.getElementById("select_categoria");

        selectPeriodo.onchange = function() {
            if (selectPeriodo.value === "diciembre") {
                selectCategoria.innerHTML = `
                                          <option selected>Seleccionar...</option>
                                          
                                          <option value="7">Oficiales de Tropa</option>
                                                <option value="6">Oficiales Asimilado Técnico</option>
                                                <option value="2">Oficiales Asimilados</option>
                                        `;
            } else {
                selectCategoria.innerHTML = `
                                          <option selected>Seleccionar...</option>
                                          <option value="4">Oficiales de Comando</option>
                                                <option value="5">Oficiales Técnicos</option>
                                                <option value="7">Oficiales de Tropa</option>
                                                <option value="6">Oficiales Asimilado Técnico</option>
                                                <option value="2">Oficiales Asimilados</option>
                                                <option value="8">Tropa Profesional</option>
                                        `;
            }
        }


        categoriaSelect.addEventListener("change", function() {
            if (categoriaSelect.value === "4" || categoriaSelect.value === "5" || categoriaSelect
                .value === "7" || categoriaSelect.value === "6" || categoriaSelect.value ===
                "2") {
                ofSelect.style.display = "block";
                tpSelect.style.display = "none";
            } else if (categoriaSelect.value === "8") {
                ofSelect.style.display = "none";
                tpSelect.style.display = "block";
            } else {
                ofSelect.style.display = "none";
                tpSelect.style.display = "none";
            }
        });
    </script>
@endsection
