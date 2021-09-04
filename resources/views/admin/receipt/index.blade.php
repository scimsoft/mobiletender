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
            <th>Fecha</th>
            <th>Persona</th>
            <th>Tipo</th>
            <th>Cantidad</th>
            <th width="280px">Acción</th>
        </tr>
        @foreach ($receipts as $receipt)

            <tr id="{{$receipt->id}}">
                <td>{{$receipt->datenew}}</td>
                <td>{{$receipt->person}}</td>
                <td><select name="category" class="form-control">
                        <option value="cash" {{ ( $receipt->payment == "cash") ? 'selected' : '' }}>cash</option>
                        <option value="tarjeta" {{ ( $receipt->payment == "tarjeta") ? 'selected' : '' }}>tarjeta</option>
                        <option value="online" {{ ( $receipt->payment == "online") ? 'selected' : '' }}>online</option>

                    </select>

                <td>@money($receipt->total)</td>
                <td>
                    <a href="/editreceipt/{{$receipt->id}}" class="btn btn-primary">Edit</a>
                <a href="/deletereceipt/{{$receipt->id}}" class="btn btn-danger">Borrar</a>
                </td>
            </tr>
        @endforeach
    </table>


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
            $('select').on('change', function() {
                jQuery('#overlay').show();
                var paymenttype = this.value;
                var receipt = $(this).closest('tr').attr('id');
                $.ajax({
                    type:'POST',
                    url:'/changereceiptpaymenttype',
                    data: {
                        "ticket_id" :  receipt,
                        "paymenttype" : this.value
                    },
                    success: function(data){

                        jQuery('#overlay').fadeOut();

                    }
                });
            });
        });

    </script>



@stop