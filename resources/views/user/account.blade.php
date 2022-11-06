<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.css')
    <title>Account - FHDStore</title>
</head>

<body>
    @include('user.header1')
    <div class="account-page">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <img src="../images/image1.png" width="100%">
                </div>

                <div class="col-2">
                    <div class="form-container" style="height: 600px; padding: 60px 0">
                        <div class="form-btn">
                            <span onclick="login()">Login</span>
                            <span onclick="register()">Register</span>
                            <hr id="Indicator">
                        </div>
                        <form id="LoginForm" method="POST" action="{{ route('login') }}">
                            @csrf
                            <input  id="email"  type="email" name="email" :value="old('email')" required autofocus placeholder="Username">

                            <input id="password"  type="password" name="password" required autocomplete="current-password placeholder="Password">
                            <label for="remember_me" class="flex items-center">
                                <input style="width: 1em;height:1em" type ="checkbox" id="remember_me" name="remember" />
                                <span style="font-size: 12px;padding: 6px" class="  text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                            @endif
                            <button type="submit" class="btn">Login</button>
                            {{-- <a href="">Forget password</a> --}}

                        </form>

                        <form id="RegForm" method="POST" action="{{ route('register') }}">
                            @csrf
                            <label for="name">Name</label>
                            <input id="name"  type="text" name="name" :value="old('name')">
                            <label for="email">Email</label>
                            <input id="email"  type="email" name="email" :value="old('email')" required >
                            <label for="phone">Phone</label>
                            <input id ='phone' type="text" name="phone" :value="old('phone')" required  >
                            <label for="address">Address</label>
                            <input id ='address' type="text" name="address" :value="old('address')" required  >
                            <label for="password">Password</label>
                            <input id="password"  type="password" name="password"  required>
                            <label for="password_confirmation">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required >
                             @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                <div class="mt-4">
                                    <x-jet-label for="terms">
                                        <div class="flex items-center">
                                            <x-jet-checkbox name="terms" id="terms"/>
                
                                            <div class="ml-2">
                                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </x-jet-label>
                                </div>
                            @endif
                            <button type="submit" class="btn">Register</button>

                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- -------footer--- -->
    @include('user.footer')
    <!-- js for toggle menu -->
  @include('user.script')
  
</body>

</html>