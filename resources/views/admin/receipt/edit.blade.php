@extends('layouts.reg')

@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div class="card-header text-center"><h4>Ticket NR: {{$ticketNumber}}</h4></div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div>
                        <a href="/receipts" class="btn btn-primary">Volver</a>

                    </div>

                   <br>
                    <table id="products-table" class="table middleTable">
                        <thead class="position-sticky">
                        <tr><td>Pay
                            </td>
                            <td > Product
                            </td>
                            <td>
                                Price
                            </td>

                            <td>
                                Action
                            </td>



                        </tr>

                        </thead>
                        <tbody class="">


                            @foreach($receiptlines as $receiptline)



                                    <tr class="productrow">

                                        <td>
                                            <img src="/dbimage/{{$receiptline->productid}}.png" class="img-fluid"
                                                 id="product_image" style="max-width: 32px"></td>

                                        <td class="">{{$receiptline->productname }}</td>
                                        <td class="nowrapcol amount"><b>@money($receiptline->price *1.1)</b></td>

                                        <td>@if(count($receiptlines)>1)
                                                <a href="/deletereceiptline/{{$receiptline->id}}/{{$receiptline->line}}"
                                                   class="btn btn-tab add-to-cart btn-add" type="submit">Borrar</a>
                                                @endif

                                        </td>
                                    </tr>


                            @endforeach







                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endsection
        @section('scripts')
            <script>

                jQuery(document).ready(function () {

                })



            </script>



@stop