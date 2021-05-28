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
            <table class="table table-bordered">
                <tr>
                    <th>Active</th>
                    <th>Padre</th>
                    <th>Nombre</th>
                    <th>Orden</th>
                    <th>Guardar</th>
                    <th>Borrar</th>

                </tr>
        @foreach($categories as $category)
                    <tr id="{{$category->id}}">
                        <td><input type="checkbox" class="form-check" name="catalogcheckbox" @if($category->catshowname) checked="checked" @endif></td>
                    <td>
                        <select name="category" class="form-control">
                            <option value="">&nbsp;</option>
                        @foreach($categories as $subcategory)
                            <option value="{{$subcategory->id}}" {{ ( $subcategory->id == $category->parentid) ? 'selected' : '' }}>
                                {{$subcategory->name}}
                            </option>

                        @endforeach
                        </select>
                    </td>
                        <form action="{{ route('categories.destroy',$category->id) }}" method="POST">

                            @csrf
                            @method('PATCH')
                    <td><input type="hidden" name="id" value="{{$category->id}}"><input type="text" name="name" value="{{ $category->name }}"></td>
                    <td><input type="text" name="catorder" value="{{ $category->catorder }}" size="2"></td>
                    <td> <button type="submit" class="btn btn-tab">Guardar</button></td>
                        </form>
                        <td>

                            <form action="{{ route('categories.destroy',$category->id) }}" method="POST">

                                   @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-tab">Borrar</button>
                            </form>
                        </td>
                    </tr>
            @endforeach
                <tr>
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                    <td><input name="catshowname" type="checkbox" checked="checked"></td>
                    <td>
                        <select name="parentid" class="form-control">
                            <option value="">&nbsp;</option>
                            @foreach($categories as $subcategory)
                                <option value="{{$subcategory->id}}" }}>
                                    {{$subcategory->name}}
                                </option>

                            @endforeach
                        </select>
                    </td>



                        <td><input type="text" name="name" value=""></td>
                        <td><input type="text" name="catorder" value="" size="2"></td>
                        <td> <button type="submit" class="btn btn-tab">Guardar</button></td>
                    </form>
                    <td>

                        &nbsp;
                    </td>
                </tr>
            </table>
    </div>
@section('scripts')
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script>
        jQuery(document).ready(function () {

            $("input:checkbox").change(function() {
                jQuery('#overlay').show();
                var category_id = $(this).closest('tr').attr('id');

                $.ajax({
                    type:'POST',
                    url:'/categories/toggleactive',
                    data: { "category_id" : category_id },
                    success: function(data){
                        jQuery('#overlay').fadeOut();

                    }
                });
            });
        });

    </script>


@stop