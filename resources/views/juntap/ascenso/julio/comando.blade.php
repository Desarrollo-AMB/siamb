@extends('layouts.user_type.auth')
@section('title', 'Personal Militar No Profesional')
@section('content')
    @push('plugins-css')
        <link href="{{ asset('vendor/datatables/dataTables.checkboxes.css') }}" rel="stylesheet">
        <style>
            label.error {
                color: red;
                font-size: 1rem;
                display: block;
                margin-top: 5px;
            }

            input.error {
                border: 1px dashed red;
                font-weight: 300;
                color: red;
            }

            .om {
                max-width: 90px;

                padding: 0.60rem 0.90rem !important;

            }

            .omt {
                max-width: 90px;

                padding: 0.60rem 0.80rem !important;

            }
        </style>
    @endpush
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
                            <h5 class="mb-0">Personal a Graduarse por Categoria</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ route('juntap.ascenso.categoria') }}">Volver</a>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                <div class="card-body px-2 pt-2 pb-2">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <div class="card card-body border card-plain border-radius-lg bg-gray-100">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button " type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapseOne" aria-expanded="true"
                                                    aria-controls="flush-collapseOne">
                                                    Oficiales de Comando
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <form name="form_comando" id="form_comando" class="form-graduar">

                                                        @csrf
                                                        <div class="row align-items-center">
                                                            <div class="col-3">

                                                                <div class="form-group">
                                                                    <h6 for="Grado">Grado: <small></small></h6>
                                                                    <select class="form-select" name="select_comando1"
                                                                        id="select_comando1"aria-label="Default select example">
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
                                                            <div class="col-3">

                                                                <div class="form-group">


                                                                    <input type="hidden" id="categoria" name="categoria"
                                                                        value="4">
                                                                    <input type="hidden" id="tabla" value="1">

                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>


                                                                </div>
                                                            </div>
                                                    </form>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <h6 for="fecha_resuelto">Reporte Ascenso: <small></small></h6>
                                                            <button name="reporte" id="reporte" type="button"
                                                                class="btn btn-outline-primary">Reporte</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form name="form_ascender" style="display:none;" id="form_ascender"
                                                    class="" action="route('api.juntap.ascenso.julio.ascender')"
                                                    method="POST">
                                                    <div class="col-3 text-center">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-graduar">Graduar</button>
                                                    </div>



                                                    <table id="comando" style="font-size:85%;"
                                                        class="table table-sm table-bordered table-hover w-100 nowrap fixed-table">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Codigo E</th>
                                                          
                                                                <th>Grado</th>
                                                                <th>Cédula</th>
                                                                <th>Nombre</th>
                                                                <th>Apellido</th>
                                                                <th>Demérito</th>
                                                                <th class="om">Orden M</th>
                                                                <th class="omt">Orden MT</th>
                                                                <th>Grado Ascender</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>


                                                </form>
                                                <div id="mensaje" name="mensaje" class="alert alert-success"
                                                    style="display:none;">

                                                </div>
                                                <div id="error" name="error" class="alert alert-danger"
                                                    style="display:none;">

                                                </div>
                                                <div class="alert alert-warning" id="aviso"
                                                    name="aviso"style="display:none;">

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
@push('plugins-js')
    <script src="{{ asset('vendor/datatables/dataTables.checkboxes.min.js') }}"></script>
