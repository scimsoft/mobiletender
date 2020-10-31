@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header"><b>Pedido</b></div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif



                <table id="products-table" class="table table-striped middleTable">
                    <thead class="position-sticky">
                    <tr>
                    <td colspan="2"><a href="/order/" class="btn btn-normal m-1">Añadir</a></td>
                    <td colspan="2"><button disabled="true" class="btn btn-tab m-1" id="doCheckout">Pedir</button></td>
                    </tr>
                    <tr>
                       <td colspan="2">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>

                    </thead>
                    <tbody class="t-5">
                    <tr>
                        <td></td>
                        <td><b>TOTAL</b></td>

                        <td><b>@money($totalBasketPrice*1.1)</b></td>
                        <td>&nbsp;</td>


                    </tr>
                    @foreach($lines as $line)


                        @if($line->productid)
                        <tr class="productrow">
                            <td>
                                <img src="/dbimage/{{$line->productid}}.png" class="img-fluid" id="product_image" style="max-width: 32px"></td>

                            <td class="" >{{$line->attributes->product->name }}</td>
                            <td class="nowrapcol"><b>@money($line->price *1.1)</b></td>
                            <td>



                                @if($line->attributes->updated)
                                    <a href="/order/cancelproduct/{{$line->m_iLine}}"  class="btn btn-tab add-to-cart btn-add" type="submit">Cancelar</a>
                                    <script>$('#doCheckout').prop("disabled",false);</script>
                                @else
                                    <button disabled="true" class="btn btn-primary add-to-cart btn-tab " type="submit">Enviado</button>
                                @endif
                            </td>
                        </tr>

                        @endif
                    @endforeach
                    <tr>
                        <td></td>
                        <td><b>TOTAL</b></td>

                        <td><b>@money($totalBasketPrice*1.1)</b></td>
                        <td>&nbsp;</td>


                    </tr>

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
            $('#doCheckout').on('click', function () {
                window.location.href ="/checkout/";

            });
        })


    </script>



@stop