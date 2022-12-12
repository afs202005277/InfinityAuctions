
    
        
            
        <form class="sell" method="post" action="{{ url('/user/' . $user->id ) }}" autocomplete="off" enctype="multipart/form-data">

        <h3>{{ __('Edit Profile') }}</h3>
                @csrf
                @method('post')

                @include('alerts.success')
            
                <label>{{ __('Name') }}</label>
                <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                        placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}">
                @include('alerts.feedback', ['field' => 'name'])
                

            
                    <label>{{ __('Email address') }}</label>
                    <input type="email" name="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           placeholder="{{ __('Email address') }}" value="{{ old('email', auth()->user()->email) }}">
                    @include('alerts.feedback', ['field' => 'email'])
              

                
                    <label>{{ __('Cellphone') }}</label>
                    <input type="text" name="cellphone"
                           class="form-control{{ $errors->has('cellphone') ? ' is-invalid' : '' }}"
                           placeholder="{{ __('Cellphone') }}"
                           value="{{ old('cellphone', auth()->user()->cellphone) }}">
                    @include('alerts.feedback', ['field' => 'cellphone'])
                

                
                    <label>{{ __('Address') }}</label>
                    <input type="text" name="address"
                           class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                           placeholder="{{ __('Address') }}" value="{{ old('address', auth()->user()->address) }}">
                    @include('alerts.feedback', ['field' => 'address'])
              


                
                    <label>{{ __('Birth Date') }}</label>
                    <input type="date" name="birth_date"
                           class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}"
                           placeholder="{{ __('Birth_date') }}"
                           value="{{ old('birth_date', auth()->user()->birth_date) }}">
                    @include('alerts.feedback', ['field' => 'birth_date'])
                

                
                    <label for="profile_picture_input">Profile image:</label>
                    <input type="file" name="profile_image" id="profile_image_input">
               

            <span class="error">{{$errors->first()}}</span>
           
             <button type="submit">{{ __('Save') }}</button>
    
        </form>
  

            
        <form method="post" class="sell" action="{{url('user/'. $user->id)}}" autocomplete="off">

            <h3>{{ __('Password') }}</h3>
                @csrf
                @method('post')

                @include('alerts.success', ['key' => 'password_status'])
                
                    <label>{{ __('Current Password') }}</label>
                    <input type="password" name="old_password"
                           class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}"
                           placeholder="{{ __('Current Password') }}" value="" required>
                    @include('alerts.feedback', ['field' => 'old_password'])
                

                
                    <label>{{ __('New Password') }}</label>
                    <input type="password" name="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           placeholder="{{ __('New Password') }}" value="" required>
                    @include('alerts.feedback', ['field' => 'password'])
               
                
                    <label>{{ __('Confirm New Password') }}</label>
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="{{ __('Confirm New Password') }}" value="" required>
                

            
             <button type="submit" class="btn">{{ __('Change password') }}</button>
            
        </form>
   

