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

                    <a id="drinks-button" href="/order/category/DRINKS" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
                        <span class="btn-label"><i class="fa fa-beer"></i></span>&nbsp; Bebidas</a>

                    <a id="food-button" href="/order/category/FOOD" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
                        <span class="btn-label"><i class="fa fa-cutlery"></i></span>&nbsp; Comidas</a>

                    <a id="coffee-button" href="/order/category/COFFEE" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
                        <span class="btn-label"><i class="fa fa-coffee"></i></span>&nbsp; Cafes</a>

                    <a id="coffee-button" href="/order/category/COCTELES" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
                        <span class="btn-label"><i class="fa fa-glass"></i></span>&nbsp; Cocteles</a>

                    <a id="coffee-button" href="/order/category/COPAS" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
                        <span class="btn-label"><i class="fa fa-bolt"></i></span>&nbsp; Copas</a>

                    <a id="coffee-button" href="/order/category/VINOS" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
                        <span class="btn-label"><i class="fa fa-flask"></i></span>&nbsp; Vinos</a>

                    <a id="coffee-button" href="/order/category/OTROS" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
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

                                <tr class="productrow">
                                    <td rowspan="2">
                                        <img src="/dbimage/{{$product->id}}.png" class="img-fluid" id="product_image"
                                             onclick="addProduct('{{$product->id}}')"></td>

                                    <td class="align-middle" colspan="2"><h5>{{$product->name}}</h5></td>

                                <tr class="no-line">
                                    <td class="nowrapcol align-middle"><b>@money($product->pricesell *1.1)</b></td>

                                    <td class="align-middle">
                                        <button class="btn btn-tab add-to-cart btn-add"
                                                onclick="addProduct('{{$product->id}}')" type="submit">Añadir
                                        </button>
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


    <div class="modal fade" id="selectAddOnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Con</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select name="addOnProduct" id="addOnProductSelect" class="custom-select">

                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-tab" data-dismiss="modal">Nada</button>
                    <button type="button" class="btn btn-tab" id="addAdonProductButton">Añadir</button>
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
                    moveImage(imgtodrag, cart);
                    jQuery('#overlay').fadeOut();
                }

            });

            $('.img-fluid').on('click', function () {
                jQuery('#overlay').show();
                var cart = $('.fa-shopping-cart');
                var imgtodrag = $(this).closest('.productrow').find('.img-fluid');

                if (imgtodrag) {
                    moveImage(imgtodrag, cart);
                    jQuery('#overlay').fadeOut();
                }

            });

            $('#addAdonProductButton').on('click', function(){
                var selected = $('#addOnProductSelect').val();
                $result_explode =selected.split("|");
                var product_id = $result_explode[0];
                var price = $result_explode[1];
                addOnProduct(product_id,price);

            })


        })

        function addProduct(productID) {
            jQuery.ajax({
                url: '/order/addproduct/' + productID,
                type: "GET",
                dataType: "json",
                success: function (data) {

                    var adonnproducts = JSON.parse(data[1])

                    if (adonnproducts.length > 0) {
                        $('#selectAddOnModal').modal("show");

                        $.each(adonnproducts, function (index, value) {
                            var optionvalue =  Math.round(value[2],2)+ '€'+" __    "+value[1] ;

                            $("#addOnProductSelect").append($('<option>', {
                                value: value[0]+"|" + value[2],
                                 text: optionvalue
                            }));
                        });
                    }
                    orderTotalBasket = (data[0] * 1.1).toFixed(2) + "€";
                    $('#ordertotal').html('<span class="btn-label"><i class="fa fa-shopping-cart"></i></span>&nbsp;' + orderTotalBasket);
                }
            });
        }
        //TODO TODO
        // Tengo que mandar el producto y el precio
        function addOnProduct(addOnProductID,price) {
            jQuery.ajax({
                url: '/order/addAddonProduct/',
                type: "POST",
                data: {product_id: addOnProductID, price: price},
                dataType: "json",
                success: function (data) {

                    $('#selectAddOnModal').modal("hide");
                }
            });
        }


    </script>



@stop