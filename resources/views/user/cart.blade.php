<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.css')
    <title>Cart - FHDStore</title>
    
</head>

<body>
    @include('user.header1')
   
    
    <div class="small-container cart-page">

        <table  class="product-info">
        
            <tr>
                <th>Product</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <tbody class="body">

            </tbody>

          
        </table>



        <div class="total-price">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td class="sub-total">$</td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td class="tax">$</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="total">$</td>
                </tr>

            </table>
        </div>
        <div class="pay-button">
            <a href="{{ url('/createpaypal') }}" class="btn">Pay &#8594;</a>
        </div>
    </div>
    <!-- -------footer--- -->
    @include('user.footer')
    <!-- js for toggle menu -->
  @include('user.script')
    @include('user.script_add_cart')
  <script>
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });



    
    $(document).ready(function(){
        fetchCart();
        fetchCartItem();
      

        // $(document).on('click', '.remove-item', function(e){
        //         e.preventDefault();
                
        //     var data = {
        //         productsID: $('.remove-item').val();
        //     }
        //     $.ajax({
        //         type:"GET",
        //             url:"/remove_cartItem",
        //             data:'data';
        //             dataType:"json",
        //             success: function(response){
        //                 console.log('successfully removed.')
        //             }
        //     })
        // });
       
        
        function fetchCart(){
            $.ajax({
                    type:"GET",
                    url:"/count_cart",
                    dataType:"json",
                    success: function(response){
                           
                           document.getElementById("cart_count").innerHTML=response.count;

                    }
                });
         }
         
       
         function fetchCartItem(){
            $.ajax({
                    type:"GET",
                    url:"/cart_info",
                    dataType:"json",
                    success: function(response){
                    
                       
                        $('.body').html('');
                        var sum = 0;
                        var tax = 0.2, after_tax = 0;
                        // $('.product-info').append('');
                        console.log(response);
                        $.each(response.data, function(key, item){
                            console.log(item.productID);
                       
                           if(item.size != null){
                            $('.body').append("<tr>\
                                    <td>\
                                        <div class='cart-info'>\
                                            <a href='  http://127.0.0.1:8000/product_details/"+item.productID+" '><img src='"+item.img+ " '></a><br>\
                                           <div>\
                                            <p>"+item.product_title+"</p>\
                                            <small>Price: $"+item.price+".00</small>\
                                            <br>\
                                            <button style='padding:4px 10px; margin:12px -3px;' class =' btn remove-item' value = '"+item.productID+"'>Remove</a>\
                                            </div>\
                                        </div>\
                                    </td>\
                                    <td class ='size'>"+item.size.toUpperCase()+"</td>\
                                    <td><label >"+item.quantity+"</td>\
                                    <td class = 'item_price'>$"+item.price * item.quantity+".00</td>\
                                </tr>");
                           }

                           if(item.size == null){
                            $('.body').append("<tr>\
                                    <td>\
                                        <div class='cart-info'>\
                                            <a href='http://127.0.0.1:8000/product_details/"+item.productID+") }}'><img src='"+item.img+ " '></a><br>\
                                           <div>\
                                            <p>"+item.product_title+"</p>\
                                            <small>Price: $"+item.price+".00</small>\
                                            <br>\
                                            <button style='padding:4px 10px; margin:12px -3px;' class =' btn remove-item' value = '"+item.productID+"'>Remove</a>\
                                            </div>\
                                        </div>\
                                    </td>\
                                    <td class ='size'></td>\
                                    <td><label >"+item.quantity+"</td>\
                                    <td class = 'item_price'>$"+item.price * item.quantity+".00</td>\
                                </tr>");
                           }
                            sum += item.price * item.quantity;
                        });


                      
                        // $(".item_price").each(function() {
                        //     var val = $.trim( $(this).text() );

                        //     if ( val ) {
                        //         val = parseFloat( val.replace( /^\$/, "" ) );

                        //         sum += !isNaN( val ) ? val : 0;
                        //     }
                        // });
                        tax *= sum;
                        $('.sub-total').html('$'+sum+'.00');
                        $('.tax').html('$'+Math.round(tax)+'.00');
                        after_tax = sum +  Math.round(tax);
                        $('.total').html('$'+after_tax+'.00');
                        


                    }
                });
         }

         $(document).on('click','.remove-item',function(e){
              e.preventDefault();
              var data = {
                'productsID': $(this).val(),
                
              }
              console.log(data);
              $.ajax({
                  type:"GET",
                  url:"/remove_cartItem",
                  data: data,
                  dataType:"json",
                  success:function(response){
                     console.log(response.message);
                     fetchCartItem();
                     fetchCart();
                  }

               });
               

          });
         
    });  
  </script>
</body>

</html>