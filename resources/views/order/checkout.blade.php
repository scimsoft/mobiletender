@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header"><b>&nbsp;</b></div>
                <div class="card-header"><center><b>Pedido</b></center></div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif



                <table id="products-table" class="table ">
                    <thead >


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
                   @if(!Session::get('tableNumber'))
                       @if(config('customoptions.take_away'))
                    <tr>
                        <td colspan="5"><a href="" class="btn btn-mobilepos btn-block">Para llevar</a> </td>
                    </tr>
                    @endif

                   <tr>
                       <td colspan="5"><button class="btn btn-mobilepos btn-block eatInButton" >Para tomar aqui</button> </td>
                   </tr>
                   <tr>

                       <td colspan="5" id="eatinrow" style=""> Introducir tu numero de mesa:<br>
                           <select  class="form-control" id="table_number">
                               @foreach($tablenames as $table)
                                   <option value="{{$table->id}}">{{$table->name}}</option>

                                   @endforeach

                           </select>
                           <a  class="btn btn-primary btn-block" id="sendTableNumber">send</a>
                       </td>

                   </tr>
                    @if(config('customoptions.delivery'))
                   <tr>
                       <td colspan="5"><a href="" class="btn btn-mobilepos btn-block">Para llevar a su domicilio</a> </td>
                   </tr>
                        @endif
                       @else
                       <tr>
                           <td colspan="5"><button href="" class="btn btn-mobilepos btn-block" id="addToTable">Añadir</button> </td>
                       </tr>
                       @endif

                    </tbody>
                </table>



                        <div id="paypal-button-container"></div>

            </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.client_id') }}"></script>

    <script>
        jQuery(document).ready(function () {
            jQuery('#eatinrow').hide();

            $('.add-to-cart').on('click', function () {
                jQuery('#overlay').show();

            });
            $('.eatInButton').on('click',function(){
                jQuery('#eatinrow').slideToggle('slow');
            })
            $('#table_number').on("change paste keyup", function() {
                    @if(!config('customoptions.eatin_prepay'))
                    $('#sendTableNumber').attr('href', "/checkout/confirmForTable/" + $('#table_number').val());

                @endif
            })
            $('#sendTableNumber').on('click',function (){
                @if(config('customoptions.eatin_prepay'))
                    $('#paypal-button-container').slideDown();
                    @else
                        window.location.href="/checkout/printOrder/{{Session::get('ticketID')}}";
                @endif


            })
            $('#addToTable').on('click',function(){
                @if(config('customoptions.eatin_prepay'))
                    $('#paypal-button-container').slideDown();
                @endif
            })


                $('#paypal-button-container').hide();




        })
        paypal.Buttons({
            createOrder: function(data, actions) {
                jQuery('#overlay').show();
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{round($newLinesPrice*1.1,2)}}'
                        }
                    }]
                })
            },
            onApprove: function(data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function(details) {
                    // This function shows a transaction success message to your buyer.
                    jQuery('#overlay').fadeOut();
                    @if(Session::get('tableNumber'))
                    window.location.href="/checkout/printOrder/{{Session::get('ticketID')}}";
                    @else
                    window.location.href="/checkout/confirmForTable/"+$('#table_number').val();
                    @endif
                });
            }
        }).render('#paypal-button-container');




    </script>



@stop