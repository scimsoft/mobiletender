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
                    <td colspan="2"><a href="/order/" class="btn btn-warning m-1">Seguir comprando</a></td>
                    <td colspan="2"><a href="/checkout/" class="btn btn-success m-1">Tramitar Pedido</a></td>
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

                            <td class="" >{{$line->attributes->{'product.name'} }}</td>
                            <td class="nowrapcol"><b>@money($line->price *1.1)</b></td>
                            <td>
                                <a href="/order/cancelproduct/{{$line->m_iLine}}"  class="btn btn-primary add-to-cart btn-add" type="submit">Cancelar</a>
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

            $('.add-to-cart').on('click', function () {
                jQuery('#overlay').show();

            });
        })


    </script>



@stop