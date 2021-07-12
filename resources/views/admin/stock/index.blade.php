@extends('layouts.reg')

@section('content')
    <div class="row justify-content-center">

        <div class="card">
            <div class="card-header">&nbsp;</div>
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
                        <a href="/stockindex/{{$categories[$i]->id}}" class="btn btn-secondary m1-2">{{$categories[$i]->name}}</a>
                    @endfor
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle m-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Otros
                        </button>

                        <div class="dropdown-menu">
                            @for ($i = 6; $i < count($categories); $i++)
                                <a href="/stockindex/{{$categories[$i]->id}}" class="dropdown-item" href="#">{{$categories[$i]->name}}</a>
                            @endfor
                        </div>
                    </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Product</th>
                        <th>Count</th>
                        <th>Add</th>
                        <th>Total</th>
                        <th>Acción</th>
                    </tr>
                    @foreach ($stocks as $stock)

                        <tr id="{{$stock->product}}">
                            <td>{{$stock->name}}</td>
                            <td><input type="text" size="3" name="currentunits" value="{{$stock->units}}" style="border:none" readonly></td>
                            <td><input type="text" size="3" name="newunits"></td>
                            <td></td>
                            <td><button class="btn btn-primary">Add</button> </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script>
        jQuery(document).ready(function () {

            $("button").click(function () {

                jQuery('#overlay').show();
                var product_id = $(this).closest('tr').attr('id');
                var unitstextbox = $(this).closest("tr").find('input[name=newunits]');
                var currentunitstextbox = $(this).closest("tr").find('input[name=currentunits]');
                var currentunitstextboxvalue = currentunitstextbox.val();
                var units = unitstextbox.val();


                $.ajax({
                    type: 'POST',
                    url: '/stock/add',
                    data: {
                        "product_id": product_id,
                        "units": units
                    },
                    success: function (data) {
                        jQuery('#overlay').fadeOut();
                        unitstextbox.val('');
                        currentunitstextbox.val(Number(units)+Number(currentunitstextboxvalue));

                    }
                });
            });
        });

    </script>



@stop