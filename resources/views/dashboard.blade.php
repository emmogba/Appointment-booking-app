@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <h4>{{ __('Your Services') }}</h4>

                    <ul>
                        @foreach(Auth::user()->services as $service)
                        <li>
                            {{ $service->name }} - {{ $service->price }}
                        </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('services.create') }}" class="btn btn-primary">{{ __('Create Service') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection