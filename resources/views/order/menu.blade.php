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

                        @for ($i = 0; $i < 6; $i++)
                            <a href="/menu/category/{{$categories[$i]->id}}" class="btn btn-secondary m1-2">{{$categories[$i]->name}}</a>
                        @endfor
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle m-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Otros
                            </button>

                            <div class="dropdown-menu">
                                @for ($i = 6; $i < count($categories); $i++)
                                    <a href="/menu/category/{{$categories[$i]->id}}" class="dropdown-item" href="#">{{$categories[$i]->name}}</a>
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
