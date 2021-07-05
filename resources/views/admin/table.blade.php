@extends('layouts.reg')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <br>
                <div class="card-header col-centered"><h1 class="display-3 text-center"> Cuentas abiertas</h1></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif




                        @foreach($places as $place)

                            <a href="/order/table/{{$place->id}}"

                               @if(in_array($place->id, $openTicket) and $openTicketSum[$loop->iteration-1] > 0)
                               @if($ticketWithUnorderdItems[$loop->iteration-1])
                               class="btn btn-warning btn-lg mt-5 "
                               @else
                               class="btn btn-success btn-lg mt-5 "
                               @endif
                               @else
                               class="btn btn-secondary btn-lg mt-5 "
                                    @endif
                            >{{$place->name}}</a>

                            @endforeach


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