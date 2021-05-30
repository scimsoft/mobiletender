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
        @for ($i = 0; $i < 6; $i++)
            <a href="/products/index/{{$categories[$i]->id}}" class="btn btn-secondary m1-2">{{$categories[$i]->name}}</a>
        @endfor
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle m-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Otros
            </button>

            <div class="dropdown-menu">
                @for ($i = 6; $i < count($categories); $i++)
                    <a href="/products/index/{{$categories[$i]->id}}" class="dropdown-item" href="#">{{$categories[$i]->name}}</a>
                @endfor
            </div>
        </div>
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