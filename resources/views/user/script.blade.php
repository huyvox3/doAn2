<script>
    var MenuItems = document.getElementById("MenuItems");
    MenuItems.style.maxHeight = "0px";

    function menutoggle() {
        if (MenuItems.style.maxHeight == "0px") {
            MenuItems.style.maxHeight = "400px"
        } else {
            MenuItems.style.maxHeight = "0px"
        }
    } 

    var LoginForm = document.getElementById("LoginForm");
    var RegForm = document.getElementById("RegForm");
    var Indicator = document.getElementById("Indicator");


    function register() {
        RegForm.style.transform = "translateX(0px)";
        LoginForm.style.transform = "translateX(0px)";
        Indicator.style.transform = "translateX(100px)";
    }
    function login() {
        RegForm.style.transform = "translateX(300px)";
        LoginForm.style.transform = "translateX(300px)";
        Indicator.style.transform = "translateX(0px)";
    }


    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

    $(document).ready(function(){
        fetchCart();
         function fetchCart(){
            $.ajax({
                    type:"GET",
                    url:"/count_cart",
                    dataType:"json",
                    success: function(response){
                                var sum = 0;
                                var tax = 0.2, after_tax = 0;
                           console.log('started fetching');
                           document.getElementById("cart_count").innerHTML=response.count;
                            if($('#cart-count')[0]){document.getElementById("cart-count").innerHTML=response.count;}
                            if ($("#item-list")[0]){
                                console.log('ok');
                                console.log(response.data);
                                $('.body-item').html('');
                               
                                $.each(response.data, function(key,item){
                               
                                   if(item.size != null){
                                    $('.body-item').append('<tr>\
                                     <td><a href="{{  url('product_details',"+item.productID+") }}">\
                                        <img style = "width:100px;height: 100px ;margin:0.25em 0;"src="'+item.img+'"></a>\
                                        <p style="font-size: 1em;color:#bf3d04" >'+item.product_title+'</p></td>\
                                    <td><p>'+item.size.toUpperCase()+'</p></td>\
                                    <td><p>'+item.quantity+'</p></td>\
                                    <td><span  class="price item-price">$'+item.price *item.quantity+'</span></p></td>\
                                    </tr>');
                                   }
                                   if(item.size == null){
                                    $('.body-item').append('<tr>\
                                     <td><a href="{{  url('product_details',"+item.productID+") }}">\
                                        <img style = "width:100px;height: 100px ;margin:0.25em 0;"src="'+item.img+'"></a>\
                                        <p style="font-size: 1em;color:#bf3d04" >'+item.product_title+'</p></td>\
                                    <td><p></p></td>\
                                    <td><p>'+item.quantity+'</p></td>\
                                    <td><span  class="price item-price">$'+item.price *item.quantity+'</span></p></td>\
                                    </tr>');
                                   
                                   }

                                    sum += item.price * item.quantity;
                                });
                                
                                
                                // $(".item_price").each(function() {
                                //     var val = $.trim( $(this).text() );

                                //     if ( val ) {
                                //         val = parseFloat( val.replace( /^\$/, "" ) );

                                //         sum += !isNaN( val ) ? val : 0;
                                //     }
                                //  });
                                tax *= sum;
                                $('.sub-total').html('$'+sum+'.00');
                                $('.tax').html('$'+Math.round(tax)+'.00');
                                after_tax = sum +  Math.round(tax);
                                $('.total').html('$'+after_tax+'.00');
                                $('#price').val(after_tax+".00");
                                
                            }

                            console.log('end fetching');
                    }
                });
         }


         
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://www.paypal.com/sdk/js? client-id = {{ env('PAYPAL_SANDBOX_CLIENT_ID') }}"></script>
