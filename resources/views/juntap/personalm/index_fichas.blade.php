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
                        <h5 class="mb-0">Periodo de Ascenso</h5>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="row justify-content-end">
                
                <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                       <form method="POST" action="{{ route('juntap.personalm.select') }}">
                           
                            @csrf
                            <div class="row align-items-center" style="
                            display: flex;
                            justify-content: center;
                        ">
                                <div class="col-3 text-center">
                                  
                                    <div class="form-group">
                                        <h6 for="Grado">Periodo de Ascenso: <small></small></h6>
                                        <select class="form-select" name="select_periodo" id="select_periodo"aria-label="Default select example">
                                            <option selected>Seleccionar...</option>
                                            <option value="julio">Julio</option>
                                            <option value="diciembre">Diciembre</option>
                                            
                                          </select>  
                                    </div>
                                </div>
                                <div class="col-3 text-center">
                               
                                     <div class="form-group ">
                                        <h6 for="Grado">Categoria: <small></small></h6>
                                        <select class="form-select" name="select_categoria" id="select_categoria"aria-label="Default select example">
                                            <option selected>Seleccionar...</option>
                                            <option value="comando">Oficiales de Comando</option>
                                            <option value="tecnico">Oficiales Técnicos</option>
                                            <option value="ofitropa">Oficiales de Tropa</option>                                           
                                            <option value="asimilado">Oficiales Asimilados</option>
                                            <option value="asimiladotec">Oficiales Asimilado Técnico</option>
                                            <option value="tropaprofesional">Tropa Profesional</option>
                                            
                                          </select>  

                        
                                     
                                    </div>
                                </div>

                                
                                
                                <button type="submit" class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>
                             </form>
                                
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




                                    const selectPeriodo = document.getElementById("select_periodo");
                                    const selectCategoria = document.getElementById("select_categoria");
                                  
                                    selectPeriodo.onchange = function() {
                                      if (selectPeriodo.value === "diciembre") {
                                        selectCategoria.innerHTML = `
                                          <option selected>Seleccionar...</option>
                                          
                                          <option value="ofitropa">Oficiales de Tropa</option>                                         
                                          <option value="asimilado">Oficiales Asimilados</option>
                                          <option value="asimiladotec">Oficiales Asimilado Técnico</option>
                                        `;
                                      } else {
                                        selectCategoria.innerHTML = `
                                          <option selected>Seleccionar...</option>
                                          <option value="comando">Oficiales de Comando</option>
                                          <option value="tecnico">Oficiales Técnicos</option>
                                          <option value="ofitropa">Oficiales de Tropa</option>
                                          <option value="asimilado">Oficiales Asimilados</option>
                                          <option value="asimiladotec">Oficiales Asimilado Técnico</option>
                                          <option value="tropaprofesional">Tropa Profesional</option>
                                        `;
                                      }
                                    }
                                  
   
   
   
   
               
</script>
@endsection
