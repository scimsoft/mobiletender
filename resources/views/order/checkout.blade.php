@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header"><b>&nbsp;</b></div>
                <div class="card-header">
                    <center><b>Pedido</b></center>

                </div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <table id="products-table" class="table ">
                        <thead>


                        </thead>
                        <tbody>

                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="">&nbsp;</td>
                            <td colspan="">Base</td>
                            <td colspan="">IVA</td>
                            <td colspan=""></td>
                            <td colspan="">Total</td>
                        </tr>
                        <tr>
                            <td colspan="">TOTAL</td>
                            <td>@money($totalBasketPrice)</td>
                            <td>@money($totalBasketPrice*0.1)</td>

                            <td></td>
                            <td>@money($totalBasketPrice*1.1)</td>
                        </tr>
                        <tr>
                            <td colspan=""><b>A Pedir</b></td>
                            <td>@money($newLinesPrice)</td>
                            <td>@money($newLinesPrice*0.1)</td>

                            <td></td>
                            <td>&nbsp;<b>@money($newLinesPrice*1.1)</b></td>


                        </tr>

                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        {{--
                        Si tiene numero de mesa puede ser:
                        1. de prepago
                        2. a cuenta
                        --}}


                        @if(Session::get('tableNumber'))
                            @if(config('customoptions.clean_table_after_order'))
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



                            {{--<tr>

                                <td colspan="5" id="eatinrow" style=""> Introducir tu numero de mesa:<br>
                                    <select class="form-control" id="table_number">
                                        <option value="0">Tu numero de mesa</option>
                                        @foreach($tablenames as $table)
                                            <option value="{{$table->id}}">{{$table->name}}</option>
                                        @endforeach

                                    </select>
                                    <br>
                                    <a class="btn btn-tab btn-block" id="sendTableNumber">Confirmar</a>

                                </td>


                            </tr>--}}


                            @if(config('customoptions.delivery'))
                                <tr>
                                    <td colspan="5"><a href="" class="btn btn-mobilepos btn-block">Para entregar </a></td>
                                </tr>
                            @endif
                        @endif

                        </tbody>
                    </table>


                    <div id="paypal-button-container"></div>
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
                        <div id="div-takeaway" style="display:none">
                            <tr>
                                <td colspan="5">
                                    Horario de recogido:<br>
                                    12:00 hasta las 20:00


                                </td>
                            </tr>
                        </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @if(config('customoptions.eatin_prepay') OR config('customoptions.takeaway_prepay') OR config('customoptions.delivery_prepay'))

        <script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.client_id') }}&currency=EUR"></script>
    @endif
    <script>
        jQuery(document).ready(function () {


            $('.add-to-cart').on('click', function () {
                jQuery('#overlay').show();
            });
            $('.eatInButton').on('click', function () {
                jQuery('#eatinrow').slideToggle('slow');
            })

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
            $('#takeaway').on('click', function(){
                $('#div-takeaway').slideToggle('slow');
                window.location.href = "/checkout/pickup";
            })


            $('#paypal-button-container').hide();


        })
        @if(config('customoptions.eatin_prepay') OR config('customoptions.takeaway_prepay') OR config('customoptions.delivery_prepay'))

        paypal.Buttons({
            createOrder: function (data, actions) {

                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{round($newLinesPrice*1.1,2)}}'
                        }
                    }]
                })
            },
            onApprove: function (data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function (details) {
                    // This function shows a transaction success message to your buyer.
                    jQuery('#overlay').fadeOut();
                    @if(Session::get('tableNumber'))
                        window.location.href = "/checkout/printOrder/{{Session::get('ticketID')}}";
                    @else
                        window.location.href = "/checkout/confirmForTable/" + $('#table_number').val();
                    @endif
                });
            },
            onCancel: function (data, actions) {
                jQuery('#overlay').fadeOut();
            }

        }).render('#paypal-button-container');
@endif

    </script>



@stop