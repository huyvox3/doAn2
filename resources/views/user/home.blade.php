<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.css')
    <title>FHDStore | Ecommerce Website Design</title>
</head>

<body>
    @include('user.header')
    <!-- featured categories -->
    <div class="categories">
        <div class="small-container">
            <div class="row">
                <div class="col-3">
                   <a href="{{ url('/singe_category_products','Clothes') }}"> <img src="../images/category-1.jpg"></a>
                </div>
                <div class="col-3">
                    <a href="{{ url('/singe_category_products','Shoes') }}"><img src="../images/category-2.jpg"></a>
                </div>
                <div class="col-3">
                    <a href="{{ url('/singe_category_products','Watch') }}"> <img src="../images/category-3.jpg"></a>
                </div>
            </div>
        </div>
    </div>
    <!-- featured product -->
    <div class="small-container">
        <h2 class="title">Featured Products</h2>
        <div class="row feature-products">
            
            
        </div>
        <h2 class="title">Lastest Products</h2>
        <div class="row latest-products">
            
        </div>
    </div>
    <!-- offer -->
    <div class="offer">
        <div class="small-container">
            <div class="row">
                <div class="col-2">
                    <img src="../images/exclusive.png" class="offer-img">
                </div>
                <div class="col-2">
                    <p>Exclusive Available on FHDStore</p>
                    <h1>Apple Watch SE GPS</h1>
                    <small>The aluminum case is lightweight and made from 100 percent recycled aerospace-grade alloy.
                        The Sport Band is made from a durable yet surprisingly soft high-performance fluoroelastomer
                        with an innovative pin-and-tuck closure.</small>
                    <a href="http://127.0.0.1:8000/product_details/14" class="btn">Buy Now &#8594;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- -----------rate----- -->
    <div class="rate">
        <div class="small-container">
            <div class="row">
                <div class="col-3">
                    <i class="fa fa-quote-left"></i>
                    <p>Áo đẹp.</p>
                    <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half"></i>
                    </div>
                    <img src="../images/user-1.jpg">
                    <h3>Hoài Linh</h3>
                </div>
                <div class="col-3"><i class="fa fa-quote-left"></i>
                    <p>Quần đẹp.</p>
                    <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half"></i>
                    </div>
                    <img src="../images/user-2.jpg">
                    <h3>Trấn Thành</h3>
                </div>
                <div class="col-3"><i class="fa fa-quote-left"></i>
                    <p>Giày đẹp</p>
                    <div class="rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half"></i>
                    </div>
                    <img src="../images/user-3.jpg">
                    <h3>Đàm Vĩnh Hưng</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- -------brands------ -->
    <div class="brands">
        <div class="small-container">
            <div class="row">
                <div class="col-5">
                    <img src="../images/logo-amazon-pay.png">
                </div>
                <div class="col-5">
                    <img src="../images/logo-google-pay.png">
                </div>
                <div class="col-5">
                    <img src="../images/logo-payoneer.png">
                </div>
                <div class="col-5">
                    <img src="../images/logo-paypal.png">
                </div>
                <div class="col-5">
                    <img src="../images/logo-zalo-pay.png">
                </div>
            </div>
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

      fetchFeatures();
      fetchLastest();
      function fetchFeatures() {
        $.ajax({
            type:'GET',
            url:'/features_products',
            dataType: 'json',
            success: function(response){
                
                $('.feature-products').html('');
                $.each(response.products, function(key,item){
                    $('.feature-products').append('<div class="col-4">\
                        <a href="http://127.0.0.1:8000/product_details/'+item.id+'"> <img src="'+item.image+'"></a>\
                        <a href="http://127.0.0.1:8000/product_details/'+item.id+'">\
                            <h4>'+item.title+'</h4>\
                        </a>\
                        <p>$'+item.price+'.00</p>\
                     </div>');

                });
     
            }
        })

      }


      function fetchLastest(){
        $.ajax({
            type:'GET',
            url:'/latest_products',
            dataType: 'json',
            success: function(response){
                console.log('ok');
                console.log(response.products);
                $('.latest-products').html('');
                $.each(response.products, function(key,item){
                    
                    $('.latest-products').append('<div class="col-4">\
                        <a href="http://127.0.0.1:8000/product_details/'+item.id+'"> <img src="'+item.image+'"></a>\
                        <a href="http://127.0.0.1:8000/product_details/'+item.id+'">\
                            <h4>'+item.title+'</h4>\
                        </a>\
                        <p>$'+item.price+'.00</p>\
                     </div>');

                });
     
            }
        })
      }
  </script>
</body>


</html>