@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div class="card-header text-center"><h4>Cuenta</h4></div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif



                <table id="products-table" class="table middleTable">
                    <thead class="position-sticky">
                    <tr>
                    <td colspan="4"><a href="/order/" class="btn btn-tab m-1">Volver</a></td>

                    </tr>


                    </thead>
                    <tbody class="t-5">

                    @foreach($lines as $line)


                        @if($line->productid)
                        <tr class="productrow">
                            <td>
                                <img src="/dbimage/{{$line->productid}}.png" class="img-fluid" id="product_image" style="max-width: 32px"></td>

                            <td class="" >{{$line->attributes->product->name }}</td>
                            <td class="nowrapcol"><b>@money($line->price *1.1)</b></td>
                            <td>


                                @if($line->attributes->updated == "true" OR (Auth::user() and Auth::user()->isAdmin()))
                                    <a href="/order/cancelproduct/{{$line->m_iLine}}"  class="btn btn-tab add-to-cart btn-add" type="submit">Cancelar</a>

                                @else
                                    <button disabled="true" class="btn btn-primary add-to-cart btn-tab " type="submit">Enviado</button>
                                @endif
                            </td>
                        </tr>

                        @endif
                    @endforeach
                    <tr class="bg-light">
                        <td></td>
                        <td><b>TOTAL</b></td>

                        <td><b>@money($totalBasketPrice*1.1)</b></td>
                        <td>&nbsp;</td>


                    </tr>
                    @if(Session::get('tableNumber'))
                        @if(config('customoptions.clean_table_after_order')OR !$unprintedlines)
                            <tr>
                                <td colspan="5">
                                    <button class="btn btn-tab btn-block" id="pagarEfectivo">
                                        Pagar en efectivo
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <button class="btn btn-tab btn-block" id="pagarTarjeta">
                                        Pagar con tarjeta
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <button class="btn btn-tab btn-block" id="pagarOnline">
                                        Pagar online
                                    </button>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="5">
                                    <button class="btn btn-tab btn-block" id="apuntarEnLaMesa">
                                        Pedir
                                    </button>
                                </td>
                            </tr>
                        @endif

                    @else
                        {{--
                    Si NO tiene numero de mesa puede ser:
                    1. Para tomar en el restaurante
                    2. para llevar
                    3. O para domicilars
                    --}}

                        <tr>
                            <td colspan="5"><button class="btn btn-mobilepos btn-block" id="eatin">Para tomarlo aqui</button></td>
                        </tr>

                        @if(config('customoptions.takeaway'))
                            <tr>
                                <td colspan="5"><button class="btn btn-mobilepos btn-block" id="takeaway">Para recoger</button></td>
                            </tr>
                        @endif
                        @if(config('customoptions.delivery'))
                            <tr>
                                <td colspan="5"><a href="" class="btn btn-mobilepos btn-block">Para entregar </a></td>
                            </tr>
                        @endif
                    @endif


                    </tbody>
                </table>

                        <div id="scan-qr-instructions" style="display:none">
                            <tr>
                                <td colspan="5">
                                    Para añadir el pedido a su mesa, <br>
                                    escanea con la camera el codgo QR <br>
                                    que tiene en su mesa.<br>
                                    <img src="/img/qr-example.png" class="flex-column">
                                </td>
                            </tr>
                        </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        jQuery(document).ready(function () {
            $('#doCheckout').on('click', function () {
                window.location.href ="/checkout/";

            });

            $('#pagarEfectivo').on('click', function () {

                window.location.href = "/checkout/printOrderEfectivo/{{Session::get('ticketID')}}";



            })
            $('#apuntarEnLaMesa').on('click', function () {

                window.location.href = "/checkout/printOrder/{{Session::get('ticketID')}}";



            })
            $('#pagarOnline').on('click', function () {
                window.location.href = "/checkout/pay";



            })
            $('#pagarTarjeta').on('click', function () {

                window.location.href = "/checkout/printOrderTarjeta/{{Session::get('ticketID')}}";

            })
            $('#eatin').on('click',function(){
                $('#scan-qr-instructions').slideToggle('slow');
            })

        })


    </script>



@stop