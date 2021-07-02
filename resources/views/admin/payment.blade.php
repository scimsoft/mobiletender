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
                        <table class="table table-borderless m-0 p-0">
                            <tr class="text-center"><td>
                        <a href="paypanel" class="btn btn-primary">Refrescar</a>
                                </td>
                            <td>
                                <!--a href="opendrawer" class="btn btn-primary">Abrir Caja</a-->
                            </td></tr>
                        </table>





                        @foreach($places as $place)

                            <a href="/payments/{{$place->id}}"

                               @if(in_array($place->id, $openTicket) and $openTicketSum[$loop->iteration-1] > 0)
                               @if($ticketWithUnorderdItems[$loop->iteration-1])
                               class="btn btn-warning btn-lg mt-5 "
                               @else
                               class="btn btn-success btn-lg mt-5 "
                               @endif
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