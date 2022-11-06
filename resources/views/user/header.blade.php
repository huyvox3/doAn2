
    
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="{{ url('/') }}"> <img src="../images/logo.png" width="125px"></a>
                </div>
                <nav>
                    <ul id="MenuItems">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/product_page') }}">Products</a></li>
                        {{-- <li><a href="{{ url('/account_page') }}">Account</a></li> --}}
                      
                        
                            @if (Route::has('login'))
                                @auth
                                    <li id="cart-li" style="display: flex; float:right">
                                        <a href="{{ url('/cart_page') }}"><img src="../images/cart.png" width="30px" height="30px"></a>
                                        <a class="cart_count" id="cart_count">
                                            
                                        </a>
                                    </li>
                                    <li>
                                         <a href="{{ url('/orders') }}">Order</a>
                                    </li>
                                    <li >
                                        <x-app-layout>
                                            
                                        </x-app-layout>

                                    </li>
                                   
                                    @if (Auth::user()->userType == '1')
                                        @auth
                                        <li>
                         
                                            <a  class="btn nav-btn" href="{{ url('admin_home') }}">Admin Page</a>
                                       
                                        </li>
                                        @endauth
                                    @endif
                                @else
            
                                    <li  style="" >
                                        <a  class="btn nav-btn" href="{{ url('/login_page') }}">Login</a>
                                    </li>
                                    <li style="" >
                                        <a class="btn nav-btn " href="{{ url('/login_page') }}">Register</a>
                                    </li>
                                @endauth
                           
                            @endif
                            
                    </ul>
                   
                    <img src="../images/menu.png" class="menu-icon" onclick="menutoggle()">
                </nav>
            </div>
            <div class="row">
                <div class="col-2">
                    <h1>Give your workout<br>a new style!</h1>
                    <p>Success isn't always about greatness. It's about consistency.
                        <br>Consistent hard work gains success. Greatness will come.
                    </p>
                    <a href="{{ url('/product_page') }}" class="btn">Explore now &#8594;</a>
                </div>
                <div class="col-2">
                    <img src="../images/image1.png">
                </div>
        
            </div>
        </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>

        fetchCart();
        
    </script>
    