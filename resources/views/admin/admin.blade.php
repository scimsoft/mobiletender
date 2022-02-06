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
                        <div class="col-centered"><h4>{{__('Gestiona su local')}}</h4></div>
                        <br>

                        <div>&nbsp;</div>
                        <table class="table">
                            @if(Auth::user()->isEmployee())
                                <tr>
                                    <td>
                                        <a href="/timereport" class="btn btn-primary"> {{__('Marcar Entradad o Salida')}}</a> <br>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>{{__('Checkin o Checkout')}}</td>
                                </tr>
                            @endif
                            @if(Auth::user()->isWaiter())
                                <tr>
                                    <td>
                                        <a href="/selecttable" class="btn btn-primary">{{__(' Seleccionar mesa')}}</a> <br>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>{{__('Seleccionar una mesa para atender')}}</td>
                                </tr>
                            @endif
                            @if(Auth::user()->isManager())
                                <tr><td colspan="3">{{__('MESAS y PRODUCTOS')}}</td></tr>

                                <tr>
                                    <td><a href="/openorders" class="btn btn-primary"> {{__('Mesas y Pedidos')}}</a><br></td>
                                    <td>&nbsp;</td>
                                    <td>{{__('Ver una listado de mesas abiertas')}}</td>
                                </tr>
                                <tr>
                                    <td><a href="/products" class="btn btn-primary"> {{__('Products')}}</a> <br>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>{{__('Habilitar y editar productos')}}</td>
                                </tr>
                                    <tr>
                                        <td><a href="/stockindex" class="btn btn-primary">{{__('Stock')}} </a> <br>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>{{__('Gestion de Stock')}}</td>
                                    </tr>

                            @endif
                            @if(Auth::user()->isFinance())
                                    <tr><td colspan="3">{{__('CAJA')}}</td></tr>
                                <tr>
                                    <td><a href="paypanel" class="btn btn-primary">{{__('Cobrar')}}</a></td>
                                    <td></td>
                                    <td>{{__('Cobrar mesas')}}</td>
                                </tr>
                                <tr>
                                    <td><a href="movements" class="btn btn-primary">{{__('Movimientos')}}</a></td>
                                    <td></td>
                                    <td>{{__('Entradas y Salidas de la caja')}}</td>
                                </tr>
                                <tr>
                                    <td><a href="closecash" class="btn btn-primary">{{__('Cerrar caja')}}</a></td>
                                    <td></td>
                                    <td>{{__('Cerrar la Caja')}}</td>
                                </tr>
                            @endif
                            @if(Auth::user()->isAdmin())
                                    <tr><td colspan="3">{{ __('ADMIN') }}</td></tr>
                                <tr>
                                        <td>


                                            <a href="/receipts" class="btn btn-primary"> {{__('Tickets cobrados')}}</a> <br>

                                        </td>
                                        <td>&nbsp;</td>
                                        <td>{{__('Lista de las ultimas 50 tickets cobrados')}}</td>
                                    </tr>
                                <tr>
                                    <td>


                                        <a href="/categories" class="btn btn-primary"> {{__('Categorias (Botones)')}}</a> <br>

                                    </td>
                                    <td>&nbsp;</td>
                                    <td>{{__('Stats')}}</td>
                                </tr>
                                    <tr>
                                        <td>


                                            <a href="/stats" class="btn btn-primary"> {{__('Stats')}}</a> <br>

                                        </td>
                                        <td>&nbsp;</td>
                                        <td>{{__('Ver las estadisticas')}}</td>
                                    </tr>


                                <tr>
                                    <td>
                                        <a href="/showusers" class="btn btn-primary"> {{__('Usuarios')}}</a><br>
                                        {{--<a href="/cleanhome" class="btn btn-primary"> Mesas</a>--}}
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>{{__('Habilitar y editar Usuarios')}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="/appconfig" class="btn btn-primary"> {{__('Demo config')}}</a><br>
                                        {{--<a href="/cleanhome" class="btn btn-primary"> Mesas</a>--}}
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>{{__('Editar Config')}}</td>
                                </tr>



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

    <script>
        jQuery(document).ready(function () {


        });

    </script>



@stop