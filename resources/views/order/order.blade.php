@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header">Order</div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <a id="drinks-button" href="/order/category/DRINKS" type="button" class="btn btn-labeled btn-tab mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-beer"></i></span>&nbsp; Bebidas</a>

                        <a id="food-button" href="/order/category/FOOD" type="button" class="btn btn-labeled btn-tab mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-cutlery"></i></span>&nbsp; Comidas</a>

                        <a id="coffee-button" href="/order/category/COFFEE" type="button" class="btn btn-labeled btn-tab mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-coffee"></i></span>&nbsp; Cafes</a>

                        <a id="coffee-button" href="/order/category/COCTELES" type="button" class="btn btn-labeled btn-tab mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-glass"></i></span>&nbsp; Cocteles</a>

                        <a id="coffee-button" href="/order/category/COPAS" type="button" class="btn btn-labeled btn-tab mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-bolt"></i></span>&nbsp; Copas</a>

                        <a id="coffee-button" href="/order/category/VINOS" type="button" class="btn btn-labeled btn-tab mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-flask"></i></span>&nbsp; Vinos</a>

                        <a id="coffee-button" href="/order/category/OTROS" type="button" class="btn btn-labeled btn-tab mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp; Otros</a>


                <table id="products-table" class="table middleTable">
                    <thead>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>

                        <td>&nbsp;</td>
                        <td>&nbsp;</td>


                    </tr>
                    </thead>
                    <tbody>
                                       
                    @foreach($products as $product)
                        @if($product->product_cat)

                        <tr class="productrow" >
                            <td rowspan="2">
                                <img src="/dbimage/{{$product->id}}.png" class="img-fluid" id="product_image" onclick="window.addProduct('{{$product->id}}')"></td>

                            <td class="align-middle" colspan="2"><h3>{{$product->name}}</h3></td>

                        <tr class="no-line">
                            <td class="nowrapcol align-middle"><b>@money($product->pricesell *1.1)</b></td>

                            <td class="align-middle">
                                <button  class="btn btn-tab add-to-cart btn-add" onclick="window.addProduct('{{$product->id}}')" type="submit">Añadir</button>
                            </td>
                        </tr>

                        </tr>


                        @endif
                    @endforeach

                    </tbody>
                </table>

                {{ $products->links() }}

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
                var cart = $('.fa-shopping-cart');
                var imgtodrag = $(this).closest('tr').prev().find('.img-fluid');
                if (imgtodrag) {
                    moveImage(imgtodrag,cart);
                    jQuery('#overlay').fadeOut();
                }

            });

            $('.img-fluid').on('click', function () {
                jQuery('#overlay').show();
                var cart = $('.fa-shopping-cart');
                var imgtodrag = $(this).closest('.productrow').find('.img-fluid');

                if (imgtodrag) {
                    moveImage(imgtodrag,cart);
                    jQuery('#overlay').fadeOut();
                }

            });



        })


    </script>



@stop