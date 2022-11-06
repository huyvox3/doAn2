<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.css')
    <title>Payment - FHDStore</title> 
    <style>
     
    </style>
</head>

<body>
    @include('user.header1')
    <div class="p-form">
        
         @php
           $user = Auth::user();

          

         @endphp
             
                
          @if(\Session::has('error'))
   
             <script>
                 swal("Error!", "Some error occured.!", "error");
             </script>
             {{ \Session::forget('error') }}
         @endif

  
    
                  
        <div class="container" style="width:70%">
          <h1 style="font-size: 2em">Address</h1>
          <div>{{ $user->name }}  {{ $user->phone }}   </div>
          <div>{{ $user->address }}</div>
          
        </div>
        <div class="container" style="width: 70%">
            <h1 style="font-size: 2em">Products</h1>
            <br>
            <div class="col-40">
              <div class="" style="width: 80%; ">
                <h2 style="font-size: 1.5em">Cart
                  <span class="price" style="color:black">
                    <i class="fa fa-shopping-cart"></i>
                    <b id="cart-count">0</b>
                  </span>
                </h2>

                <table id = "item-list" class="item-list product-info" style="padding-right:2em;">
                    <tr>
                      <th>Product</th>
                      <th>Size</th>
                      <th>Quantity</th>
                      <th>Price</th>
                    </tr>
                    <tbody class="body-item">

                    </tbody>
                </table>
               {{-- <div  id = "item-list"class="item-list ">

               </div> --}}
               
                
                <hr color="#ff523b" style="height: 3px; border-radius:6px; margin: 6px">
                <p >Tax <span class="price tax" style="color : black"><b>$</b></span></p>
                <p>Total <span class="price total" style="color:black"><b>$</b></span></p>
              </div>
            </div>
          </div>
        </div>
          
       <div class="container">
        <form style=" margin-left:6em;width:12%"  action="{{ url('processPaypal') }}" action="GET">
          @csrf
            <input type="hidden" id="price" name="price" value="">
            
            <input type="hidden" name = "cart" value ="{{ $cart }}">
            
            <button style="background-color:#ff523b" type="submit" class="btn create_order"  >Pay via PayPal &#8594;</a>
            
          </form>
       </div>
    </div>
    <!-- -------footer--- -->
    @include('user.footer')
    <!-- js for toggle menu -->
  @include('user.script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
     
        $(document).ready(function(){
        // featchPaymentItem();
        // function featchPaymentItem(){
          
        //     $.ajax({
        //         type:"GET",
        //         url:"/cart_info",
        //         dataType:"json",
        //         success: function(response){
                   
        //         }
        //     })
        //  }

         
         
      })
    </script>
</body>

</html>