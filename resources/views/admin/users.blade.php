@extends('layouts.reg')

@section('content')
<div class="container">


                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                      <table class="table">
                          <tr>
                              <td>Usuario</td>
                              <td>Correo</td>
                              <td>Tipo</td>
                              <td>&nbsp;</td>

                          </tr>
                       @foreach($users as $user )
                            <input type="hidden" id="userID" value="{{$user->id}}">
                           <tr>
                               <td> <b>{{$user->name}}</b> </td>
                               <td>{{$user->email}}</td>
                               <td><select name="type" class="type">
                                       <option  value="{{$user->id}}.admin" {{$user->type == 'admin'  ? 'selected' : ''}}>Admin</option>
                                       <option  value="{{$user->id}}.manager" {{$user->type == 'manager'  ? 'selected' : ''}}>Encargado</option>
                                       <option  value="{{$user->id}}.waiter" {{$user->type == 'waiter'  ? 'selected' : ''}}>Camarera</option>
                                       <option  value="{{$user->id}}.default" {{$user->type == 'default'  ? 'selected' : ''}}></option>
                                   </select>

                                   </td>

                               <td><!--a href="\deleteuser\{{$user->id}}" class="btn btn-danger">Borrar</a--></td>

                           </tr>
                           @endforeach

                      </table>
                </div>


@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            $('.type').on('change',function(){
                var selected = $(event.target).val().split('.')[1];
                var userID = $(event.target).val().split('.')[0];

                jQuery.ajax({
                    url: '/changeusertype/' + userID +'/'+selected,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                    }
                })

            })

        });

    </script>



@stop