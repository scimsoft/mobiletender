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

                        <div>&nbsp;</div>
                        <table class="table">
                            @if(Auth::user()->isEmployee())
                                <tr>
                                    <td>
                                        <a href="/timereport" class="btn btn-primary"> Marcar Entradad o Salida</a> <br>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Checkin o Checkout</td>
                                </tr>
                            @endif
                            @if(Auth::user()->isWaiter())
                                <tr>
                                    <td>
                                        <a href="/selecttable" class="btn btn-primary"> Seleccionar mesa</a> <br>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Seleccionar una mesa para atender</td>
                                </tr>
                            @endif
                            @if(Auth::user()->isManager())
                                <tr><td colspan="3">MESAS y PRODUCTOS</td></tr>

                                <tr>
                                    <td><a href="/openorders" class="btn btn-primary"> Mesas y Pedidos</a><br></td>
                                    <td>&nbsp;</td>
                                    <td>Ver una listado de mesas abiertas</td>
                                </tr>
                                <tr>
                                    <td><a href="/products" class="btn btn-primary"> Products</a> <br>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Habilitar y editar productos</td>
                                </tr>
                                    <tr>
                                        <td><a href="/stockindex" class="btn btn-primary">Stock </a> <br>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>Gestion de Stock</td>
                                    </tr>

                            @endif
                            @if(Auth::user()->isFinance())
                                    <tr><td colspan="3">CAJA</td></tr>
                                <tr>
                                    <td><a href="paypanel" class="btn btn-primary">Cobrar</a></td>
                                    <td></td>
                                    <td>Cobrar mesas</td>
                                </tr>
                                <tr>
                                    <td><a href="movements" class="btn btn-primary">Movimientos</a></td>
                                    <td></td>
                                    <td>Entradas y Salidas de la caja</td>
                                </tr>
                                <tr>
                                    <td><a href="closecash" class="btn btn-primary">Cerrar caja</a></td>
                                    <td></td>
                                    <td>Cerrar la Caja</td>
                                </tr>
                            @endif
                            @if(Auth::user()->isAdmin())
                                    <tr><td colspan="3">ADMIN</td></tr>
                                <tr>
                                    <td>


                                        <a href="/categories" class="btn btn-primary"> Categorias (Botones)</a> <br>

                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Habilitar y editar Categorias</td>
                                </tr>


                                <tr>
                                    <td>
                                        <a href="/showusers" class="btn btn-primary"> Usuarios</a><br>
                                        {{--<a href="/cleanhome" class="btn btn-primary"> Mesas</a>--}}
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Habilitar y editar Usuarios</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="/appconfig" class="btn btn-primary"> Demo config</a><br>
                                        {{--<a href="/cleanhome" class="btn btn-primary"> Mesas</a>--}}
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>Editar Config</td>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        jQuery(document).ready(function () {


        });

    </script>



@stop