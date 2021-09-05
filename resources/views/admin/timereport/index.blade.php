@extends('layouts.reg')
<div class="container">
    <div class="row justify-content-center">

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
        <br>
            <input class="form-control" id="searchText" type="text" placeholder="Search..">
        <table class="table table-bordered">
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Entrada</th>

                <th>Salida</th>
                <th>Tiempo</th>

            </tr>
            <tbody id="reportTable">
            <tr>
                <form action="{{ route('categories.store') }}" method="POST">
                    <td>{{Auth::user()->name}}</td>
                    @csrf
                    @if(!$isChecking)
                        <td>{{ \Carbon\Carbon::now()->format('H:i' ) }}</td>

                        <td>

                            <a href="/timereport/enter" class="btn btn-primary">Entrada</a>

                        </td>
                        <td></td>
                    @else
                        <td>{{date('D d-M-y',strtotime($lastChecking->starttime))}}</td>
                        <td>
                            {{date('H:i',strtotime($lastChecking->starttime))}}
                        </td>

                        <td>{{ \Carbon\Carbon::parse( $lastChecking->starttime )->diffForHumans( \Carbon\Carbon::now(),['parts'=> 2,'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE] ) }}</td>

                    @endif


                    <td>@if($isChecking)
                            <a href="/timereport/exit" class="btn btn-primary">Salida</a>
                        @endif</td>


                </form>
                <td>

                    &nbsp;
                </td>
            </tr>

            @foreach($timereports->reverse() as $timereport)
                @if($loop->index >= count($timereports)-1 AND $isChecking)
                    @break
                @endif
                <tr>
                    <td>{{$timereport->user->name}}</td>
                    <td>{{date('D d-M-y',strtotime($timereport->starttime))}}</td>

                    <td>{{date('H:i',strtotime($timereport->starttime))}}</td>

                    <td>{{date('H:i',strtotime($timereport->endtime))}}</td>

                    @if(!is_null($timereport->endtime))
                        <td>{{ \Carbon\Carbon::parse( $timereport->starttime )->diffForHumans( $timereport->endtime,['parts'=> 2,'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE] ) }}</td>

                @else
                    <td></td>
                        @endif
                </tr>

            @endforeach



            </tbody>
        </table>
    </div>
    </div>
</div>
@section('scripts')
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>


    <script>
        $(document).ready(function(){
            $("#searchText").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#reportTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@stop