@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <center>{{ __('Whatcha want?') }}</center>

                    <div class="list-group">
                        <a href="{{URL::route('profile')}}" class="list-group-item list-group-item-action">
                            Update your public key
                        </a>
                        <a href="{{URL::route('external-accounts')}}" class="list-group-item list-group-item-action">
                            Link your Github and Gitlab accounts
                        </a>
                        <a href="{{URL::route('access-request')}}" class="list-group-item list-group-item-action">
                            Request Database Access
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
