@extends('layouts.auth')
@section('content') {{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}"
                                    required autofocus> @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span> @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"
                                    required> @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span> @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                    required> @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span> @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="six wide computer only six wide tablet only fourteen wide mobile only column">
    <div class="ui center aligned segment">
        <div class="ui huge blue header">{{ config('app.name') }}
            <div class="ui sub header">Register</div>
        </div>
        <form action="{{ route('register') }}" method="POST" class="ui form">
            {{ csrf_field() }}
            <div class="field">
                <div class="ui right icon input">
                    <input type="text" id="firstname" name="firstname" placeholder="Firstname" value="{{ old('firstname') }}" autofocus>
                    <i class="ion-ios-contact icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui right icon input">
                    <input type="text" id="lastname" name="lastname" placeholder="Lastname" value="{{ old('lastname') }}">
                    <i class="ion-ios-contact icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui right icon input">
                    <input type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}">
                    <i class="ion-ios-contact icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui right icon input">
                    <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                    <i class="ion-email icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui right icon input">
                    <input type="password" id="password" name="password" placeholder="Password">
                    <i class="ion-locked icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui right icon input">
                    <input type="password" id="confirm" name="confirm" placeholder="Confirm Password">
                    <i class="ion-locked icon"></i>
                </div>
            </div>
            <div class="field">
                <button type="submit" class="ui fluid primary submit icon button">
					<i class="ion-person-add icon"></i> Register
				</button>
            </div>
            <div class="ui error message"></div>
        </form>
    </div>
</div>
@endsection