@endpush
@section('scripts')
    @parent

    <script>
     
    

     $('#form_comando').submit(function(event) {
    event.preventDefault();

    var select_comando1 = $('select[name="select_comando1"]').val();
    var categoria = $('input[name="categoria"]').val();
    var num0 = 0; // Iniciar el contador en 0
    var num1 = 0;
    var num2 = 0;
  
    $.ajax({
      type: 'GET',
      url: '{{ route('api.juntap.ascenso.julio.comando') }}',
      data: {select_comando1: select_comando1, categoria: categoria},
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


      
        var table = $('#comando').DataTable({
         
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
          },
          "select": {
        "style": 'multi'
    },
          "data": data,
          "columns": [
            
            { 
              "data": null, 
              "render": function(data, type, row, meta) {
                num0++; // Aumentar el contador en 1 para cada fila
                return '<input type="checkbox" name="gd' + num0 + '" class="gd"  >'+'<input type="hidden" name="gradom' + num0 + '" class="gd" value="'+ row.grado_militar +'" >'+
                '<input type="hidden" name="codigom' + num0 + '" class="gd" value="'+ row.codigo_empleado +'" >';
              }
            },
            { "data": "codigo_empleado" },
            { "data": "grado_militar" },
           
            { "data": "cedula" },
            { "data": "nombre1" },
            { "data": "apellido1" },
            
            {
              "data": "demerito",
              "render": function ( data, type, row ) {
                if (data != null) {
                  return data.toFixed(2);
                } else {
                  return '';
                }
              }
            },
            // Agregar la numeración para cada línea del input "OM"
            { 
              "data": null, 
              "render": function(data, type, row, meta) {
                num1++; // Aumentar el contador en 1 para cada fila
                return '<input type="Number" name="OM' + num1 + '" class="om">';
              }
            },
            { 
              "data": null, 
              "render": function(data, type, row, meta) {
                num2++; // Aumentar el contador en 1 para cada fila
                return '<input type="Number" name="OMT' + num2 + '" class="omt">';
              }
            },
         
            { "data": "grado_ascender" }
          ]
        });


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



$(document).on('click', '.btn-graduar', function(event) {
    event.preventDefault();
    var table = $('#comando').DataTable();
    var data = table.$('input,input,input').serialize();
  
  



    console.log(data);
  
  $.ajax({
    type: 'POST',
    url: "{{ route('api.juntap.ascenso.julio.ascender') }}", 
   
    data: data,
      
        dataType: 'json',
    success: function(data) {
      // Handle success response
      console.log('Success:', data);
    },
    error: function(xhr, status, error) {
      // Handle error response
      console.log('Error:', xhr.responseText);
    }
  });
});


                /*
                  $(document).on('click', '.btn-graduar', function(event) {
                    event.preventDefault();
                    var num0 = 0; // Iniciar el contador en 0
                    var num1 = 0; // Iniciar el contador en 0
                    var num2 = 0; // Iniciar el contador en 0
                    var table = $('#comando').DataTable();
                    //var selectedRows = table.rows({ selected: true }).data();
                    var rows_selected = table.column(0).checkboxes.selected();
                    var checkboxValues = [];
                    var formData = new FormData();
                   
                    $.each(rows_selected, function(index, rowId){ // Iterar sobre las filas seleccionadas
                        var rowData = table.row('#'+rowId).data();
                    if (rowData) { 
                       formData.append('codigo_empleado[]', rowData.codigo_empleado);
                        formData.append('cedula[]', rowData.cedula);
                        formData.append('nombre[]', rowData.nombre1);
                        formData.append('apellido[]', rowData.apellido1);
                        formData.append('grado_militar[]', rowData.grado_militar);
                        formData.append('demerito[]', rowData.demerito);

                        formData.append('grado_ascender[]', rowData.grado_ascender);
                        num0++;
                        num1++;
                        num2++;
                       
                     var OM = $('input[name="OM' + num0 + '"]').val();
                        formData.append('OM[]', OM != '' ? OM : '0');
                        
                        var OMT = $('input[name="OMT' + num1 + '"]').val();
                        formData.append('OMT[]', OMT != '' ? OMT : '0');

                        }
                    });
                    console.log(rows_selected);
                    $.ajax({
                        url: "{{ route('api.juntap.ascenso.julio.ascender') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response);
                            // Aquí puedes agregar código para actualizar la tabla o mostrar un mensaje de éxito
                            if (response.success) {
                        $('#form_ascender').hide();
                        $('#comando').hide();
                        $('#comando_filter').hide();
                        $('#comando_paginate').hide();
                        $('#comando_info').hide();
                        var mensajeDiv = document.getElementById("mensaje");
                // Mostrar mensaje de éxito
                mensajeDiv.style.display = "block";

                        $('#mensaje').html(response.message);
                    } else {
                        $('#form_ascender').hide();
                        $('#comando').hide();
                        $('#comando_filter').hide();
                        $('#comando_paginate').hide();
                        $('#comando_info').hide();
                        var errorDiv = document.getElementById("error");
                        errorDiv.style.display = "block";
                        $('#error').html(response.message);
                    }
                        },
                        error: function(xhr, status, error) {
                            alert('Error en la solicitud Ajax. Por favor, inténtalo de nuevo más tarde.');
                            console.log('Error en la solicitud Ajax:');
                            console.log('Estado:', status);
                            console.log('Error:', error);
                            console.log('Respuesta:', xhr.responseText);
                        }
                    });
                });
                     


                */











                //*/


                /*
                  
                      $(document).on('click', '.btn-graduar', function(event) {
                    event.preventDefault();
                    var num0 = 0; // Iniciar el contador en 0
                    var num1 = 0; // Iniciar el contador en 0
                    var num2 = 0; // Iniciar el contador en 0
                    var table = $('#comando').DataTable();
                    var selectedRows = table.rows({ selected: true }).data();
                  
                    var formData = new FormData();
                    selectedRows.each(function(rowData) {
                        formData.append('codigo_empleado[]', rowData.codigo_empleado);
                        formData.append('cedula[]', rowData.cedula);
                        formData.append('nombre[]', rowData.nombre1);
                        formData.append('apellido[]', rowData.apellido1);
                        formData.append('grado_militar[]', rowData.grado_militar);
                        formData.append('demerito[]', rowData.demerito);
                      
                        formData.append('grado_ascender[]', rowData.grado_ascender);
                       
                       // formData.append('OM[]', $('input[name="OM[]"]', table.row(rowData).node())[0].value);
                    //formData.append('OMT[]', $('input[name="OMT[]"]', table.row(rowData).node())[0].value);
                   // formData.append('OMT[]', $('input[name="OMT[]"]', table.row(rowData).node()).val());
                  // formData.append('OM[]', $('input[name="OM' + num0 + '"]', table.row(rowData).node()).val());
                  //formData.append('gb[]', $('input[name="gd[]"]', table.row(rowData).node()).is(":checked") ? '1' : '0');
                  num0++;
                  num1++;
                  num2++;
                        var OM = $('input[name="OM' + num0 + '"]').val();
                        if (OM != undefined && OM != '') {
                            formData.append('OM[]', OM);
                        }
                        var OMT = $('input[name="OMT' + num1 + '"]').val();
                        if (OMT != undefined && OMT != '') {
                            formData.append('OMT[]', OMT);
                        }
                        var gb = $('input[name="OMT' + num2 + '"]').val().is(":checked") ? '1' : '0');;
                        if (gb != undefined && gb != '') {
                            formData.append('gb[]', gb);
                        }


                    });
                
                    $.ajax({
                        url: "{{ route('api.juntap.ascenso.julio.ascender') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response);
                            // Aquí puedes agregar código para actualizar la tabla o mostrar un mensaje de éxito
                        },
                        error: function(xhr, status, error) {
                            console.log('Error en la solicitud Ajax:');
                            console.log('Estado:', status);
                            console.log('Error:', error);
                            console.log('Respuesta:', xhr.responseText);
                        }
                    });
                });
                
                
                */
    </script>





@endsection
