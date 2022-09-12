@extends('layouts.user_type.auth')
@section('title', 'form')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success mx-4" role="alert">
    <span class="text-white">{{ $message }}</span>
</div>
@endif
@section('styles')
<link href="template/wizard/css/paper-bootstrap-wizard.css" rel="stylesheet" /> 
@endsection
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="container">
                <div class="row">
                    <div style="margin: 0 auto;" class="col-sm-11 col-sm-offset-2">
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="orange" id="wizardProfile">
                                <form action="" method="">
                                    <div class="wizard-header text-center">
                                        <h3 class="wizard-title">Formulario Orden de Vuelo</h3>
                                        <p class="category">This information will let us know more about you.</p>
                                    </div>
                                    <div class="wizard-navigation">
                                        <div class="progress-with-circle">
                                             <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="#about" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-user"></i>
                                                    </div>
                                                    About
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#account" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-settings"></i>
                                                    </div>
                                                    Work
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#address" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-map"></i>
                                                    </div>
                                                    Address
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="about">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>First Name <small>(required)</small></label>
                                                        <input name="firstname" type="text" class="form-control" placeholder="Andrew...">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Last Name <small>(required)</small></label>
                                                        <input name="lastname" type="text" class="form-control" placeholder="Smith...">
                                                    </div>
                                                </div>
                                                <div class="col-sm-10 col-sm-offset-1">
                                                    <div class="form-group">
                                                        <label>Email <small>(required)</small></label>
                                                        <input name="email" type="email" class="form-control" placeholder="andrew@creative-tim.com">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="account">
                                            <h5 class="info-text"> What are you doing? (checkboxes) </h5>
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <div class="col-sm-4">
                                                        <div class="choice" data-toggle="wizard-checkbox">
                                                            <input type="checkbox" name="jobb" value="Design">
                                                            <div class="card card-checkboxes card-hover-effect">
                                                                <i class="ti-paint-roller"></i>
                                                                <p>Design</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="choice" data-toggle="wizard-checkbox">
                                                            <input type="checkbox" name="jobb" value="Code">
                                                            <div class="card card-checkboxes card-hover-effect">
                                                                <i class="ti-pencil-alt"></i>
                                                                <p>Code</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="choice" data-toggle="wizard-checkbox">
                                                            <input type="checkbox" name="jobb" value="Develop">
                                                            <div class="card card-checkboxes card-hover-effect">
                                                                <i class="ti-star"></i>
                                                                <p>Develop</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="address">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h5 class="info-text"> Are you living in a nice area? </h5>
                                                </div>
                                                <div class="col-sm-7 col-sm-offset-1">
                                                    <div class="form-group">
                                                        <label>Street Name</label>
                                                        <input type="text" class="form-control" placeholder="5h Avenue">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Street Number</label>
                                                        <input type="text" class="form-control" placeholder="242">
                                                    </div>
                                                </div>
                                                <div class="col-sm-5 col-sm-offset-1">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input type="text" class="form-control" placeholder="New York...">
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label>Country</label><br>
                                                        <select name="country" class="form-control">
                                                            <option value="Afghanistan"> Afghanistan </option>
                                                            <option value="Albania"> Albania </option>
                                                            <option value="Algeria"> Algeria </option>
                                                            <option value="American Samoa"> American Samoa </option>
                                                            <option value="Andorra"> Andorra </option>
                                                            <option value="Angola"> Angola </option>
                                                            <option value="Anguilla"> Anguilla </option>
                                                            <option value="Antarctica"> Antarctica </option>
                                                            <option value="...">...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="pull-right">
                                            <input type='button' class='btn btn-next btn-fill btn-warning btn-wd' name='next' value='Next' />
                                            <input type='button' class='btn btn-finish btn-fill btn-warning btn-wd' name='finish' value='Finish' />
                                        </div>
    
                                        <div class="pull-left">
                                            <input type='button' class='btn btn-previous btn-default btn-wd' name='previous' value='Previous' />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- wizard container -->
                    </div>
                </div><!-- end row -->
            </div> <!--  big container -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
 
@endsection