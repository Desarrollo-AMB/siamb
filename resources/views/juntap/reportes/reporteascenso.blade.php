@extends('layouts.user_type.auth')
@section('title', 'Personal Civil')
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


                            <form method="POST" name="form_reporte" id="form_reporte"
                                action="{{ route('juntap.reportes.ascrreporte') }}">

                                @csrf
                                <div class="row align-items-center"
                                    style="
                                        display: flex;
                                            justify-content: center;
                                        ">
                                    <div class="col-3 text-center">

                                        <div class="form-group">
                                            <h6 for="Grado">Tipo de Reporte: <small></small></h6>
                                            <select class="form-select" name="parte_todo" id="parte_todo"
                                                aria-label="Default select example">
                                                <option selected>Seleccionar...</option>
                                                <option value="todo">Todo</option>
                                                <option value="cat">Categoria</option>
                                                <option value="grado">Grado</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3 text-center">

                                        <div class="form-group">
                                            <h6 for="Grado">Tipo de Archivo: <small></small></h6>
                                            <select class="form-select" name="select_tipo" id="select_tipo"
                                                aria-label="Default select example">
                                                <option selected>Seleccionar...</option>
                                                <option value="excel">Excel</option>
                                                <option value="pdf" id="f">PDF</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row"
                                    style="
               
                           justify-content: space-around;
                         ">
                                    <div class="col-3 text-center">

                                        <div class="form-group">
                                            <h6 for="Grado">Periodo de Ascenso: <small></small></h6>
                                            <select class="form-select" name="periodo" id="periodo"
                                                aria-label="Default select example">
                                                <option selected>Seleccionar...</option>
                                                <option value="julio">Julio</option>
                                                <option value="diciembre">Diciembre</option>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-3 text-center">

                                        <div class="form-group">


                                            <h6 for="fecha">Fecha: </h6>

                                            <input type="date" class="form-control" id="fecha" name="fecha">


                                        </div>
                                    </div>
                                </div>
                                <div class="row"
                                    style="
               
                              justify-content: space-around;
                         ">
                                    <div class="col-3 text-center" name="select_cat" id="select_cat" style="display:none;">

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

                                    <div class="col-3 text-center" name="select_OF" id="select_OF" style="display:none;">

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
                                    <div class="col-3 text-center" name="select_TP" id="select_TP"
                                        style="display:none;">

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



                                </div>
                                <div class="row"
                                    style="
           
                                    justify-content: space-around;
                           ">

                                    <button type="submit" class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>
                                </div>
                            </form>

                            @if (isset($mensaje))
                                <div id="mensaje" name="mensaje" class="alert alert-warning"
                                    style="margin: 10px 0 0 0; ">
                                    {{ $mensaje }}
                                </div>
                            @endif

                            @if (isset($mensaje_error))
                                <div id="mensaje_error" name="mensaje_error" class="alert alert-danger"
                                    style="margin: 10px 0 0 0; ">
                                    {{ $mensaje_error }}
                                </div>
                            @endif
                            <div id="error" name="error" class="alert alert-danger"
                                style="display:none;  margin: 10px 0 0 0;">

                            </div>
                            <div class="alert alert-warning" id="aviso"
                                name="aviso"style="display:none;  margin: 10px 0 0 0;">

                            </div>

                            <div class="alert alert-warning" id="aviso_datos" name="aviso_datos"style="display:none;">
                                Completar todos los campos
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

        setTimeout(function() {
            mensaje.style.display = "none";
        }, 30000);

        var mensaje_error = document.getElementById("mensaje_error");

        setTimeout(function() {
            mensaje_error.style.display = "none";
        }, 3000);


        function avisoDatos() {


            $('#aviso_datos').fadeOut(500, function() {
                $('#aviso_datos').fadeIn(500);
            });
            setTimeout(function() {
                $('#aviso_datos').hide();
            }, 3000);
        }




        $(document).ready(function() {




            $('#parte_todo').on('change', function() {



                var selectedValue = $(this).val();
                console.log(selectedValue);
                // hide all select elements
                $('#select, #oficiales, #tp').hide();
                if (selectedValue === 'todo') {


                    $('#select_cat, #select_OF, #select_TP').hide();

                    $('#f').hide();



                } else if (selectedValue === 'cat') {
                    // show select element based on user choice

                    $('#select_cat').show();
                    $('#select_OF').hide();
                    $('#select_TP').hide();
                    $('#f').hide();

                } else if (selectedValue === 'grado') {

                    $('#select_cat').show();
                    $('#f').show();

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
                        if (categoriaSelect.value === "4" || categoriaSelect.value === "5" ||
                            categoriaSelect
                            .value === "7" || categoriaSelect.value === "6" || categoriaSelect
                            .value ===
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


                } else {

                    console.log('no hay nada');

                    $('#aviso_datos').show();

                    setTimeout(avisoDatos, 1000);
                    //mensaje de debes seleccionar una opcion
                }


            });




        });

        /*

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
                    
                    */
    </script>
@endsection
