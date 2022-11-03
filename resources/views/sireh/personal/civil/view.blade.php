@extends('layouts.user_type.auth')
@section('title', 'Personal Civil')
@section('content')

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
                            <h5 class="mb-0">Personal Civil</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="javascript: history.go(-1)">Volver</a>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                <div class="card-body px-2 pt-2 pb-2">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger mx-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="row">  
                        <div class="col-xs-6 col-sm-6 col-md-5 col-lg-5">
                            <div class="form-group">
                                <h6>Tipo Empleado:</h6>
                                <select class="select2 form-control" name="tipo_emp" id="tipo_emp" disabled>
                                    <option value="">Seleccione ...</option>
                                    @foreach ($tipos_emp as $row)
                                        <option value="{{$row->tipo_emp}}" {{$datos->nomina->tipo_emp == $row->tipo_emp? 'selected': '' }}>{{ $row->descripcion }} ({{ $row->tipo_emp}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input hidden="true" style="height: 35px" type="text" class="form-control codigo_empleado" value="{{$datos->codigo_empleado}}" id="codigo_empleado">
                        <div class="col-sm-6 mt-2 pt-4">
                            <div class="row">
                                @if($datos->situacion != 'A')
                                    <div class="col-3">
                                        <a class="btn bg-gradient-success btn-sm mb-0" data-bs-toggle="modal"href="#">ACTIVAR</a>
                                    </div>
                                @else
                                    <div class="col-3">
                                        <a class="btn bg-gradient-danger btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#exampleModalMessage" href="#">SUSPENDER</a>
                                    </div>
                                    <div class="col-3">
                                        <a class="btn bg-gradient-warning btn-sm mb-0"  data-bs-toggle="modal" data-bs-target="#egresar" href="#">EGRESAR</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                          <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cambio de Situación del Profesional</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Fecha de Suspención</label>
                                                    <input style="height: 35px" type="date" class="form-control fechaSuspencion" value="" id="fechaSuspencion">
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Motivo de Suspención</label>
                                                    <select class="form-control motivo" id="motivo" name="motivo" required>
                                                        <option value="">Seleccione...</option>
                                                        <option value="DESERTOR">DESERTOR</option>
                                                        <option value="PRESUNTO DESERTOR">PRESUNTO DESERTOR</option>
                                                        <option value="RETARDADO SIN CAUSA JUSTIFICADA">RETARDADO SIN CAUSA JUSTIFICADA</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Observaciones</label>
                                                    <textarea style="text-transform: uppercase; height: 100px" class="form-control observaciones" name="" id="" rows="7"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Atras</button>
                                        <button type="submit" class="btn bg-gradient-success enviar_suspencion">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Modal -->
                        <div class="modal fade" id="egresar" tabindex="-1" role="dialog" aria-labelledby="egresarTitle" aria-hidden="true">
                          <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cambio de Situación del Profesional</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Fecha de Ingreso</label>
                                                    <input  type="date" class="form-control fecha_ingreso" value="{{$datos->nomina->fecha_ingreso}}" id="" disabled="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Fecha de Egreso</label>
                                                    <input  type="date" class="form-control fecha_egreso" value="" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Motivo de Egreso</label>
                                                    <select class="form-control egreso" id="egreso" name="egreso" required>
                                                        <option value="">Seleccione...</option>
                                                        <option value="PRIVADO DE LIBERTAD">PRIVADO DE LIBERTAD</option>
                                                        <option value="RENUNCIA">RENUNCIA</option>
                                                        <option value="DESPIDO">DESPIDO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Observaciones</label>
                                                    <textarea style="height: 100px" class="form-control observaciones_egreso" name="" id="" rows="7"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Atras</button>
                                        <button type="button" class="btn bg-gradient-success enviar_egreso">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">Datos Personales</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row"> 
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Nacionalidad:</h6>
                                                <select class="select2 form-control registrar" name="nacionalidad" id="nacionalidad" disabled>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($nacionalidades as $key=>$value)
                                                        <option value="{{$key}}" {{$datos->nacionalidad == $key ? 'selected': '' }}>{{ $value }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Cédula:</h6>
                                                <input id="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" disabled 
                                                    value="{{ $datos->cedula }}"
                                                >
                                            </div>
                                        </div>     
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Primer Nombre:</h6>
                                                <input name="nombre1" value="{{$datos->nombre1}}" class = "form-control" disabled>                                        </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Segundo Nombre:</h6>
                                                {!! Form::text('nombre2', $datos->nombre2, array('placeholder' => 'Segundo Nombre','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Primer Apellido:</h6>
                                                {!! Form::text('apellido1', $datos->apellido1, array('placeholder' => 'Primer Apellido','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Segundo Apellido:</h6>
                                                {!! Form::text('apellido2', $datos->apellido2, array('placeholder' => 'Segundo Apellido','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">      
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Fecha Nacimiento: <small></small></h6>
                                                <input name="fecha_nacim" type="date" class="form-control fecha" required value="{{$datos->fecha_nacim}}">
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Sexo:</h6>
                                                <select class="select2 form-control registrar" name="genero" id="genero" required>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($generos as $key=>$value)
                                                        <option value="{{$key}}" {{$datos->sexo == $key? 'selected': '' }}>{{ $value }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Estado Civil:</h6>
                                                <select class="select2 form-control registrar" name="edo_civil" id="edo_civil" required>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($edos_civil as $key=>$value)
                                                        <option value="{{$key}}" {{$datos->edo_civil == $key ? 'selected': '' }}>{{ $value }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row">    
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Telefono:</h6>
                                                {!! Form::text('telefono_cel', $datos->telefono_cel, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Telefono Casa:</h6>
                                                {!! Form::text('telefono', $datos->telefono, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Telefono Oficina:</h6>
                                                {!! Form::text('telefono_ofi', $datos->telefono_ofi, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Correo:</h6>
                                                {!! Form::text('correo', $datos->correo, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">    
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Estado:</h6>
                                                <select class="select2 form-control registrar" name="estado" id="estado" >
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($estados as $row)
                                                        <option value="{{$row->id_estado}}" {{$datos->estado == $row->id_estado ? 'selected': '' }} >{{ $row->estado }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Ciudad:</h6>
                                                <select class="select2 form-control registrar" name="ciudad" id="ciudad">
                                                    <option value="">Seleccione...</option>
                                                    @foreach ($ciudades as $row)
                                                        <option value="{{$row->id}}" {{$datos->ciudad == $row->id ? 'selected': '' }} >{{ $row->ciudad }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <h6>Direccion:</h6>
                                                {!! Form::text('direccion', $datos->direccion, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">Datos Académicos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">    
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <h6>Nivel Instrucción:</h6>
                                                <select class="select2 form-control registrar" name="nivel" id="nivel" required>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($niveles as $row)
                                                        <option value="{{$row->codigo}}" data-nivel="{{$row->nivel_instruccion}}" {{ $datos->nivel_instruccion == $row->codigo ? 'selected': '' }}>{{ $row->descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 nivel_instruccion" >
                                            <div class="form-group">
                                                <h6>Universidad:</h6>
                                                <select class="select2 form-control registrar" name="universidad" id="universidad" >
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($universidades as $row)
                                                        <option value="{{$row->codigo_universidad}}" {{$datos->estudios_realizados ? ($datos->estudios_realizados->universidad == $row->codigo_universidad ? 'selected': '' ) : '' }}>{{ $row->nombre }} ({{$row->tipo_universidad}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 nivel_instruccion" >
                                            <div class="form-group">
                                                <h6>Profesiones:</h6>
                                                <select class="select2 form-control registrar" name="profesion" id="profesion" >
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($profesiones as $row)
                                                        <option value="{{$row->codigo_profesion}}" {{$datos->profesion == $row->codigo_profesion ? 'selected': '' }} >{{ $row->descripcion }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 nivel_instruccion">
                                            <div class="form-group">
                                                <h6>Fecha Graduacion: <small></small></h6>
                                                <input name="fecha_graduacion"  id="fecha_graduacion" type="date" class="form-control fecha" 
                                                    value="{{ $datos->fecha_graduacion }}"
                                                >
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">Datos Laborales</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">    
                                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                            <div class="form-group">
                                                <h6>Fecha Ingreso: <small></small></h6>
                                                <input name="fecha_ingreso"  id="fecha_ingreso" type="date" class="form-control fecha" required
                                                value="{{ $datos->nomina->fecha_ingreso }}"
                                                >
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                            <div class="form-group">
                                                <h6>Ubicación:</h6>
                                                <select class="select2 form-control registrar" name="ubicacion" id="ubicacion" required>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($ubicaciones as $row)
                                                        <option value="{{$row->codigo_ubicacion}}" {{$datos->nomina->codigo_ubicacion == $row->codigo_ubicacion? 'selected' : '' }}>{{ $row->descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                            <div class="form-group">
                                                <h6>Ubicacion Detallada:</h6>
                                                <select class="select2 form-control registrar" name="ubicacion_det" id="ubicacion_det">
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($ubicaciones_det as $row)
                                                        <option value="{{$row->codigo_ubicacion}}" {{$datos->nomina->codigo_ubicacion_detallada == $row->codigo_ubicacion ?  'selected': '' }}>{{ $row->descripcion }} ({{ $row->codigo_ubicacion}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row">    
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 cargo">
                                            <div class="form-group">
                                                <h6>Cargo:</h6>
                                                <select class="select2 form-control" name="cargo" id="cargo">
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($cargos as $row)
                                                        <option value="{{$row->codigo_cargo}}" {{$datos->nomina->codigo_cargo == $row->codigo_cargo ?  'selected': '' }}>{{ $row->nombre_cargo }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 cargo">
                                            <div class="form-group">
                                                <h6>Código RAC/RAPO:</h6>
                                                <input type="text" class="form-control" name="cod_rac" value="{{ $datos->cod_rac ?: null }}">
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 obrero">
                                            <div class="form-group">
                                                <h6>Grado Obrero:</h6>
                                                <select class="select2 form-control" name="grado_obr" id="grado_obr" >
                                                    <option value="">Seleccione</option>
                                                    <option value="1" >1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 obrero">
                                            <div class="form-group">
                                                <h6>Clasificacion Obrero:</h6>
                                                <select class="select2 form-control" name="clasificacion" id="clasificacion" >
                                                <option value="">Seleccione...</option>
                                                <option value="C" >CLASIFICADO</option>
                                                <option value="NC">NO CLASIFICADO</option>
                                                <option value="S">SUPERVISOR</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card " id="div-militar">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">Datos Militares</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">    
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Grado Militar:</h6>
                                                <select class="select2 form-control" name="grado_militar" id="grado_militar" >
                                                    <option value="">Seleccione...</option>
                                                    @foreach ($grados_militares as $row)
                                                        <option value="{{$row->codigo_grado}}" {{$datos->nomina->grado_militar == $row->codigo_grado ?  'selected': '' }}>{{ $row->descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Contingente:</h6>
                                                {!! Form::text('contingente', $datos->datos_militares ? $datos->datos_militares->contingente : null, array('id'=>'contingente', 'placeholder' => '','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card" >
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">Otros Datos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">    
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                            <div class="form-group">
                                                <h6>Nombre y Apellido (contacto de emergencia):</h6>
                                                {!! Form::text('persona_contacto', $datos->persona_contacto, array('placeholder' => '','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <h6>Telefono (contacto de emergencia):</h6>
                                                {!! Form::text('telefono_e', $datos->telefono_e, array('placeholder' => '','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="avatar-wrapper">
                                <img class="profile-pic" src="{{ $datos->foto ? url($datos->foto): '' }}" />
                                <div class="upload-button">
                                    <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>

    $(document).ready(function () {  
        $('.nivel_instruccion').hide();
        $('.obrero').hide();
        $('.cargo').hide();
        $("select.registrar").prop( "disabled", true );
        $("#btn-registrar").prop( "disabled", true );
        $('.select2').select2();
        $('.motivo').select2();
        $('.egreso').select2();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".enviar_suspencion").click(function(e){
            e.preventDefault();
            var motivo = $('.motivo').val();
            if(motivo===""){
                Swal.fire({
                    title: 'Atención!',
                    text: 'Debes Ingresar un Motivo.',
                    icon: 'warning',
                    timer: 3000,
                    showConfirmButton: true,
                }); 
            }else{
                //ENVIAR
                $.ajax({
                url:"{{ route('sireh.personal-civil.suspender') }}",
                method:'POST',
                data:{
                    fecha: $('.fechaSuspencion').val(),
                    motivo: motivo,
                    observaciones: $('.observaciones').val().toUpperCase(),
                    codigo_empleado: $('.codigo_empleado').val(),
                    },
                    success:function(response){
                        if(response.success){
                            $('#exampleModalMessage').modal('hide');
                            Swal.fire({
                                title: 'LISTO!',
                                text: 'Empleado Suspendido Correctamente!',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                });
            }
        });

        $(".enviar_egreso").click(function(e){
            e.preventDefault();
            var egreso = $('.egreso').val();
            if(egreso===""){
                Swal.fire({
                    title: 'Atención!',
                    text: 'Debes Ingresar un motivo de Egreso.',
                    icon: 'warning',
                    timer: 3000,
                    showConfirmButton: true,
                }); 
            }else{
                //ENVIAR
                $.ajax({
                url:"{{ route('sireh.personal-civil.egreso') }}",
                method:'POST',
                data:{
                        egreso: egreso,
                        fecha_ingreso: $('.fecha_ingreso').val(),
                        fecha_egreso: $('.fecha_egreso').val(),
                        observaciones: $('.observaciones_egreso').val().toUpperCase(),
                        codigo_empleado: $('.codigo_empleado').val(),
                    },
                    success:function(response){
                        if(response.success){
                            $('#egresar').modal('hide');
                            Swal.fire({
                                title: 'LISTO!',
                                text: 'Empleado Egresado Correctamente!',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                });
            }
        });
    })
</script>
@endsection