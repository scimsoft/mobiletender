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


                        </tbody>
                    </table>


                    <div id="paypal-button-container"></div>



                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')

        <script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.client_id') }}&currency=EUR"></script>

    <script>
        jQuery(document).ready(function () {





        })

        paypal.Buttons({
            createOrder: function (data, actions) {
                jQuery('#overlay').fadeIn();
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
                @if(config('customoptions.clean_table_after_order'))
                        window.location.href = "/checkout/printOrderOnline/{{Session::get('ticketID')}}";
                @else
                    window.location.href = "/checkout/printOrderPagado/{{Session::get('ticketID')}}";
                    @endif
                });
            },
            onCancel: function (data, actions) {
                jQuery('#overlay').fadeOut();
            }

        }).render('#paypal-button-container');


    </script>



@stop