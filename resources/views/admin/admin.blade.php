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
                    <div class="col-centered" > <h4 >Gestiona su local</h4></div>
                        <br>

                        <div>&nbsp;</div>
                        <table>
                            <tr><td>
                                    <a href="/selecttable" class="btn btn-primary"> Se3lecionar mesa</a> <br>
                                </td></tr>
                            <tr><td>
                            <tr><td>
                                    @if(Auth::user()->isManager())
                      <a href="/products" class="btn btn-primary"> Products</a> <br>

                                </td></tr>
                            <tr><td>
                        <a href="/openorders" class="btn btn-primary"> Mesas y Pedidos</a><br>
                                    @endif
                      @if(Auth::user()->isAdmin())
                                </td></tr>
                            <tr><td>
                                    <a href="/showusers" class="btn btn-primary"> Usuarios</a><br>
                                    {{--<a href="/cleanhome" class="btn btn-primary"> Mesas</a>--}}
                                </td></tr>
                            <tr><td>
                            <a href="/appconfig" class="btn btn-primary"> Demo config</a><br>
                            {{--<a href="/cleanhome" class="btn btn-primary"> Mesas</a>--}}
                                </td></tr>



                            @endif
                            </td></tr>
                        </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        jQuery(document).ready(function () {


        });

    </script>



@stop