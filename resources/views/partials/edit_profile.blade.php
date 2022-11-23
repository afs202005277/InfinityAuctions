<div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('Edit Profile') }}</h5>
            </div>
            <form method="post" action="{{ url('/user/' . $user->id ) }}" autocomplete="off">
                
                <div class="card-body">
                        @csrf
                        @method('post')

                        @include('alerts.success')
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label>{{ __('Email address') }}</label>
                            <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email address') }}" value="{{ old('email', auth()->user()->email) }}">
                            @include('alerts.feedback', ['field' => 'email'])
                        </div>

                        <div class="form-group{{ $errors->has('cellphone') ? ' has-danger' : '' }}">
                            <label>{{ __('Cellphone') }}</label>
                            <input type="text" name="cellphone" class="form-control{{ $errors->has('cellphone') ? ' is-invalid' : '' }}" placeholder="{{ __('Cellphone') }}" value="{{ old('cellphone', auth()->user()->cellphone) }}">
                            @include('alerts.feedback', ['field' => 'cellphone'])
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                            <label>{{ __('Address') }}</label>
                            <input type="text" name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Address') }}" value="{{ old('address', auth()->user()->address) }}">
                            @include('alerts.feedback', ['field' => 'address'])
                        </div>


                        <div class="form-group{{ $errors->has('birth_date') ? ' has-danger' : '' }}">
                            <label>{{ __('Birth Date') }}</label>
                            <input type="date" name="birth_date" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Birth_date') }}" value="{{ old('birth_date', auth()->user()->birth_date) }}">
                            @include('alerts.feedback', ['field' => 'birth_date'])
                        </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn">{{ __('Save') }}</button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('Password') }}</h5>
            </div>
            <form method="post" action="{{url('user/'. $user->id)}}" autocomplete="off">
                <div class="card-body">
                    @csrf
                    @method('post')

                    @include('alerts.success', ['key' => 'password_status'])

                    <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                        <label>{{ __('Current Password') }}</label>
                        <input type="password" name="old_password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>
                        @include('alerts.feedback', ['field' => 'old_password'])
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label>{{ __('New Password') }}</label>
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" required>
                        @include('alerts.feedback', ['field' => 'password'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('Confirm New Password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm New Password') }}" value="" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn">{{ __('Change password') }}</button>
                </div>
            </form>
        </div>
    </div>