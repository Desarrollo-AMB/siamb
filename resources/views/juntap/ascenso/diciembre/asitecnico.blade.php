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

            #mensaje-cargando {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 50%;
                max-width: 400px;
                height: 10%;
                background-color: white;
                text-align: center;
                justify-content: center;
                align-items: center;
                font-size: 150%;
                color: black;
                z-index: 9999;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            }



            #aviso_datos {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 50%;
                max-width: 400px;
                height: 10%;

                text-align: center;
                justify-content: center;
                align-items: center;
                font-size: 150%;
                color: black;
                z-index: 9999;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            }

            #typing-indicator {
                display: inline-block;
                overflow: hidden;
                width: 0;
                border-right: .15em solid rgb(255, 255, 255);
                white-space: nowrap;
                letter-spacing: .15em;
                animation: typing 1s steps(24, end) infinite;
                line-height: 20px;
            }

            @keyframes typing {
                from {
                    width: 0
                }

                to {
                    width: 3.2em
                }
            }

            @media (max-width: 600px) {
                #mensaje-cargando {
                    width: 90%;
                    max-width: none;
                }
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
                            <h5 class="mb-0">Personal a Ascender por Categoria</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ route('juntap.ascenso.index') }}">Volver</a>
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
                                                    Oficiales Asimilado Técnico
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <form name="form_comando" id="form_comando" class="form-graduar">

                                                        @csrf
                                                        <div class="row align-items-center"
                                                            style="
                                                /* display: flex; */
                                                justify-content: space-around;
                                             ">
                                                            <div class="col-3 text-center">

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
                                                            <div class="col-3 text-center">

                                                                <div class="form-group">


                                                                    <h6 for="fecha">Fecha: </h6>

                                                                    <input type="date" class="form-control"
                                                                        id="fecha" name="fecha">


                                                                </div>
                                                            </div>
                                                            <div class="col-3 text-center" style="">

                                                                <div class="form-group">



                                                                    <br>
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm mb-0 "
                                                                        style="width: 55%;">Ejecutar</button>


                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="categoria" name="categoria"
                                                                value="6">
                                                            <input type="hidden" id="tabla" value="1">
                                                    </form>
                                                    <form name="form_reporte" id="form_reporte" class="form-reporte"
                                                        style="
                                        
                                            display: flex;
                                            justify-content: space-evenly;
                                        ">

                                                        <div class="col-3 text-center" id="res2">
                                                            <div class="form-group">
                                                                <form name="form_reporte" id="form_reporte"
                                                                    class="form-reporte">
                                                                    <br>
                                                                    <a name="reporte" id="reporte" type="button"
                                                                        class="btn btn-outline-primary btn-reporte"
                                                                        style="width: 50%;"
                                                                        href="{{ route('juntap.reportes.reporteascenso') }}">Reporte</a>



                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                                <form name="form_ascender" style="display:none;" id="form_ascender"
                                                    class="">

                                                    <div class="row align-items-center"
                                                        style="
                                            /* display: flex; */
                                            justify-content: space-evenly;
                                        ">
                                                        <div class="col-3 text-center">
                                                            <h6 for="fecha">Resuelto: </h6>

                                                            <input type="text" class="form-control" id="resuelto"
                                                            name="resuelto" >
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <br>
                                                            <button type="button"
                                                                class="btn btn-primary btn-sm btn-graduar"
                                                                style="width: 55%;">Ascender</button>
                                                        </div>


                                                    </div>
                                                    <table id="comando"
                                                        class="table table-sm table-bordered table-hover w-100 nowrap fixed-table"
                                                        style="display: none;">
                                                        <thead>
                                                            <tr>

                                                                <th></th>
                                                                <th>Orden M</th>
                                                                <th>Orden MT</th>
                                                                <th>Id</th>
                                                                <th>Codigo E</th>

                                                                <th>Grado</th>
                                                                <th>Cédula</th>
                                                                <th>Nombre</th>
                                                                <th>Apellido</th>

                                                             
                                                                <th>Grado Ascender</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>

                                                    <table id="comando1"
                                                        class="table table-sm table-bordered table-hover w-100 nowrap fixed-table"
                                                        style="display: none;">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Orden M</th>
                                                                <th>Orden MT</th>
                                                                <th>Id</th>
                                                                <th>Codigo E</th>

                                                                <th>Grado</th>
                                                                <th>Cédula</th>
                                                                <th>Nombre</th>
                                                                <th>Apellido</th>
                                                                <th>Demérito</th>
                                                           
                                                                <th>Grado Ascender</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>


                                                </form>
                                                <div id="mensaje-cargando" name="mensaje-cargando">
                                                    <div>Cargando...</div>
                                                    <span id="typing-indicator">
                                                        <b
                                                            style="font-size: 45px;
                                                          font-weight: 900;
                                                          border-radius: 50%;
                                                          font-family:system-ui;
                                                          color:#0e92f1;
                                                          line-height:0;">
                                                            ...................................
                                                        </b>
                                                    </span>
                                                </div>
                                                <div id="mensaje" name="mensaje" class="alert alert-success"
                                                    style="display:none; text-align: center;font-weight: bold;color: #000;">

                                                </div>
                                                <div id="error" name="error" class="alert alert-danger"
                                                    style="display:none; text-align: center;font-weight: bold;color: #000;">

                                                </div>
                                                <div class="alert alert-warning" id="aviso" name="aviso"
                                                    style="display:none; text-align: center;font-weight: bold;color: #000;">

                                                </div>

                                                <div class="alert alert-warning" id="aviso_datos"
                                                    name="aviso_datos"style="display:none;">
                                                    Completar todos los campos
                                                </div>
                                                <div class="alert alert-warning" id="aviso_ascender"
                                                    name="aviso_ascender"
                                                    style="display:none; text-align: center;font-weight: bold;color: #000;">
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
        function avisoDatos() {


            $('#aviso_datos').fadeOut(500, function() {
                $('#aviso_datos').fadeIn(500);
            });
            setTimeout(function() {
                $('#aviso_datos').hide();
            }, 3000);
        }



        $('#form_comando').submit(function(event) {
            event.preventDefault();

            var select_comando1 = $('select[name="select_comando1"]').val();
            var categoria = $('input[name="categoria"]').val();
            var fecha = $('input[name="fecha"]').val();

            if (select_comando1 === "" || fecha === "") {

                $('#aviso_datos').show();

                setTimeout(avisoDatos, 1000);

            } else {

                var num0 = 0; // Iniciar el contador en 0
                var num1 = 0;
                var num2 = 0;
                var num3 = 0;
                $.ajax({
                    type: 'GET',
                    url: '{{ route('api.juntap.ascenso.diciembre.asitecnico') }}',
                    data: {
                        select_comando1: select_comando1,
                        categoria: categoria,
                        fecha: fecha
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success == false) {
                            $('#error').hide();
                            $('#mensaje').hide();
                            $('#form_ascender').hide();
                            $('#comando').hide();
                            $('#comando1').hide();
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

                            var table = $('#comando').DataTable();
                            table.destroy();
                            var table = $('#comando1').DataTable();
                            table.destroy();



                            if (select_comando1 === '015' || select_comando1 === '020' ||
                                select_comando1 === '030') {

                                $('#comando').show();
                                $('#comando1').hide();
                                var table = $('#comando').DataTable();
                                table.destroy();
                                var table = $('#comando1').DataTable();
                                table.destroy();
                                var table = $('#comando').DataTable({


                                    "select": {
                                        "style": 'multi'
                                    },
                                    "processing": true,

                                    "responsive": true,

                                    "data": data,
                                    "columns": [

                                        {
                                            "data": null,
                                            "render": function(data, type, row, meta) {
                                                num0++;

                                                // Add checkbox input field and remove hidden input field
                                                data =
                                                    '<input type="checkbox" name="gd' +
                                                    num0 + '" class="gd" >' +
                                                    '<input type="hidden" name="grado_ascender' +
                                                    num0 + '" value="' + row
                                                    .grado_ascender + '" >' +
                                                    '<input type="hidden" name="codigo_empleado' +
                                                    num0 + '" value="' + row
                                                    .codigo_empleado + '" >' +
                                                    '<input type="hidden" name="fecha' +
                                                    num0 + '" value="' + fecha + '" >';

                                                return data;
                                            }
                                        }, {
                                            "data": null,
                                            "render": function(data, type, row, meta) {
                                                num1++; // Aumentar el contador en 1 para cada fila
                                                return '<input type="Number" class="form-control" name="OM' +
                                                    num1 +
                                                    '">';
                                            }
                                        },
                                        {
                                            "data": null,
                                            "render": function(data, type, row, meta) {
                                                num2++; // Aumentar el contador en 1 para cada fila
                                                return '<input type="Number" class="form-control" name="OMT' +
                                                    num2 +
                                                    '">';
                                            }
                                        }, {
                                            "data": null,
                                            "render": function(data, type, row, meta) {
                                                num3++;

                                                // Add checkbox input field and remove hidden input field
                                                data = num3;

                                                return data;
                                            }
                                        }, {
                                            "data": "codigo_empleado"
                                        },
                                        {
                                            "data": "grado_militar"
                                        },

                                        {
                                            "data": "cedula"
                                        },
                                        {
                                            "data": "nombre1"
                                        },
                                        {
                                            "data": "apellido1"
                                        },


                                        // Agregar la numeración para cada línea del input "OM"


                                        {
                                            "data": "grado_ascender"
                                        }
                                    ],
                                    "language": {
                                        "processing": "Procesando, por favor espere...",
                                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                                    }
                                });

                            } else {

                                var table = $('#comando').DataTable();
                                table.destroy();
                                var table = $('#comando1').DataTable();
                                table.destroy();

                                $('#comando1').show();
                                $('#comando').hide();

                                var table = $('#comando1').DataTable({


                                    "select": {
                                        "style": 'multi'
                                    },
                                    "processing": true,

                                    "responsive": true,

                                    "data": data,
                                    "columns": [

                                        {
                                            "data": null,
                                            "render": function(data, type, row, meta) {
                                                num0++;

                                                // Add checkbox input field and remove hidden input field
                                                data =
                                                    '<input type="checkbox" name="gd' +
                                                    num0 + '" class="gd" >' +
                                                    '<input type="hidden" name="grado_ascender' +
                                                    num0 + '" value="' + row
                                                    .grado_ascender + '" >' +
                                                    '<input type="hidden" name="codigo_empleado' +
                                                    num0 + '" value="' + row
                                                    .codigo_empleado + '" >' +
                                                    '<input type="hidden" name="fecha' +
                                                    num0 + '" value="' + fecha + '" >';

                                                return data;
                                            }
                                        }, {
                                            "data": null,
                                            "render": function(data, type, row, meta) {
                                                num1++; // Aumentar el contador en 1 para cada fila
                                                return '<input type="Number" class="form-control" name="OM' +
                                                    num1 +
                                                    '" min="0">';
                                            }
                                        },
                                        {
                                            "data": null,
                                            "render": function(data, type, row, meta) {
                                                num2++; // Aumentar el contador en 1 para cada fila
                                                return '<input type="Number" class="form-control" name="OMT' +
                                                    num2 +
                                                    '" min="0">';
                                            }
                                        }, {
                                            "data": null,
                                            "render": function(data, type, row, meta) {
                                                num3++;

                                                // Add checkbox input field and remove hidden input field
                                                data = num3;

                                                return data;
                                            }
                                        }, {
                                            "data": "codigo_empleado"
                                        },
                                        {
                                            "data": "grado_militar"
                                        },

                                        {
                                            "data": "cedula"
                                        },
                                        {
                                            "data": "nombre1"
                                        },
                                        {
                                            "data": "apellido1"
                                        },

                                        {
                                            "data": "demerito",
                                            "render": function(data, type, row) {
                                                if (data != null) {
                                                    return data.toFixed(2);
                                                } else {
                                                    return '';
                                                }
                                            }
                                        },
                                        // Agregar la numeración para cada línea del input "OM"


                                        {
                                            "data": "grado_ascender"
                                        }
                                    ],
                                    "language": {
                                        "processing": "Procesando, por favor espere...",
                                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                                    }
                                });

                            }
                        }

                    },
                    error: function(xhr, status, error) {
                        alert('Error en la solicitud Ajax. Por favor, inténtalo de nuevo más tarde.');
                        console.log(xhr.responseText);
                        console.log('Error en la solicitud Ajax:');
                        console.log('Estado:', status);
                        console.log('Error:', error);
                        console.log('Respuesta:', xhr.responseText);
                    },
                    beforeSend: function() {
                        // Agregar código para mostrar el mensaje "cargando" aquí
                        $('#mensaje-cargando').show();
                    },
                    complete: function() {
                        // Agregar código para ocultar el mensaje "cargando" aquí
                        $('#mensaje-cargando').hide();
                    },

                });


            }


        });


        $(document).on('click', '.btn-graduar', function(event) {
            event.preventDefault();
            var select_comando1 = $('select[name="select_comando1"]').val();

            var input = 0;
            var on1 = 0;
            var on2 = 0;
            var resuelto = $('input[name="resuelto"]').val();
            var table01 = $('#comando').DataTable();
            var table02 = $('#comando1').DataTable();

            var data01 = table01.$('input,input,input,input').serializeArray();
            var data02 = table02.$('input,input,input,input').serializeArray();
            console.log(data01 + "data01");
            console.log(data02 + "data02");

            if (data02.length === 0) {

                for (var i = 0; i < data01.length; i++) {
                    if (data01[i].value === 'on') {
                        on1++;
                        for (var j = i + 1; j <= i + 5; j++) {

                            console.log(data01[j].value + "  data01[j].value");
                            console.log(data01[j].name + "  data01[j].name");

                            if (data01[j].value === '') {


                                input++;





                            }
                        }
                    }
                }
            } else {
                for (var i = 0; i < data02.length; i++) {
                    if (data02[i].value === 'on') {
                        on2++;
                        for (var j = i + 1; j <= i + 5; j++) {
                            // console.log(data02[j].value+"  data02[j].value");

                            console.log(data02[j].value + "  data02[j].value");
                            console.log(data02[j].name + "  data02[j].name");
                            if (data02[j].value === '') {

                                input++;

                            }



                        }
                    }
                }
            }


            // console.log(data01 + 'data01');
            console.log(resuelto + '--');
            //  console.log(data02+'++++++');
            console.log(input + '-++-');
            console.log(on1 + '+--+');

            // console.log(data02 + 'data02');
            if (data01.length === 0) {



                $('#comando_wrapper').hide();



                if (resuelto === '' || input >= 1 || on2 === 0) {


                    $('#comando_wrapper').hide();



                    $('#aviso_datos').show();

                    setTimeout(avisoDatos, 1000);


                } else {
                    $('#comando_wrapper').hide();

                    var table = $('#comando1').DataTable();

                    var data = table.$('input,input,input,input').serializeArray();


                    // var data = table.$('input,input,input').serialize();
                    //var data = table.$('input[type="checkbox"]').filter(':checked').serialize();

                    // var data= table.$('input[type="checkbox"]:checked')

                    //var data = table.$('input').filter(function() {
                    // return this.value != '';
                    //}).serialize();
                    //var data = table.$('input,input,input,input').serializeArray();
                    var new_data = [];
                    // var data = [];
                    // loop through the data array and replace null values with "x"
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].value === '') {
                            data[i].value = 'x';
                        }


                    }
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].value === 'on') {
                            for (var j = 0; j <= 5; j++) {
                                if (data[i + j]) {
                                    new_data.push({
                                        'name': data[i + j].name,
                                        'value': data[i + j].value
                                    });
                                }
                            }
                        }
                    }


                    new_data.push({
                        'name': 'resuelto',
                        'value': resuelto
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('api.juntap.ascenso.diciembre.ascender') }}",

                        data: new_data,

                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            // Aquí puedes agregar código para actualizar la tabla o mostrar un mensaje de éxito
                            if (response.success) {
                                $('#form_ascender').hide();
                                $('#comando').hide();
                                $('#comando_filter').hide();
                                $('#comando_paginate').hide();
                                $('#comando_info').hide();
                                $('#comando1').hide();
                                $('#comando1_filter').hide();
                                $('#comando1_paginate').hide();
                                $('#comando1_info').hide();
                                var mensajeDiv = document.getElementById("mensaje");
                                // Mostrar mensaje de éxito
                                mensajeDiv.style.display = "block";

                                $('#mensaje').html(response.message);

                                setTimeout(function() {
                                    mensajeDiv.style.display = "none";
                                    location.reload();
                                }, 2000);
                                // Ocultar mensaje de éxito después de 5 segundos
                            } else {
                                $('#form_ascender').hide();
                                $('#comando').hide();
                                $('#comando_filter').hide();
                                $('#comando_paginate').hide();
                                $('#comando_info').hide();
                                $('#comando1').hide();
                                $('#comando1_filter').hide();
                                $('#comando1_paginate').hide();
                                $('#comando1_info').hide();
                                var errorDiv = document.getElementById("error");
                                errorDiv.style.display = "block";
                                $('#error').html(response.message);

                                setTimeout(function() {
                                    mensajeDiv.style.display = "none";
                                    location.reload();
                                }, 2000);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert(
                                'Error en la solicitud Ajax. Por favor, inténtalo de nuevo más tarde.'
                            );
                            console.log('Error en la solicitud Ajax:');
                            console.log('Estado:', status);
                            console.log('Error:', error);
                            console.log('Respuesta:', xhr.responseText);
                        }
                    });





                }




            } else {

                $('#comando1_wrapper').hide();

                if (resuelto === '' || input >= 1 || on1 === 0) {


                    $('#comando1_wrapper').hide();



                    $('#aviso_datos').show();

                    setTimeout(avisoDatos, 1000);


                } else {
                    $('#comando1_wrapper').hide();

                    var table = $('#comando').DataTable();

                    var data = table.$('input,input,input,input').serializeArray();

                    // var data = table.$('input,input,input').serialize();
                    //var data = table.$('input[type="checkbox"]').filter(':checked').serialize();

                    // var data= table.$('input[type="checkbox"]:checked')

                    //var data = table.$('input').filter(function() {
                    // return this.value != '';
                    //}).serialize();

                    var new_data = [];
                    // var data = [];
                    // loop through the data array and replace null values with "x"
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].value === '') {
                            data[i].value = 'x';
                        }


                    }
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].value === 'on') {
                            for (var j = 0; j <= 5; j++) {
                                if (data[i + j]) {

                                    new_data.push({
                                        'name': data[i + j].name,
                                        'value': data[i + j].value
                                    });
                                }
                            }
                        }
                    }


                    new_data.push({
                        'name': 'resuelto',
                        'value': resuelto
                    });

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('api.juntap.ascenso.diciembre.ascender') }}",

                        data: new_data,

                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            // Aquí puedes agregar código para actualizar la tabla o mostrar un mensaje de éxito
                            if (response.success) {
                                $('#form_ascender').hide();
                                $('#comando').hide();
                                $('#comando_filter').hide();
                                $('#comando_paginate').hide();
                                $('#comando_info').hide();
                                $('#comando1').hide();
                                $('#comando1_filter').hide();
                                $('#comando1_paginate').hide();
                                $('#comando1_info').hide();
                                var mensajeDiv = document.getElementById("mensaje");
                                // Mostrar mensaje de éxito
                                mensajeDiv.style.display = "block";

                                $('#mensaje').html(response.message);

                                setTimeout(function() {
                                    mensajeDiv.style.display = "none";
                                    location.reload();
                                }, 2000);
                            } else {
                                $('#form_ascender').hide();
                                $('#comando').hide();
                                $('#comando_filter').hide();
                                $('#comando_paginate').hide();
                                $('#comando_info').hide();
                                $('#comando1').hide();
                                $('#comando1_filter').hide();
                                $('#comando1_paginate').hide();
                                $('#comando1_info').hide();
                                var errorDiv = document.getElementById("error");
                                errorDiv.style.display = "block";
                                $('#error').html(response.message);

                                setTimeout(function() {
                                    mensajeDiv.style.display = "none";
                                    location.reload();
                                }, 2000);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert(
                                'Error en la solicitud Ajax. Por favor, inténtalo de nuevo más tarde.'
                            );
                            console.log('Error en la solicitud Ajax:');
                            console.log('Estado:', status);
                            console.log('Error:', error);
                            console.log('Respuesta:', xhr.responseText);
                        }
                    });




                }

            }


            // Agregar el valor del input a la matriz new_data

            //data = new_data;
            // console.log(new_data);


        });




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
