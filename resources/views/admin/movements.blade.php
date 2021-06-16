@extends('layouts.reg')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <br><br>
                <div class="card-header col-centered"><h2 class="display-4"> Movimientos de Caja</h2></div>

                <div class="card-body">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <table class="table table-light">
                        <tr>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Descripcion</th>




                        </tr>
                        @foreach($movements as $movement)
                            <tr>
                                <td>{{$movement->payment}}</td>
                                <td>{{$movement->total}}</td>
                                <td>{{$movement->notes}}</td>

                            </tr>
                        @endforeach
                        <form action="{{ route('addmovement') }}" method="POST">
                            @csrf
                            <tr>
                                <td><select name="payment">
                                        <option value="cashin">Entrada</option>
                                        <option value="cashout">Salida</option>
                                    </select>
                                </td>
                                <td><input type="text" size="3" name="total"></td>
                                <td><input type="text" name="notes"  value=""></td>



                            </tr>
                            <tr><td colspan="3">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </td></tr>
                        </form>
                    </table>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script>
        jQuery(document).ready(function () {

            $("input:checkbox").change(function () {
                jQuery('#overlay').show();
                var category_id = $(this).closest('tr').attr('id');

                $.ajax({
                    type: 'POST',
                    url: '/categories/toggleactive',
                    data: {"category_id": category_id},
                    success: function (data) {
                        jQuery('#overlay').fadeOut();

                    }
                });
            });
        });

    </script>


@stop