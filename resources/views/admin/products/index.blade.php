@extends('layouts.reg')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>&nbsp;</h2>
            </div>

        </div>
    </div>
    <div class="card-body text-center">

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
        <a id="drinks-button" href="/order/category/DRINKS" type="button"
           class="btn btn-labeled btn-tab mr-1 mb-1">
            <span class="btn-label"><i class="fa fa-beer"></i></span>&nbsp; Refrescos</a>

        <a id="coffee-button" href="/order/category/VINOS" type="button"
           class="btn btn-labeled btn-tab mr-1 mb-1">
            <span class="btn-label"><i class="fa fa-flask"></i></span>&nbsp; Bebidas Alcoholicas</a>

        <a id="coffee-button" href="/order/category/COCTELES" type="button"
           class="btn btn-labeled btn-tab mr-1 mb-1">
            <span class="btn-label"><i class="fa fa-glass"></i></span> Tés Frios</a>


        <a id="coffee-button" href="/order/category/COFFEE" type="button"
           class="btn btn-labeled btn-tab mr-1 mb-1">
            <span class="btn-label"><i class="fa fa-coffee"></i></span>&nbsp; Bebidas Calientes</a>



        <a id="coffee-button" href="/order/category/COPAS" type="button"
           class="btn btn-labeled btn-tab mr-1 mb-1">
            <span class="btn-label"><i class="fa fa-bolt"></i></span>&nbsp; Copas</a>



        <a id="food-button" href="/order/category/FOOD" type="button"
           class="btn btn-labeled btn-tab mr-1 mb-1">
            <span class="btn-label"><i class="fa fa-cutlery"></i></span>&nbspPara Picar</a>

        <a id="coffee-button" href="/order/category/OTROS" type="button"
           class="btn btn-labeled btn-tab mr-1 mb-1">
            <span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp; Licores</a>
        <div class="float-right">
            <a class="btn btn-tab" href="{{ route('products.create') }}"> Producto Nuevo</a>
        </div>
    <table class="table table-bordered">
        <tr>
            <th>Vis.</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Venta</th>
            <th width="280px">Acción</th>
        </tr>
        @foreach ($products as $product)

            <tr id="{{$product->id}}">
                <td><input type="checkbox" class="form-check" name=="catalogcheckbox" @if($product->product_cat) checked="checked" @endif></td>
                <td><img src="/dbimage/{{$product->id}}.png" class="img-fluid" style="max-width: 32px"></td>
                <td>{{ $product->name }}</td>
                <td>@money($product->pricesell *1.1)</td>
                <td>
                    <form action="{{ route('products.destroy',$product->id) }}" method="POST">


                        <a class="btn btn-tab" href="{{ route('products.edit',$product->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-tab">Borrar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $products->links() }}
    </div>
@endsection

@section('scripts')
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script>
        jQuery(document).ready(function () {

            $("input:checkbox").change(function() {
                jQuery('#overlay').show();
                var product_id = $(this).closest('tr').attr('id');

                $.ajax({
                    type:'POST',
                    url:'/products/catalog',
                    data: { "product_id" : product_id },
                    success: function(data){
                        jQuery('#overlay').fadeOut();

                    }
                });
            });
        });

    </script>



@stop