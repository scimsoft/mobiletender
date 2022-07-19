@extends('layouts.reg')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <br>
                    <div class="card-header col-centered"><h1 class="display-3">STATS</h1></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <br>

                        <div>&nbsp;</div>
                        <table class="table table-sm">

                            <tr class="bg-light"><td colspan="2" class="text-center"><h4>Caja Actual</h4></td></tr>

                            @foreach($cajaActual as $cajaActualLine)
                                <tr><td>{{$cajaActualLine->payment}}</td><td>@money($cajaActualLine->total)</td></tr>
                            @endforeach
                            <tr><td colspan="2" class="">&nbsp;</td></tr>

                            <tr class="bg-light"><td colspan="2" class="text-center"><h4>Venta de Hoy por el dia</h4></td></tr>

                            @foreach($ventaLinesHoy as $ventaLine)
                                <tr><td>{{$ventaLine->PAYMENT}}</td><td>@money($ventaLine->TOTAL)</td></tr>
                            @endforeach
                                <tr><td><b>TOTAL</b></td><td><b>@money($totalDay)</b></td></tr>
                            <tr><td colspan="2" class="">&nbsp;</td></tr>
                            <tr class="bg-light"><td colspan="2" class="text-center"><h4>Venta de Hoy por la noche</h4></td></tr>

                            @foreach($ventaLinesHoyNight as $ventaLine)
                                <tr><td>{{$ventaLine->PAYMENT}}</td><td>@money($ventaLine->TOTAL)</td></tr>
                            @endforeach
                            <tr><td><b>TOTAL</b></td><td><b>@money($totalNight)</b></td></tr>
                            <tr><td colspan="2" class="">&nbsp;</td></tr>

                            <tr class="bg-light"><td colspan="2" class="text-center"><h4>Venta por Categoria</h4></td></tr>
                            @foreach($categoriesHoy as $categorie)
                                <tr><td>{{$categorie->NAME}}</td><td>@money($categorie->TOTAL)</td></tr>

                                @endforeach
                            <tr><td colspan="2" class="">&nbsp;</td></tr>
                            <tr class="bg-light"> <td colspan="2" class="text-center"><h4>Venta por dia</h4></td></tr>
                            @foreach($ventaPorDias as $ventaPorDia)
                                <tr><td>{{Carbon\Carbon::parse($ventaPorDia->daynumber)->format('l')}}&nbsp;- &nbsp;{{$ventaPorDia->daynumber}}</td><td>@money($ventaPorDia->TOTAL)</td></tr>

                            @endforeach

                                <!--tr>
                                    <td>
                                        <a href="/timereport" class="btn btn-primary"> Marcar Entradad o Salida</a> <br>
                                    </td>

                                    <td>Checkin o Checkout</td>
                                </tr-->

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')




@stop
