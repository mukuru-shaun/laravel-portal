@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('External Accounts') }}</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST">
                            @csrf

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Application</th>
                                    @foreach($environments as $env)
                                        <th scope="col" class="text-center">
                                            <div class="row">
                                                <div class="col-sm text-center">
                                                    {{ $env->display_name }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm text-center">
                                                    Read
                                                </div>
                                                @if ($env->name !== 'production')
                                                    <div class="col-sm text-center">
                                                        Write
                                                    </div>
                                                @endif
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $application->display_name }}</td>

                                            @foreach($environments as $env)
                                                <td>
                                                    <div class="row">
                                                        @foreach($application->applicationInstances as $instance)
                                                            @if ($instance->environment->id == $env->id)
                                                                <div class="col-sm text-center">
                                                                    <input type="checkbox" name="application_instance[{{$instance->id}}][read]" />
                                                                </div>
                                                                @if ($env->name !== 'production')
                                                                    <div class="col-sm text-center">
                                                                        <input type="checkbox" name="application_instance[{{$instance->id}}][write]" />
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </td>
                                            @endforeach

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
