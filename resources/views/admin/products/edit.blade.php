@extends('layouts.reg')

@section('content')
    <div id="app">
        <div class="container">
            <div class="row justify-content-center">

                <div class="card">


                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {{--{{dd($products)}}--}}


                    </div>
                </div>


            </div>
            <div class="card text-center">
                <div id="ProductName" class="card-header">Product</div>

                <div class="card-body text-center">

                    <form action="{{ route('products.update',$product->id) }}" method="POST"
                          class="form-inline justify-content-center">

                        @method('PATCH')
                        @csrf


                        <table class="table-borderless">
                            <tr>
                                <td colspan="2">
                                    <label for="name" class="form-label"><b>Nombre</b></label>
                                    <input name="name" class="form-control" type="text" value="{{$product->name}}">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="1">
                                    <img src="data:image/png;base64,{{$product->image}}">
                                </td>
                                <td>
                                    <a href="/crop-image/{{$product->id}}" class="btn btn-tab">
                                        Imagen
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>

                                <td>
                                    <label for="category" class="label label-default"><b>Categoria</b> </label>
                                    <select name="category" class="form-control">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{ ( $category->id == $product->category) ? 'selected' : '' }}>
                                                {{$category->name}}
                                            </option>

                                            @endforeach
                                    </select>
                                </td>
                                <td>
                                    <!--label for="taxcat" class="form-label"><b>Tipo de IVA</b></label-->
                                    <input name="taxcat" class="form-control" type="hidden" value="001">

                                </td>
                            </tr><tr>
                                <td colspan="2">
                                    <label for="printto" class="form-label"><b>Printer</b></label>
                                    <input name="printto" class="form-control" type="text"
                                           value="{{$product->printto ?? '1'}} ">

                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <!--label for="reference" class="label label-default"><b>Referencia</b> </label-->
                                    <input name="reference" class="form-control" type="hidden"
                                           value="{{$product->reference}}">
                                </td>
                                <td>
                                    <!--label for="code" class="form-label"><b>Codigo</b></label-->
                                    <input name="code" class="form-control" type="hidden"
                                           value="{{$product->code}}">

                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <label for="pricebuy" class="form-label"><b>Precio de Compra</b> </label>
                                    <input name="pricebuy" class="form-control" type="text"
                                           value="{{$product->pricebuy}}">

                                </td>
                                <td>
                                    <label for="pricesell" class="form-label"><b>Precio de Venta</b></label>
                                    <input name="pricesell" class="form-control" type="text"
                                           value="{{($product->pricesell *1.1)}}">

                                </td>
                            </tr>
                            <tr><td colspan="">
                                    <b>Seleccion de sub-productos</b>
                                </td>
                            <td><select class="custom-select" name="category_addon" id="category_addon">
                                    @foreach($categories as $categorie)
                                        <option value="{{$categorie->id}}">{{$categorie->name}}</option>

                                    @endforeach
                                </select></td></tr>
                            <tr>
                                <td colspan="1">
                                    <label for="products_list" class="form-label">Disponibles</label>
                                    <select class="custom-select" size="8" multiple="multiple" name="products_list" id="products_list">


                                    </select>

                                </td>
                                <td colspan="1">
                                    <label for="addon_products_list" class="form-label">Selecionados</label>
                                    <select class="custom-select" size="8" name="addon_products_list" id="addon_products_list">
                                        @foreach($all_adons as $all_adon)

                                            <option value="{{$all_adon->id}}">{{$all_adon->name}}</option>
                                            @endforeach

                                    </select>

                                </td>
                            </tr>
                            <!--tr>
                                <td colspan="2">
                                    <label for="description" class="form-label"><b>Dicripcion</b></label>
                                    <textarea name="description" class="form-control"
                                              rows="3">{{$product->description}}</textarea>

                                </td>
                            </tr-->


                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-tab btn-block">SAVE</button>
                                </td>
                            </tr>

                        </table>


                        <div>
                            <div class="" id="ProductPrice">
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>


@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            $('#products_list').on('change',function(){
                var selected_product = $(this).val();
                var price = prompt("Precio?", "0");
                var productID = $(this).find(":selected").val();
                var addOnProductID = $(this).find(":selected").text();
                $("#addon_products_list").append($('<option>', {value: productID, text: addOnProductID}));
                addOnProduct(productID,price)
            })
            $('#addon_products_list').on('change',function(){
                var selected_product = $(this).val();
                var productID = $(this).find(":selected").val();
                var addOnProductID = $(this).find(":selected").text();
                $(this).find(":selected").remove();
                removeaddOnProduct(productID)
            })

            $('#category_addon').on('change',function(){
                var categoryid=$(this).find(":selected").val();
                jQuery.ajax({
                    url: '/products/list/'+categoryid,
                    type: "GET",

                    dataType: "json",
                    success: function (data) {

                        var $el = $("#products_list");
                        $el.empty(); // remove old options
                        $.each(data,function(id,name){

                            $el.append($("<option></option>")
                                .attr("value", name.id).text(name.name));

                        })


                    }
                });

            })

        })

        function addOnProduct(addOnProductID,price){
            jQuery.ajax({
                url: '/addOnProduct/add',
                type: "POST",
                data: { product_id:'{{$product->id}}', adon_product_id:addOnProductID ,price:price},
                dataType: "json",
                success: function (data) {


                }
            });
        }

        function removeaddOnProduct(addOnProductID){
            jQuery.ajax({
                url: '/addOnProduct/remove',
                type: "POST",
                data: { product_id:'{{$product->id}}', adon_product_id:addOnProductID },
                dataType: "json",
                success: function (data) {


                }
            });
        }

    </script>



@stop