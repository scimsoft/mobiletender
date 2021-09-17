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

                    <form action="{{ route('products.store') }}" method="POST"
                          class="form-inline justify-content-center">


                        @csrf


                        <table class="table-borderless">
                            <tr>
                                <td colspan="2">
                                    <label for="name" class="form-label"><b>Nombre</b></label>
                                    <input name="name" class="form-control" type="text" >

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
                                            <option value="{{$category->id}}" >
                                                {{$category->name}}
                                            </option>

                                            @endforeach
                                    </select>
                                </td>
                                <td>
                                    <label for="pricesell" class="form-label"><b>Precio Venta</b></label>
                                    <input name="pricesell" class="form-control" type="text"
                                           value="">

                                    <!--label for="taxcat" class="form-label"><b>Tax</b></label-->
                                    <input name="taxcat" class="form-control" type="hidden"
                                           value="001">

                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <!--label for="reference" class="label label-default"><b>Referencia</b> </label-->
                                    <input name="reference" class="form-control" type="hidden"
                                           value="{{random_int(100000, 9999999)}}">
                                </td>
                                <td>
                                    <!--label for="code" class="form-label"><b>Codigo</b></label-->
                                    <input name="code" class="form-control" type="hidden"
                                           value="{{random_int(100000, 9999999)}}">

                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <!--label for="pricebuy" class="form-label"><b>Precio Compra</b> </label-->
                                    <input name="pricebuy" class="form-control" type="hidden"
                                           value="1">

                                </td>
                                <td>

                                </td>
                            </tr>

                            <!--tr>
                                <td colspan="2">
                                    <label for="description" class="form-label"><b>Dicripcion</b></label>
                                    <textarea name="description" class="form-control"
                                              rows="3"></textarea>

                                </td>
                            </tr-->

                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-tab btn-block">Guardar</button>
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




@stop