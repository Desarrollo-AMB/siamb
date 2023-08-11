@extends('layouts.user_type.auth')
@section('title', 'Personal Militar')
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
                            <h5 class="mb-0">Personal Militar</h5>
                        </div>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                @include('juntap.personalm._barra_auxiliar')
                <hr class="horizontal dark my-0">
                <div class="card-body px-2 pt-2 pb-2">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <table id="table" class="table table-sm table-bordered table-hover w-100 nowrap"
                                    data-order='[[2, "asc"]]'>
                                    <thead>
                                        <tr>
                                            <th>Cedula</th>
                                            <th>Nombre </th>
                                            <th>Apellido</th>
                                            <th>Grado Militar</th>
                                            <th>Ubicacion</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- Modal para Suspender Profesional --}}
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle"
        aria-hidden="true">
        <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Suspención del Profesional</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    @csrf
                    <input type="hidden" value="" name="id" id="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Fecha de Suspención</label>
                                    <input style="height: 35px" type="date" class="form-control" value=""
                                        name="fechaSuspencion" id="fechaSuspencion">
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Motivo de Suspención</label>
                                    <select class="form-control motivo" id="motivo" name="motivo" required>
                                        <option value="">Seleccione...</option>
                                        <option value="DESERTOR">DESERTOR</option>
                                        <option value="PRESUNTO DESERTOR">PRESUNTO DESERTOR</option>
                                        <option value="RETARDADO SIN CAUSA JUSTIFICADA">RETARDADO SIN CAUSA JUSTIFICADA
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Observaciones</label>
                                    <textarea style="text-transform: uppercase; height: 100px" class="form-control" name="observaciones" id="observaciones"
                                        rows="7"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Atras</button>
                        <button type="submit" class="btn bg-gradient-success" id="btn-suspender_militar">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- /.modal --}}

    {{-- MODAL FUNCION EMPLEADO --}}
    <div class="modal fade" id="modal-view-funcion_empleado" tabindex="-1" role="dialog" aria-labelledby="egresarTitle"
        aria-hidden="true">
        <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar Función</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <input class="codigo_empleado_funcion" name="codigo_empleado_funcion"
                            id="codigo_empleado_funcion" type="hidden" value="">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nombre y Apellido</label>
                                    <input type="text" class="form-control nombre_empleado" value=""
                                        id="nombre_empleado" disabled>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">cedula</label>
                                    <input type="text" class="form-control cedula_empleado" value=""
                                        id="cedula_empleado" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Seleccionar Función</label>
                                    <select class="form-control funcion select2" id="funcion" name="funcion[]"
                                        multiple="multiple" required>
                                        {{-- <option value="">Seleccione...</option>
                                    @foreach ($funcionEmpleado as $data)
                                        <option value="{{$data->id}}">{{$data->funcion}}</option>
                                    @endforeach --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="haveFuncion">
                            <label class='col-form-label showLabel' hidden="true">Funciones del Empleado</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn bg-gradient-danger close-modal" data-bs-dismiss="modal" disabled="false">Atras</a>
                        <a class="btn bg-gradient-success enviar_funcion" disabled="false">Confirmar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL ascenso EMPLEADO --}}
    <div class="modal fade" id="modal-view-ascenso_personal" tabindex="-1" role="dialog"
        aria-labelledby="egresarTitle" aria-hidden="true">
        <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ascenso Personal Militar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="
                color: black;
               
                font-weight: bolder;
               
             ">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    @csrf
                    <div class="modal-body">
                        <input class="codigo_empleado" name="codigo_empleado" id="codigo_empleado" type="hidden"
                            value="">
                        <div class="row">
                            <div class="col-sm-6 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Grado</label>

                                    <input type="text" class="form-control grado_empleado" value=""
                                        id="grado_empleado" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6 text-center">

                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nombre</label>

                                    <input type="text" class="form-control nombre_empleado" value=""
                                        id="nombre_empleado" disabled>

                                </div>
                            </div>
                        </div>
                        <div class="row"
                            style="
                   
                        justify-content: space-around;
                     ">
                            <div class="col-sm-4 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Orden de Merito</label>

                                    <input type="Number" class="form-control" name="om" id="om"
                                        min="0">


                                </div>
                            </div>
                            <div class="col-sm-4 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Orden de Merito Total</label>

                                    <input type="Number" class="form-control" name="omt" id="omt"
                                        min="0">


                                </div>
                            </div>
                        </div>

                        <div class="row"
                            style="
                   
                            justify-content: space-around;
                                ">
                            <div class="col-sm-4 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Grado a Ascender</label>



                                    <select class="form-select" name="select_ofi"
                                        id="select_ofi"aria-label="Default select example" style="display:none;">
                                        <option selected>Seleccionar...</option>
                                        <option value="10">GJ</option>
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

                                    <select class="form-select" name="select_tropap"
                                        id="select_tropap"aria-label="Default select example" style="display:none;">
                                        <option selected>Seleccionar...</option>
                                        <option value="410">SS</option>
                                        <option value="420">SA</option>
                                        <option value="430">SM1</option>
                                        <option value="440">SM2</option>
                                        <option value="450">SM3</option>
                                        <option value="460">S1</option>
                                        <option value="470">S2</option>
                                    </select>


                                </div>
                            </div>
                            <div class="col-sm-4 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Fecha:</label>

                                    <input type="date" class="form-control" id="fecha" name="fecha">


                                </div>
                            </div>
                        </div>
                        <div class="row"
                            style="
                   
                            justify-content: space-around;
                                ">

                            <div class="col-sm-4 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Resolución:</label>

                                    <input type="text" class="form-control" id="resuelto" name="resuelto">


                                </div>
                            </div>


                            <div class="col-sm-4 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Recon. de
                                        Antigüedad</label>



                                    <select class="form-select" name="select_just"
                                        id="select_just"aria-label="Default select example" style="">
                                        <option selected>No</option>

                                        <option value="si">Si</option>

                                    </select>


                                </div>
                            </div>

                        </div>



                        <div class="row" style="justify-content: space-around; ">
                            <div class="col-sm-3 text-center" id="r1" style="display:none;">
                                <div class="form-group">
                                    <br>
                                    <label for="recipient-name" class="col-form-label">Justificación:</label>

                                    <textarea type="text" class="form-control" id="justif" name="justif"> </textarea>


                                </div>

                            </div>
                            <div class="col-sm-3 text-center" id="r2" style="display:none;">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Años Reconocidos:</label>

                                    <input type="text" class="form-control" id="reconoc" name="reconoc">


                                </div>

                            </div>
                            <div class="col-sm-3 text-center" id="r3" style="display:none;">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Fecha Resol. Recon.:</label>

                                    <input type="date" class="form-control" id="fecha_reconoc" name="fecha_reconoc">


                                </div>

                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <a class="btn bg-gradient-danger close-modal" data-bs-dismiss="modal" disabled="false">Atras</a>
                        <a class="btn bg-gradient-success enviar_ascenso" disabled="false">Confirmar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-view-categoria_personal" tabindex="-1" role="dialog"
        aria-labelledby="egresarTitle" aria-hidden="true">
        <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cambio de Categoria Personal Militar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="
             color: black;
           
             font-weight: bolder;
           
              ">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    @csrf
                    <div class="modal-body">
                        <input class="codigo_empleado_cat" name="codigo_empleado_cat" id="codigo_empleado_cat"
                            type="hidden" value="">
                        <div class="row">
                            <div class="col-sm-6 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Grado</label>

                                    <input type="text" class="form-control grado_empleado_cat" value=""
                                        id="grado_empleado_cat" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6 text-center">

                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nombre</label>

                                    <input type="text" class="form-control nombre_empleado_cat" value=""
                                        id="nombre_empleado_cat" disabled>

                                </div>
                            </div>
                        </div>
                        <div class="row"
                            style="
               
                      justify-content: space-around;
                     ">
                            <div class="col-sm-4 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Orden de Merito</label>

                                    <input type="Number" class="form-control" name="om_cat" id="om_cat"
                                        min="0">


                                </div>
                            </div>
                            <div class="col-sm-4 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Orden de Merito Total</label>

                                    <input type="Number" class="form-control" name="omt_cat" id="omt_cat"
                                        min="0">


                                </div>
                            </div>
                        </div>

                        <div class="row"
                            style="
               
                         justify-content: space-around;
                            ">

                            <div class="col-sm-4 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Categoria</label>



                                    <select class="form-select" name="select_categoria"
                                        id="select_categoria"aria-label="Default select example">
                                        <option selected>Seleccionar...</option>
                                        <option value="04">Oficial Comando</option>
                                        <option value="05">Oficial Técnico</option>
                                        <option value="07">Oficial Tropa</option>
                                        <option value="02">Oficial Asimilado</option>
                                        <option value="06">Oficial Asimilado Técnico</option>
                                        <option value="08">Tropa Profesional</option>

                                    </select>



                                </div>
                            </div>

                            <div class="col-sm-4 text-center" id="select_OFI_C">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Grado</label>



                                    <select class="form-select" name="select_ofi_cat"
                                        id="select_ofi_cat"aria-label="Default select example">
                                        <option selected>Seleccionar...</option>
                                        <option value="10">GJ</option>
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

                            <div class="col-4 text-center" name="select_TP_C" id="select_TP_C" style="display:none;">

                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Grado</label>
                                    <select class="form-select" name="select_tp_cat"
                                        id="select_tp_cat"aria-label="Default select example">
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

                            <div class="col-sm-4 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Resolución:</label>

                                    <input type="text" class="form-control" id="resuelto_cat" name="resuelto_cat">


                                </div>
                            </div>

                            <div class="col-sm-4 text-center">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Fecha:</label>

                                    <input type="date" class="form-control" id="fecha_cat" name="fecha_cat">


                                </div>
                            </div>

                        </div>

                    </div>



                    <div class="modal-footer">
                        <a class="btn bg-gradient-danger close-modal" data-bs-dismiss="modal" disabled="false">Atras</a>
                        <a class="btn bg-gradient-success enviar_categoria" disabled="false">Confirmar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function() {
            $('.select2').select2();

            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                ajax: "{{ route('api.juntap.personalm.data') }}",
                columns: [{
                        data: 'cedula',
                    },
                    {
                        data: 'nombre1'
                    },
                    {
                        data: 'apellido1'
                    },
                    {
                        data: 'grado_militar',
                        name: 'grados_militares.descripcion'
                    },
                    {
                        data: 'ubicacion',
                        name: 'ubicaciones.descripcion',
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                search: {
                    return: true,
                },
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });




            //FUNCIONES PARA asceder personal
            table.on('click', '.ascenso_personal', function() {
                var id = $(this).data("id");
                $("#haveFuncion").empty();
                $.ajax({
                    url: "{{ route('juntap.personalm.datas') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.data) {
                            let res = response.data;

                            var grado_empleado = res
                                .grado_militar;
                            console.log(grado_empleado);

                            if (grado_empleado === 'GENERAL EN JEFE' || grado_empleado ===
                                'SARGENTO SUPERVISOR') {
                                $('#select_ofi').hide()
                                $('#select_tropap').hide()

                            } else {
                                if (grado_empleado === 'MAYOR GENERAL' || grado_empleado ===
                                    'GENERAL DE DIVISIÓN' || grado_empleado ===
                                    'GENERAL DE BRIGADA' || grado_empleado === 'CORONEL' ||
                                    grado_empleado === 'TENIENTE CORONEL' || grado_empleado ===
                                    'MAYOR' || grado_empleado === 'CAPITÁN' ||
                                    grado_empleado === 'PRIMER TENIENTE' || grado_empleado ===
                                    'TENIENTE') {
                                    $('#select_ofi').show()
                                    $('#select_tropap').hide()
                                } else {
                                    $('#select_tropap').show()
                                    $('#select_ofi').hide()
                                }

                            }


                            $('#modal-view-ascenso_personal #nombre_empleado').val(res.nombre1 +
                                ' ' + res.apellido1);
                            $('#modal-view-ascenso_personal #grado_empleado').val(res
                                .grado_militar);

                            $('#modal-view-ascenso_personal #codigo_empleado').val(res
                                .codigo_empleado);
                        } else {
                            alert('Fallo en la peticion con el servidor')
                        }
                    }
                });
                $('#modal-view-ascenso_personal').modal("show");
            });

            table.on('click', '.suspender_militar', function() {
                var id = $(this).data("id");

                $('#modal-view').modal("show");
                $('#modal-view').on('shown.bs.modal', function(e) {
                    $('#modal-view #id_empleado').val(id);
                })
                $("#id").val(id);
            });

            $('#btn-suspender_militar').on('click', function() {
                console.log('Suspender');
                var fd = new FormData();
                var form = $(this).parents('form:first');
                var validator = form.validate({
                    rules: {
                        fechaSuspencion: {
                            required: true,
                        },
                        motivo: {
                            required: true,
                        },
                        observaciones: {
                            required: true,
                        },
                    },
                    messages: {
                        fechaSuspencion: {
                            required: "Fecha de Suspencion es requerida"
                        },
                        motivo: {
                            required: "Motivo de Suspencion es requerido"
                        },
                        observaciones: {
                            required: "Las Observaciones de Suspencion es requerido"
                        },
                    }
                });
                if (validator.form()) {
                    var other_data = form.serializeArray();
                    ///Obtener inputs
                    $.each(other_data, function(key, input) {
                        fd.append(input.name, input.value);
                    });

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('sireh.personal-militar.suspender') }}',
                        data: fd,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            Swal.fire({
                                title: 'Egreso!',
                                text: 'Proceso realizado satisfactoriamente...',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            if (res.success) {
                                window.location.reload();
                            }
                        }
                    });
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });






            var just = "no";
            $("#select_just").change(function() {
                if ($(this).val() == "si") {
                    just = "si";
                    $("#r1").show();
                    $("#r2").show();

                    $("#r3").show();
                } else {
                    just = "no";
                    $("#r1").hide();
                    $("#r2").hide();
                    $("#r3").hide();
                }
            });

            $(".enviar_ascenso").click(function(e) {
                e.preventDefault();
                var select_just = just;
                var select_ofi = $('select[name="select_ofi"]').val();
                var select_tropap = $('select[name="select_tropap"]').val();
                var om = $("#om").val();
                var omt = $("#omt").val();
                var fecha = $("#fecha").val();
                var resuelto = $("#resuelto").val();
                var justif = $("#justif").val();
                var reconoc = $("#reconoc").val();
                var fecha_reconoc = $("#fecha_reconoc").val();
                console.log(select_just + " ---------------");
                console.log(select_just + " welect_just");
                console.log(select_ofi.trim() + " select_ofi.trim()");
                console.log(select_tropap.trim() + " select_tropap.trim()");
                console.log(fecha.trim() + " fecha.trim()");
                console.log(justif.trim() + " justif.trim()");
                console.log(reconoc.trim() + " reconoc.trim()");
                console.log(fecha_reconoc.trim() + " jfecha_r.trim()");



                if (select_just === "no") {
                    if (select_tropap.trim() === "Seleccionar..." && select_ofi.trim() ===
                        "Seleccionar...") {

                        Swal.fire({
                            title: 'Atención!',
                            text: 'Debes Completar los Campos.',
                            icon: 'warning',
                            timer: 3000,
                            showConfirmButton: true,
                        });



                    } else if (select_tropap.trim() === "" || select_tropap.trim() === "Seleccionar...") {
                        console.log("entro");
                        if (select_ofi.trim() === "" || select_ofi.trim() === "Seleccionar..." || om
                            .trim() ===
                            "" || omt.trim() === "" || fecha.trim() === "" || resuelto.trim() === "") {

                            //ENVIAR


                            Swal.fire({
                                title: 'Atención!',
                                text: 'Debes Completar los Campos.',
                                icon: 'warning',
                                timer: 3000,
                                showConfirmButton: true,
                            });



                        } else {


                            $.ajax({
                                url: "{{ route('api.juntap.ascenso.personal') }}",
                                method: 'POST',
                                data: {
                                    codigo_empleado: $('#codigo_empleado').val(),
                                    grado_empleado: $('#grado_empleado').val(),
                                    select_ofi: select_ofi,
                                    select_just: select_just,
                                    fecha: fecha,
                                    resuelto: resuelto,
                                    om: om,
                                    omt: omt
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('#modal-view-ascenso_personal').modal('hide');
                                        Swal.fire({
                                            title: 'LISTO!',
                                            text: 'Personal Ascendido Correctamente!',
                                            icon: 'success',
                                            timer: 3000,
                                            showConfirmButton: true,
                                        });
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);
                                    } else {

                                        $('#modal-view-ascenso_personal').modal('hide');
                                        Swal.fire({
                                            title: 'ERROR!',
                                            text: 'Error al Ascender este Empleado!',
                                            icon: 'success',
                                            timer: 3000,
                                            showConfirmButton: false,
                                        });
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);




                                    }
                                },
                                error: function(error) {
                                    console.log(error)
                                }
                            });

                        }
                    } else {

                        if (select_tropap.trim() === "Seleccionar..." || om.trim() === "" || omt.trim() ===
                            "" || fecha.trim() === "" || resuelto.trim() === "") {

                            //ENVIAR


                            Swal.fire({
                                title: 'Atención!',
                                text: 'Debes Completar los Campos.',
                                icon: 'warning',
                                timer: 3000,
                                showConfirmButton: true,
                            });



                        } else {


                            $.ajax({
                                url: "{{ route('api.juntap.ascenso.personal') }}",
                                method: 'POST',
                                data: {
                                    codigo_empleado: $('#codigo_empleado').val(),
                                    grado_empleado: $('#grado_empleado').val(),
                                    select_tropap: select_tropap,
                                    select_just: select_just,
                                    fecha: fecha,
                                    resuelto: resuelto,
                                    om: om,
                                    omt: omt
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('#modal-view-ascenso_personal').modal('hide');
                                        Swal.fire({
                                            title: 'LISTO!',
                                            text: 'Personal Ascendido Correctamente!',
                                            icon: 'success',
                                            timer: 3000,
                                            showConfirmButton: true,
                                        });
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);
                                    } else {

                                        $('#modal-view-ascenso_personal').modal('hide');
                                        Swal.fire({
                                            title: 'ERROR!',
                                            text: 'Error al Ascender este Empleado!',
                                            icon: 'success',
                                            timer: 3000,
                                            showConfirmButton: false,
                                        });
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);




                                    }
                                },
                                error: function(error) {
                                    console.log(error)
                                }
                            });

                        }

                    }


                } else {



                    if (select_tropap.trim() === "Seleccionar..." && select_ofi.trim() ===
                        "Seleccionar...") {

                        Swal.fire({
                            title: 'Atención!',
                            text: 'Debes Completar los Campos.',
                            icon: 'warning',
                            timer: 3000,
                            showConfirmButton: true,
                        });



                    } else if (select_tropap.trim() === "" || select_tropap.trim() === "Seleccionar...") {
                        console.log("entroofi");
                        if (select_ofi.trim() === "" || select_ofi.trim() === "Seleccionar..." || om
                            .trim() ===
                            "" || omt.trim() === "" || fecha.trim() === "" || resuelto.trim() === "" ||
                            justif.trim() === "" || reconoc.trim() === "" || fecha_reconoc.trim() === "") {

                            //ENVIAR


                            Swal.fire({
                                title: 'Atención!',
                                text: 'Debes Completar los Campos.',
                                icon: 'warning',
                                timer: 3000,
                                showConfirmButton: true,
                            });



                        } else {

                            console.log("entroofi2222");
                            $.ajax({
                                url: "{{ route('api.juntap.ascenso.personal') }}",
                                method: 'POST',
                                data: {
                                    codigo_empleado: $('#codigo_empleado').val(),
                                    grado_empleado: $('#grado_empleado').val(),
                                    select_ofi: select_ofi,
                                    select_just: select_just,
                                    justif: justif,
                                    fecha: fecha,
                                    resuelto: resuelto,
                                    reconoc: reconoc,
                                    fecha_reconoc: fecha_reconoc,
                                    om: om,
                                    omt: omt,
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('#modal-view-ascenso_personal').modal('hide');
                                        Swal.fire({
                                            title: 'LISTO!',
                                            text: 'Personal Ascendido Correctamente!',
                                            icon: 'success',
                                            timer: 3000,
                                            showConfirmButton: true,
                                        });
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);
                                    } else {

                                        $('#modal-view-ascenso_personal').modal('hide');
                                        Swal.fire({
                                            title: 'ERROR!',
                                            text: 'Error al Ascender este Empleado!',
                                            icon: 'success',
                                            timer: 3000,
                                            showConfirmButton: false,
                                        });
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);




                                    }
                                },
                                error: function(error) {
                                    console.log(error)
                                }
                            });

                        }
                    } else {

                        if (select_tropap.trim() === "Seleccionar..." || om.trim() === "" || omt.trim() ===
                            "" || fecha.trim() === "" || resuelto.trim() === "" ||
                            justif.trim() === "" || reconoc.trim() === "" || fecha_reconoc.trim() === "") {

                            //ENVIAR


                            Swal.fire({
                                title: 'Atención!',
                                text: 'Debes Completar los Campos.',
                                icon: 'warning',
                                timer: 3000,
                                showConfirmButton: true,
                            });



                        } else {


                            $.ajax({
                                url: "{{ route('api.juntap.ascenso.personal') }}",
                                method: 'POST',
                                data: {
                                    codigo_empleado: $('#codigo_empleado').val(),
                                    grado_empleado: $('#grado_empleado').val(),
                                    select_tropap: select_tropap,
                                    select_just: select_just,
                                    justif: justif,
                                    fecha: fecha,
                                    resuelto: resuelto,
                                    reconoc: reconoc,
                                    fecha_reconoc: fecha_reconoc,
                                    om: om,
                                    omt: omt,
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('#modal-view-ascenso_personal').modal('hide');
                                        Swal.fire({
                                            title: 'LISTO!',
                                            text: 'Personal Ascendido Correctamente!',
                                            icon: 'success',
                                            timer: 3000,
                                            showConfirmButton: true,
                                        });
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);
                                    } else {

                                        $('#modal-view-ascenso_personal').modal('hide');
                                        Swal.fire({
                                            title: 'ERROR!',
                                            text: 'Error al Ascender este Empleado!',
                                            icon: 'success',
                                            timer: 3000,
                                            showConfirmButton: false,
                                        });
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);




                                    }
                                },
                                error: function(error) {
                                    console.log(error)
                                }
                            });

                        }

                    }



                }





            });
            //
            $('#select_OFI_C').hide();
            $('#select_TP_C').hide();
            $('#select_categoria').on('change', function() {

                var selectedValue = $(this).val();
                console.log(selectedValue);

                if (selectedValue === '08') {
                    $('#select_TP_C').show();
                    $('#select_OFI_C').hide();
                } else {
                    $('#select_TP_C').hide();
                    $('#select_OFI_C').show();
                }


            });


            //FUNCIONES PARA asceder personal
            table.on('click', '.cambio_categoria', function() {
                var id = $(this).data("id");
                $("#haveFuncion").empty();
                $.ajax({
                    url: "{{ route('juntap.personalm.datas') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.data) {
                            let res = response.data;






                            $('#modal-view-categoria_personal #nombre_empleado_cat').val(res
                                .nombre1 +
                                ' ' + res.apellido1);
                            $('#modal-view-categoria_personal #grado_empleado_cat').val(res
                                .grado_militar);

                            $('#modal-view-categoria_personal #codigo_empleado_cat').val(res
                                .codigo_empleado);
                        } else {
                            alert('Fallo en la peticion con el servidor')
                        }
                    }
                });
                $('#modal-view-categoria_personal').modal("show");
            });







            $(".enviar_categoria").click(function(e) {
                e.preventDefault();
                var select_tp_cat = $('select[name="select_tp_cat"]').val();
                var select_ofi_cat = $('select[name="select_ofi_cat"]').val();
                var select_categoria = $('select[name="select_categoria"]').val();
                var om_cat = $("#om_cat").val();
                var omt_cat = $("#omt_cat").val();
                var fecha_cat = $("#fecha_cat").val();
                var resuelto_cat = $("#resuelto_cat").val();

                console.log(" ---------------");

                console.log(select_ofi_cat.trim() + " select_ofi.trim()");
                console.log(resuelto_cat.trim() + " resuelto.trim()");
                console.log(fecha_cat.trim() + " fecha.trim()");
                console.log(select_categoria.trim() + " categora.trim()");
                console.log(om_cat.trim() + " omt.trim()");
                console.log(omt_cat.trim() + " jomr.trim()");
                console.log(select_tp_cat.trim() + " select_tp.trim()");


                console.log("codigo_empleado:" + $('#codigo_empleado_cat').val());

                if (select_categoria.trim() === "Seleccionar..." ||
                    om_cat.trim() === "" || omt_cat.trim() === "" || fecha_cat.trim() === "" || resuelto_cat
                    .trim() === "") {

                    Swal.fire({
                        title: 'Atención!',
                        text: 'Debes Completar los Campos.',
                        icon: 'warning',
                        timer: 3000,
                        showConfirmButton: true,
                    });



                } else if (select_tp_cat.trim() !== "Seleccionar..." && select_ofi_cat.trim() !==
                    "Seleccionar...") {


                        Swal.fire({
                        title: 'Atención!',
                        text: 'Error al Completar los Campos debes Actualizar la Pagina.',
                        icon: 'warning',
                        timer: 3000,
                        showConfirmButton: true,
                    });



                    }
                
                
                
                
                
                
                
                
                
                else if (select_tp_cat.trim() !== "Seleccionar..." && select_ofi_cat.trim() ===
                    "Seleccionar...") {

                    console.log("tp_entro");
                    console.log(select_tp_cat.trim());
                    $.ajax({
                        url: "{{ route('api.juntap.cambio.categoria.personal') }}",
                        method: 'POST',
                        data: {
                            codigo_empleado_cat: $('#codigo_empleado_cat').val(),
                            grado_empleado: $('#grado_empleado_cat').val(),
                            select_tp_cat: select_tp_cat,
                            fecha_cat: fecha_cat,
                            resuelto_cat: resuelto_cat,
                            select_categoria: select_categoria,
                            om_cat: om_cat,
                            omt_cat: omt_cat
                        },
                        success: function(response) {
                            if (response.success) {


                                $('#modal-view-categoria_personal').modal('hide');
                                Swal.fire({
                                    title: 'LISTO!',
                                    text: 'Personal Cambio Correctamente de Categoria!',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: true,
                                });
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);



                            } else {

                                $('#modal-view-categoria_personal').modal('hide');
                                Swal.fire({
                                    title: 'ERROR!',
                                    text: 'Error al Cambiar la Categoria del Empleado!',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: false,
                                });
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);




                            }
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });



                } else {
                    console.log("ofi_entro");



                    console.log("entroofi2222");
                    $.ajax({
                        url: "{{ route('api.juntap.cambio.categoria.personal') }}",
                        method: 'POST',
                        data: {
                            codigo_empleado_cat: $('#codigo_empleado_cat').val(),
                            grado_empleado: $('#grado_empleado_cat').val(),
                            select_ofi_cat: select_ofi_cat,

                            fecha_cat: fecha_cat,
                            resuelto_cat: resuelto_cat,
                            select_categoria: select_categoria,
                            om_cat: om_cat,
                            omt_cat: omt_cat
                        },
                        success: function(response) {
                            if (response.success) {


                                $('#modal-view-categoria_personal').modal('hide');
                                Swal.fire({
                                    title: 'LISTO!',
                                    text: 'Personal Cambio Correctamente de Categoria!',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: true,
                                });
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);



                            } else {

                                $('#modal-view-categoria_personal').modal('hide');
                                Swal.fire({
                                    title: 'ERROR!',
                                    text: 'Error al Cambiar la Categoria del Empleado!',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: false,
                                });
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);




                            }
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });

                }



            });











            $("body").on("click", ".eliminar_funcion", function() {
                var id = $(this).attr('id')
                Swal.fire({
                    title: 'Estas Seguro de Eliminar?',
                    text: "No podrás revertir esto.!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('sireh.personal-militar.deleteFuncion') }}",
                            method: 'POST',
                            data: {
                                id: id
                            },
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    window.location.reload();
                                }
                            }
                        });
                        Swal.fire({
                            title: 'Eliminado!',
                            text: 'La Función ha sido eliminada.',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: true,
                        });
                    }
                });
            })
        }); //ENVIAR
    </script>
@endsection
