<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.css')
    <title>Orders - FHDStore</title>
    @include('user.orderpagecss')
</head>


<body>
   


    @if(\Session::has('success'))
   
        <script>
            swal("Done!", "Your payment is completed!", "success");
        </script>
        {{ \Session::forget('success') }}
    @endif
    @include('user.header1')
    <!-- featured categories -->
    <div class="small-container">
        <div class="row row-2">
            <h1 style="font-size:2em;">Your Orders</h1>
            
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

            fetchOrder();

        

            function fetchOrderLinesData(orderID){
                
                console.log(orderID);
                var id = orderID;
                var input ={
                    'orderID' : id,
                } 



                console.log(input['orderID'] +'  id');
                $.ajax({
                    method:"GET",
                    url:"/order_lines",
                    data: input,
                    dataType:'json',
                    success:function (response) {
                        console.log(response.data);
                        console.log(response.orderID);
                        
                        $.each(response.data,function(key,item){
                          
                            $('.order-line-details[value="'+response.orderID+'"]').append('\
                                <div class ="row order-line">\
                                    <div class="col-1">\
                                        <div class="item-details item-img col">\
                                                <img  src="'+item.img+'">\
                                        </div>\
                                    </div>\
                                    <div class = "col-2"> \
                                        <div class ="item-title item-details">'+item.title+'</div>\
                                       \
                                            <div class="item-size item-details">'+item.size.toUpperCase()+'</div>\
                                            <div class="item-details">x'+item.quantity+'</div>\
                                    </div>\
                                    \
                                    <div class ="col-5">\
                                     \
                                        <div class="price item-details">$'+item.price * item.quantity+'</div>\
                                     </div>\
                                     \
                                </div>\
                            ');
                        })

                
                    }
                    
                });
            }

        function fetchOrder(){
           
            
            $.ajax({
                method:"GET",
               
                url:"/order_details",
                dataType:'json',
                success:function(response){
                    
                    console.log('input: '+response.input);
                    $.each(response.orders, function(key, item){
                        $('.small-container').append('<div class="container order-container">\
                            \
                            <h2 class ="order-info">Order ID: <label class = "info-value">'+item.id+'</label></h2>\
                            <h2 class ="order-info">Order Status: <label class = "info-value">'+item.status+'</label></h2>\
                            <h2 class = "order-info">Payment Method: <label class ="info-value">'+item.paymentMethod+'</label></h2>\
                            <h2 class= "order-info">Payment Status: <label class ="info-value">'+item.paymentStatus+'</label> </h2>\
                            \
                                <div>\
                                    <div class ="order-line-details" value ="'+item.id+'"></div>\
                                       <div class ="order-price">\
                                            <p class="order-info" >Tax: <span class="price tax" style="color : black"><b>$'+item.tax+'</b></span></p>\
                                            <p class="order-info">Total: <span class="price total" style="color:black"><b>$'+item.total+'</b></span></p>\
                                        </div>\
                                    </div>\
                                </div>');
                            
                            fetchOrderLinesData(item.id);
                        
                    })
                    
                }
            })
        }

    })
    
  
    

  </script>
</body>

</html>