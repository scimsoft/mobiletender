@extends('layouts.menu')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">


                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a id="drinks-button" href="/menu/category/DRINKS" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
                        <span class="btn-label"><i class="fa fa-beer"></i></span>&nbsp; Bebidas</a>

                    <a id="food-button" href="/menu/category/FOOD" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
                        <span class="btn-label"><i class="fa fa-cutlery"></i></span>&nbsp; Comidas</a>

                    <a id="coffee-button" href="/menu/category/COFFEE" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
                        <span class="btn-label"><i class="fa fa-coffee"></i></span>&nbsp; Cafes</a>

                    <a id="coffee-button" href="/menu/category/COCTELES" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
                        <span class="btn-label"><i class="fa fa-glass"></i></span>&nbsp; Cocteles</a>

                    <a id="coffee-button" href="/menu/category/COPAS" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
                        <span class="btn-label"><i class="fa fa-bolt"></i></span>&nbsp; Copas</a>

                    <a id="coffee-button" href="/menu/category/VINOS" type="button"
                       class="btn btn-labeled btn-tab mr-1 mb-1">
                        <span class="btn-label"><i class="fa fa-flask"></i></span>&nbsp; Vinos</a>

                    <a id="coffee-button" href="/menu/category/OTROS" type="button"
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
                                            ></td>

                                    <td class="align-middle" colspan="2"><h5>{{$product->name}}</h5></td>

                                <tr class="no-line">
                                    <td class="nowrapcol align-middle"><b>@money($product->pricesell *1.1)</b></td>

                                    <td class="align-middle">

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
                    <div class="table-responsive">
                    <table id="addOnProductsTable" class="table table-borderless">
                        <tr><td>Image</td><td>Name</td><td>Price</td></tr>
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
