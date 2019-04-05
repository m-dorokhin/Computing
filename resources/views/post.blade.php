@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1>{{ $computing->title }}</h1></div>
                    <div class="card-body">
                        <p>{{ $computing->created_at }} <i>{{ $computing->user->name }}</i></p>
                        <p>{{ $computing->text }}</p>
                        <h2>Коды:</h2>
                        <p>
                            @foreach($computing->codes as $cod)
                                {{ $cod->code }};
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection