@extends('layouts.reg')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <br>
                    <div class="card-header col-centered"><h1 class="display-3"> Area Privada</h1></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="col-centered"><h4>Gestiona su local</h4></div>
                        <br>
                        <form action="/appconfig" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="form-check">
                                    <input type="checkbox" name="eatin" class="form-check-input" id="eatin"
                                           @if(config('customoptions.eatin')==1)checked @endif>
                                    <label for="eatin" class="form-check-label">Servicio de mesas</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="takeaway" id="takeaway"
                                           @if(config('customoptions.takeaway')==1)checked @endif>
                                    <label for="takeaway" class="form-check-label">Para llevar</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="eatinprepay" id="eatinprepay"
                                           @if(config('customoptions.eatin_prepay')==1)checked @endif>
                                    <label for="eatinprepay" class="form-check-label">Prepago para la mesa</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input" name="cleantableafterorder"
                                           id="cleantableafterorder"
                                           @if(config('customoptions.clean_table_after_order')==1)checked @endif>
                                    <label for="cleantableafterorder" class="form-check-label">NO dejar cuenta
                                        abierta</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-check">

                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')




@stop