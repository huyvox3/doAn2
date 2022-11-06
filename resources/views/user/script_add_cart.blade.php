<script>

$(document).ready(function(){
        fetchCart();
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
    });
</script>