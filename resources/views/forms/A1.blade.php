<div class="row">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a style="color:#67748e" class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">V1</a>
        </li>
        <li class="nav-item">
            <a style="color:#67748e" class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">V2</a>
        </li>
        <li class="nav-item">
            <a style="color:#67748e" class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">V3</a>
        </li>
    </ul>
    <div style="padding-top:60px;" class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <h6>11. MISIÓN<small></small></h6>
                        {{-- <input name="text" type="text" class="form-control" > --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <h6 style="color: #344767;">ORDENADA POR</h6>
                            <input name="text" type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <h6 style="color: #344767;">EN APOYO A</h6>
                            <input name="text" type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <h6 style="color: #344767;">CODIGO</h6>
                            <input name="text" type="text" class="form-control" >
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-sm-4">
                    <div class="form-group">
                        <h6>12. RUTA<small></small></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <h6 style="color: #344767;">DESDE</h6>
                            <input name="text" type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <h6 style="color: #344767;">HASTA</h6>
                            <input name="text" type="text" class="form-control" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"> <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <h6>4. SERIAL</h6>
                    <select name="country" id="serial" class="form-control">
                        <option>Seleccionar..</option>
                        @foreach($matriculas as $data) 
                            @if ($data->serial==null)
                            @else
                            <option value="{{$data->id}}">{{$data->serial}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <h6>5. MATRICULA <small></small></h6>
                    <select name="country" id="matricula" class="form-control">
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <h6>6. COMPONENTE / ORGANISMO <small></small></h6>
                    <select name="country" class="form-control">
                        <option>Seleccionar..</option>
                        @foreach($componentes as $data) 
                            <option value="{{$data->id}}">{{$data->componente}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div></div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
    </div>
</div>