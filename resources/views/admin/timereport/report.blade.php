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
        <table class="table table-bordered">
            <tr>
                <th>User</th>
                <th>Date</th>
                <th>Hora de entrada</th>
                <th>Start Break</th>
                <th>End Break</th>
                <th>Hora de Salida</th>
                <th>Total</th>

            </tr>
        @if(Auth::user() and Auth::user()->isAdmin())
            @foreach($timereports as $timereport)
                <tr>
                    <td>{{$timereport->user->name}}</td>
                    <td>{{date('d-M-y',strtotime($timereport->starttime))}}</td>

                    <td>{{date('H:i',strtotime($timereport->starttime))}}</td>
                    <td>{{date('H:i',strtotime($timereport->breakstarttime))}}</td>
                    <td>{{date('H:i',strtotime($timereport->breakendtime))}}</td>
                    <td>{{date('H:i',strtotime($timereport->endtime))}}</td>

                    @if(!is_null($timereport->endtime))
                        <td>{{ \Carbon\Carbon::parse( $timereport->starttime )->diffForHumans( $timereport->endtime,['parts'=> 2,'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE] ) }}</td>
                        
                @else
                    <td></td>
                        @endif
                </tr>

            @endforeach
            @endif
            <tr>
                <form action="{{ route('categories.store') }}" method="POST">
                    <td></td>
                    @csrf
                    @if(!$isChecking)
                    <td></td>

                    <td>

                        <a href="/timereport/enter" class="btn btn-primary">Entrada</a>

                    </td>
                        @else
                        <td>{{date('d-M-y',strtotime($lastChecking->starttime))}}</td>
                        <td>
                            {{date('H:i',strtotime($lastChecking->starttime))}}
                        </td>
                    @endif
                    <td></td>
                    <td></td>
                    <td>@if($isChecking)
                        <a href="/timereport/exit" class="btn btn-primary">Salida</a>
                    @endif</td>
                    <td></td>
                </form>
                <td>

                    &nbsp;
                </td>
            </tr>
        </table>
    </div>
    </div>
</div>
@section('scripts')
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>



@stop