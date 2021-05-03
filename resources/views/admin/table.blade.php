@extends('layouts.reg')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <br>
                <div class="card-header col-centered"><h1 class="display-3"> Area Privada</h1></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-centered" > <h4 >Selecionar una mesa</h4></div>
                        <br>
                        <select onchange="location = '/order/table/'+ this.value;" class="form-control" >
                        @foreach($places as $place)
                            <option value="{{$place->id}}">{{$place->name}}</option>
                        @endforeach
                        </select>
                        @foreach($places as $place)
                            <a href="/order/table/{{$place->id}}"
                               @if($place->ticketid)
                               class="btn btn-danger btn-lg mt-5 "
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