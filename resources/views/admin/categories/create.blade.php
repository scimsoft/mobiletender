@extends('layouts.reg')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Add a contact</h1>
            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif
                <form method="post" action="{{ route('category.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name"/>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Parent id:</label>
                        <input type="text" class="form-control" name="parentid"/>
                    </div>

                    <div class="form-group">
                        <label for="email">Image:</label>
                        <input type="text" class="form-control" name="image"/>
                    </div>
                    <div class="form-group">
                        <label for="city">Texttip:</label>
                        <input type="text" class="form-control" name="texttip"/>
                    </div>
                    <div class="form-group">
                        <label for="country">Showname:</label>
                        <input type="text" class="form-control" name="catshowname"/>
                    </div>
                    <div class="form-group">
                        <label for="job_title">Order:</label>
                        <input type="text" class="form-control" name="catorder"/>
                    </div>
                    <button type="submit" class="btn btn-primary-outline">Add Category</button>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
@stop