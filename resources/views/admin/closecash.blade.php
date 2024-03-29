@extends('layouts.reg')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <br>
                    <div class="card-header col-centered"><h1 class="display-3">Cerrar Caja</h1></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table">
                            @php($mtotal=0);
                            @foreach($totals as $total )
                                @if(str_contains($total->payment,'cash'))

                                    <tr>
                                        <td>{{$total->payment}}</td>
                                        <td>{{$total->notes}}</td>

                                        <td>@money($total->total)</td>
                                        @php($mtotal += $total->total)


                                    </tr>

                                @endif

                            @endforeach
                            <tr class="border border-top border-bottom bg-light" >

                                <td colspan="2"><strong>TOTAL Cash</strong></td>
                                <td><strong>@money($mtotal)</strong></td>


                            </tr>

                            @foreach($totals as $total )
                                @if(!str_contains($total->payment,'cash'))

                                    <tr>
                                        <td>{{$total->payment}}</td>
                                        <td></td>
                                        <td>@money($total->total)</td>
                                        @php($mtotal += $total->total)


                                    </tr>

                                @endif

                            @endforeach
                            <tr class="border border-top border-bottom bg-light" >

                                <td colspan="2"><strong>TOTAL </strong></td>
                                <td><strong>@money($mtotal)</strong></td>


                            </tr>
                            <tr>
                                <!--td><a href="/printmoney" class="btn btn-primary">Imprimir caja</a></td-->
                                <td><a href="/closemoney" class="btn btn-primary">Cerrar Caja</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')




@stop