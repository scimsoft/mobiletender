@extends('layouts.reg')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <br>
                <div class="card-header col-centered"><h1 class="display-3 text-center"> CAJA</h1></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <a href="paypanel" class="btn btn-primary">Refrescar</a>

                        <br>


                        @foreach($places as $place)

                            <a href="/payments/{{$place->id}}"

                               @if(in_array($place->id, $openTicket) and $openTicketSum[$loop->iteration-1] > 0)
                               class="btn btn-danger btn-lg mt-5 "
                               @else
                               class="btn btn-secondary btn-lg mt-5 "
                               @endif
                            >{{$place->name}}
                                <br>

                                @if($openTicketSum[$loop->iteration-1] > 0)
                               @money($openTicketSum[$loop->iteration-1]*1.1)
                                    @endif

                            </a>

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