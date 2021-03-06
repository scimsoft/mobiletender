@extends('layouts.reg')

@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div class="card-header text-center"><h4>Cuenta mesa {{$tableId}}</h4></div>

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

                        <div>
                            <a href="javascript:history.back()" class="btn btn-primary">Volver</a>
                            <a href="/movefrom/{{$tableId}}" class="btn btn-primary">Mover</a>
                        </div>

<!--a href="/order/table/{{$tableId}}" target="_blank" class="btn btn-primary">Añadir prodcutos</a-->
<br>
                <table id="products-table" class="table middleTable">
                    <thead class="position-sticky">



                    </thead>
                    <tbody class="">

                    @foreach($lines as $line)


                        @if($line->productid)
                        <tr class="productrow">
                            <td>
                                <img src="/dbimage/{{$line->productid}}.png" class="img-fluid" id="product_image" style="max-width: 32px"></td>

                            <td class="" >{{$line->attributes->product->name }}</td>
                            <td class="nowrapcol"><b>@money($line->price *1.1)</b></td>
                            <td>@if($line->attributes->updated == "true" )

                                   @else
                                    <img src="/img/printer-icon.png" width="24">
                                @endif
                            </td>
                            <td>


                                @if($line->attributes->updated == "true" OR (Auth::user() and Auth::user()->isManager()))
                                    <a href="/order/admincancelproduct/{{$line->m_iLine}}"  class="btn btn-tab add-to-cart btn-add" type="submit">Cancelar</a>

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
                        <td>&nbsp;</td>



                    </tr>
                    @if($totalBasketPrice > 0)
                    <tr>
                        <td colspan="5">
                            <a href="/checkout/printOrderTicket/{{$tableId}}" class="btn btn-primary btn-block" id="pagarEfectivo">
                               TICKET
                            </a>
                        </td>
                    </tr>
                    <tr>

                            <tr>
                                <td colspan="5">
                                    <a href="/payed/{{$tableId}}/cash" class="btn btn-success btn-block" id="pagarEfectivo">
                                        Cobrar en efectivo
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <a href="/payed/{{$tableId}}/tarjeta" class="btn btn-success btn-block" id="pagarTarjeta">
                                        Cobrar con tarjeta
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <a href="/payed/{{$tableId}}/bank" class="btn btn-success btn-block" id="pagarOnline">
                                        Cobrar online
                                    </a>
                                </td>
                            </tr>
@endif




                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        jQuery(document).ready(function () {


        })


    </script>



@stop