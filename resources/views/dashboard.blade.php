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

                    <center>{{ __('Whatcha want?') }}</center>

                    <div class="list-group">
                        <a href="{{URL::route('profile')}}" class="list-group-item list-group-item-action">
                            Update your public key
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
