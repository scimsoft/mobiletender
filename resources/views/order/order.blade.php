@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header">&nbsp;</div>

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


                    <br>
                    @for ($i = 0; $i < config('customoptions.buttons_on_page'); $i++)

                        @if(is_null($categories[$i]->parentid))
                            <a href="/order/category/{{$categories[$i]->id}}"
                               class="btn btn-secondary m-1">{{$categories[$i]->name}}</a>
                        @endif
                    @endfor
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle m-1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Otros
                        </button>

                        <div class="dropdown-menu">
                            @for ($i = config('customoptions.buttons_on_page'); $i < count($categories); $i++)
                                <a href="/order/category/{{$categories[$i]->id}}" class="dropdown-item"
                                   href="#">{{$categories[$i]->name}}</a>
                            @endfor
                        </div>
                    </div>
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
                                    <td rowspan="1">
                                        <img src="/dbimage/{{$product->id}}.png" class="img-fluid img-drag" id="product_image"
                                             onclick="addProduct('{{$product->id}}')"></td>

                                    <td class="align-middle" colspan="2"><h5>{{$product->name}}</h5></td>

                                <tr class="no-line">



                                    <td class="nowrapcol align-middle"><b>@money($product->pricesell *1.1)</b></td>
                                    <td>
                                        @if($product->product_detail)

                                            <button type="button" class="btn  btn-outline-info " data-toggle="modal"
                                                    data-target="#info{{$product->id}}">
                                                <b><i>+info</i></b>
                                            </button>
                                        @endif
                                    </td>

                                    <td class="align-middle">
                                        <button class="btn btn-tab add-to-cart btn-add"
                                                onclick="addProduct('{{$product->id}}')" type="submit">Añadir
                                        </button>
                                    </td>
                                </tr>

                                </tr>

                            @else
                                <tr class="productrow">
                                    <td rowspan="2">
                                        <img src="/dbimage/{{$product->id}}.png" class="img-fluid disabled-image"
                                             id="disbled_product_image"
                                        ></td>

                                    <td class="align-middle" colspan="2"><h5>{{$product->name}}</h5></td>

                                <tr class="no-line">
                                    <td class="nowrapcol align-middle"><b>@money($product->pricesell *1.1)</b></td>

                                    <td class="align-middle">
                                        No disponible
                                    </td>
                                </tr>

                                </tr>
                            @endif
                            @if($product->product_detail)
                                <div class="modal fade" id="info{{$product->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{$product->name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="/dbimage/{{$product->id}}.png" class="img-fluid "><br>
                                                <textarea  style="height: 150px;border: none;background-color: transparent;overflow: auto;resize: none;outline: none;min-width: 100%">{{$product->product_detail->description}}</textarea>
                                                <br>

alergenicos:
                                                @if($product->product_detail->alerg_apio)<img
                                                        src="/img/allergens/Apio.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Apio">@endif
                                                @if($product->product_detail->alerg_crustaceans)<img
                                                        src="/img/allergens/Crustaceans.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Marisco">@endif
                                                @if($product->product_detail->alerg_dairy)<img
                                                        src="/img/allergens/DairyProducts.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Lacteo">@endif
                                                @if($product->product_detail->alerg_sulphites)<img
                                                        src="/img/allergens/DioxideSulphites.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Sulphite">@endif
                                                @if($product->product_detail->alerg_gluten)<img
                                                        src="/img/allergens/Gluten.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Gluten">@endif
                                                @if($product->product_detail->alerg_lupins)<img
                                                        src="/img/allergens/Lupins.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Altramuces">@endif
                                                @if($product->product_detail->alerg_mollusks)<img
                                                        src="/img/allergens/Mollusks.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Moluscos">@endif
                                                @if($product->product_detail->alerg_egg)<img
                                                        src="/img/allergens/Egg.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Huevo">@endif
                                                @if($product->product_detail->alerg_mustard)<img
                                                        src="/img/allergens/Mustard.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Mostaza">@endif
                                                @if($product->product_detail->alerg_peanuts)<img
                                                        src="/img/allergens/Peanuts.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Cacahuete">@endif
                                                @if($product->product_detail->alerg_peelfruits)<img
                                                        src="/img/allergens/PeelFruits.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Frutos Secos">@endif
                                                @if($product->product_detail->alerg_sesame)<img
                                                        src="/img/allergens/SesameGrains.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Sesamo">@endif
                                                @if($product->product_detail->alerg_soy)<img
                                                        src="/img/allergens/Soy.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Soja">@endif
                                                @if($product->product_detail->alerg_fish)<img
                                                        src="/img/allergens/Fish.png" class="img-fluid"
                                                        width="32" data-container="body" data-toggle="popover" data-placement="top" data-content="Pescado">@endif

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                            data-dismiss="modal">Close
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"
             style="-webkit-overflow-scrolling: touch;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Con</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="addOnProductsTable" class="table table-borderless">
                            <tr id="firstaddonrow">
                                <td>Image</td>
                                <td>Name</td>
                                <td>Price</td>
                            </tr>
                        </table>
                        <div>
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


                        $('#addOnProductsTable').on('click', '.productAddonRow', function () {
                            var id = $(this).find('td:eq(0)').attr('id');
                            var price = $(this).find('td:eq(2)').attr('id');
                            console.log('id:' + id);
                            addOnProduct(id, price);

                        });

                        $('.add-to-cart').on('click', function () {
                            jQuery('#overlay').show();
                            var cart = $('.fa-shopping-cart');
                            var imgtodrag = $(this).closest('tr').prev().find('.img-fluid');
                            if (imgtodrag) {
                                moveImage(imgtodrag, cart);
                                jQuery('#overlay').fadeOut();
                            }

                        });

                        $('.img-drag').on('click', function () {
                            jQuery('#overlay').show();
                            var cart = $('.fa-shopping-cart');
                            var imgtodrag = $(this).closest('.productrow').find('.img-fluid');

                            if (imgtodrag) {
                                moveImage(imgtodrag, cart);
                                jQuery('#overlay').fadeOut();
                            }

                        });

                        $('#addAdonProductButton').on('click', function () {
                            var selected = $('#addOnProductSelect').val();
                            $result_explode = selected.split("|");
                            var product_id = $result_explode[0];
                            var price = $result_explode[1];
                            addOnProduct(product_id, price);

                        })


                    })
                    $(function () {
                        $('[data-toggle="popover"]').popover()
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
                                    $('#addOnProductsTable').empty();
                                    $('#addOnProductsTable').append("<tr><td>Image</td><td>Name</td><td>Price</td></tr>")

                                    $.each(adonnproducts, function (index, value) {
                                        var optionvalue = Math.round(value[2], 2) + '€' + " __    " + value[1];
                                        $('#addOnProductsTable tr:last').after(
                                            '<tr class="productAddonRow">' +
                                            '<td id="' + value[0] + '"><img src="/dbimage/' + value[0] + '.png" width="32px"></td>' +
                                            '<td id="' + value[1] + '">' + value[1] + '</td>' +
                                            '<td id="' + value[2] + '">' + value[2].toFixed(2) + '€</td></tr>'
                                        );

                                    });
                                }
                                orderTotalBasket = (data[0] * 1.1).toFixed(2) + "€";
                                $('#ordertotal').html('<span class="btn-label"><i class="fa fa-shopping-cart"></i></span>&nbsp;' + orderTotalBasket);
                            }
                        });
                    }
                    //TODO TODO
                    // Tengo que mandar el producto y el precio
                    function addOnProduct(addOnProductID, price) {
                        console.log('id: ' + addOnProductID + ' price:' + price);
                        jQuery.ajax({
                            url: '/order/addAddonProduct',
                            type: "POST",
                            data: {product_id: addOnProductID, price: price},
                            dataType: "json",
                            success: function (data) {

                                $('#selectAddOnModal').modal("hide");
                                orderTotalBasket = (data * 1.1).toFixed(2) + "€";

                                $('#ordertotal').html('<span class="btn-label"><i class="fa fa-shopping-cart"></i></span>&nbsp;' + orderTotalBasket);
                            }
                        });
                    }


                </script>



@stop