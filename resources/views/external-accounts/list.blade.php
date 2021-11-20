@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('External Accounts') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                            <div class="list-group">
                                @foreach($providers as $provider => $details)
                                    <a href="{{URL::route('external-accounts-redirect', [$provider])}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ">
                                        Link {{$details['name']}} account
                                        @if($details['account'])
                                            <span class="badge badge-primary">
                                            Current User: {{$details['account']->username}}
                                            </span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
