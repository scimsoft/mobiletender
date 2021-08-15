@extends('layouts.reg')

@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div class="card-header text-center"><h4>Cuenta mesa {{$tableId}}</h4></div>

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
                        <a href="javascript:history.back()" class="btn btn-primary">Volver</a>
                        <a href="/movefrom/{{$tableId}}" class="btn btn-primary">Mover</a>
                    </div>

                <!--a href="/order/table/{{$tableId}}" target="_blank" class="btn btn-primary">Añadir prodcutos</a-->
                    <br>
                    <table id="products-table" class="table middleTable">
                        <thead class="position-sticky">
                        <tr><td>Pay
                            </td>
                            <td colspan="2"> Product
                            </td>
                            <td>
                                Price
                            </td>
                            <td>

                            </td>
                            <td>
                                Action
                            </td>



                        </tr>

                        </thead>
                        <tbody class="">
                        <form method="POST" action="/payed">
                            @csrf
                            <input type="hidden" name="tableId" value="{{$tableId}}">
                            @foreach($lines as $line)


                                @if($line->productid)
                                    <tr class="productrow">
                                        <td><input class="form-check-input box" type="checkbox" name="toPay[]" id="flexCheckDefault" value="{{$line->m_iLine}}" checked></td>
                                        <td>
                                            <img src="/dbimage/{{$line->productid}}.png" class="img-fluid"
                                                 id="product_image" style="max-width: 32px"></td>

                                        <td class="">{{$line->attributes->product->name }}</td>
                                        <td class="nowrapcol amount"><b>@money($line->price *1.1)</b></td>
                                        <td>@if($line->attributes->updated == "true" )

                                            @else
                                                <img src="/img/printer-icon.png" width="24">
                                            @endif
                                        </td>
                                        <td>


                                            @if($line->attributes->updated == "true" OR (Auth::user() and Auth::user()->isManager()))
                                                <a href="/order/admincancelproduct/{{$line->m_iLine}}"
                                                   class="btn btn-tab add-to-cart btn-add" type="submit">Cancelar</a>

                                            @else
                                                <button disabled="true" class="btn btn-primary add-to-cart btn-tab "
                                                        type="submit">Enviado
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                @endif
                            @endforeach
                            <tr class="bg-light">
                                <td></td>
                                <td></td>
                                <td><b>TOTAL</b></td>

                                <td><b>@money($totalBasketPrice*1.1)</b></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>


                            </tr>
                            <tr class="bg-light" id="subTotalRow">
                                <td></td>
                                <td></td>
                                <td><b>sub total</b></td>

                                <td id="subTotal"></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>


                            </tr>
                            @if($totalBasketPrice > 0)
                                <tr>
                                    <td colspan="6">
                                        <a href="/checkout/printOrderTicket/{{$tableId}}"
                                           class="btn btn-primary btn-block" id="pagarEfectivo">
                                            TICKET
                                        </a>
                                    </td>
                                </tr>
                                <tr>

                                <tr>
                                    <td colspan="6">
                                        <button type="submit" name="submit" class="btn btn-success btn-block" value="cash">
                                            Cobrar en efectivo
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <button type="submit" name="submit"  class="btn btn-success btn-block" value="tarjeta">
                                            Cobrar con tarjeta
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <button type="submit" name="submit" class="btn btn-success btn-block" value="online">
                                            Cobrar online
                                        </button>
                                    </td>
                                </tr>
                            @endif


                        </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endsection
        @section('scripts')
            <script>

                jQuery(document).ready(function () {
                    $('#subTotalRow').hide();
                    $('input:checkbox').change(function ()
                    {
                        $('#subTotalRow').show();
                        var total = 0;
                        $('.box:checked').each(function(){
                            total+=parseFloat($(this).closest('tr').find('.amount').text());
                        });
                        $('#subTotal').text(total.toLocaleString('es-ES', {
                            style: 'currency',
                            currency: 'EUR',
                        }));


                    });

                })



            </script>



@stop