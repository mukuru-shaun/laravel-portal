@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                            <form method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="publicKey">Public Key</label>
                                    <input
                                        type="text"
                                        class="form-control @error('public_key') is-invalid @enderror"
                                        id="publicKey"
                                        name="public_key"
                                        placeholder="Enter your public key"
                                        value="{{old('public_key', $user->public_key)}}"
                                    />
                                    <small id="publicKeyHelp" class="form-text text-muted">Normally found <code>~/.ssh/id_rsa.pub</code></small>

                                    @error('public_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
