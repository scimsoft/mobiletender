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
                       <td colspan="4">&nbsp;</td>
                   </tr>
                   <tr>
                       <td colspan="">Base</td>
                       <td colspan="">IVA</td>
                       <td colspan=""></td>
                       <td colspan="">Total</td>
                   </tr>
                    <tr>
                        <td>@money($totalBasketPrice)</td>
                        <td>@money($totalBasketPrice*0.1)</td>

                        <td></td>
                        <td>&nbsp;<b>@money($totalBasketPrice*1.1)</b></td>


                    </tr>
                   <tr>
                       <td colspan="4">&nbsp;</td>
                   </tr>
                   @if(!Session::get('tableNumber'))
                    <tr>
                        <td colspan="4"><a href="" class="btn btn-mobilepos btn-block">Para llevar</a> </td>
                    </tr>

                   <tr>
                       <td colspan="4"><button class="btn btn-mobilepos btn-block eatInButton" >Para tomar aqui</button> </td>
                   </tr>
                   <tr>

                       <td colspan="4" id="eatinrow" style=""> Introducir tu numero de mesa:<br>
                           <input type="text" id="table_number" size="3"><br><br>
                           <a  class="btn btn-primary btn-block" id="sendTableNumber">send</a>
                       </td>

                   </tr>

                   <tr>
                       <td colspan="4"><a href="" class="btn btn-mobilepos btn-block">Para llevar a su domicilio</a> </td>
                   </tr>
                       @else
                       <tr>
                           <td colspan="4"><a href="" class="btn btn-mobilepos btn-block">Añadir</a> </td>
                       </tr>
                       @endif

                    </tbody>
                </table>



            </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
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
                $('#sendTableNumber').attr('href', "/checkout/setTableNumber/"+$('#table_number').val());
            })




        })


    </script>



@stop