@extends('layouts.reg')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <br>
                <div class="card-header col-centered"><h1 class="display-3"> Pedidos</h1></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                      <table class="table">
                          <tr>
                              <td>Mesa</td>
                              <td>Cantidad</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                          </tr>
                       @foreach($openorders as $index => $order )

                           <tr>
                               <td> <b>{{$order->id}}</b> </td>
                               <td>@money($openSums[$index]*1.1)</td>
                               <td><a href="\admintable\{{$order->id}}" class="btn btn-primary">Ver</a></td>
                               <td><a href="\bill\{{$order->id}}" class="btn btn-danger">La Cuenta</a></td>
                               <td>
                                   @if(Auth::user()->isAdmin())
                                   <a href="\openorders\delete\{{$order->id}}" class="btn btn-danger">Borrar</a>
                                       @endif
                               </td>

                           </tr>
                           @endforeach

                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        jQuery(document).ready(function () {


        });

    </script>



@stop