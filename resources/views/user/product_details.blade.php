<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.css')
    <title>All products - FHDStore</title>
    <base href="/public">
</head>

<body>
    @include('user.header1')
    <!-- featured categories -->
        @php    
             $pieces = preg_split('/(?=[A-Z])/',$product->description);
             $img = $product->image;

            $imgs = explode('|',$img);

            
        @endphp
        
    <input type="hidden" class="productID" value="{{ $product->id }}">

  <input type="hidden" class="userID" value="{{ Auth::user()->id }}">

  
    <!-- -----single product details----- -->
    <div class="small-container single-product">
        <div class="row">
            <div class="col-2">

                <img  src="{{URL::to($imgs[0])  }}" width="100%" id="ProductImg" alt="{{ $imgs[0] }}">
                <div class="small-img-row">

{{--                     
                   @foreach ($imgs as $item) 
                        <div class="small-img-col">
                            <img src=" {{ $item }}" width="100%" class="small-img">
                        </div>
                   @endforeach --}}
                    
                     <td style="margin-left: 3em">
                        @foreach ($imgs as $item )
                            <div class="small-img-col">
                                <img src="{{ URL::to($item) }}" width="100%" class="small-img" alt="{{ $item }}" onclick="changeThumbnail('{{ URL::to($item) }}')">
                             </div>
                        @endforeach
                   </td>
                </div>
            </div>
            <div class="col-2">
                <a href="{{ url('/') }}">Home/</a>
                @if ($product->category == 'Clothes')
                    <a href="{{ url('/singe_category_products/Clothes') }}">Clothes</a>
                @endif

                @if ($product->category == 'Shoes')
                     <a href="{{ url('/singe_category_products/Shoes') }}">Shoes</a>
                 @endif

                 @if ($product->category == 'Watch')
                    <a href="{{ url('/singe_category_products/Watch') }}">Watch</a>
                 @endif
                <h1>{{ $product->title }}</h1>
                <h4>${{ $product->price }}.00</h4>
                @if ($product->category !='Watch')
                    
                    <select name="size" id="size">
                        <option value="">Select size</option>
                        <option value="xxl">XXL</option>
                        <option value="xl">XL</option>
                        <option value="l">L</option>
                        <option value="m">M</option>
                        <option value="s">S</option>
                        <option value="xs">XS</option>
                    </select>
                @endif
                <input type="number" name="quantity" id="quantity" value="1" min="1">
                <button href="" class="btn add_to_cart">Add to cart</button>

                <h3>Product details <i class="fa-solid fa-indent"></i>
                </h3>
                <br>
              
                <p>
                    @foreach ($pieces as $description)
                        {{ $description }}<br>
                    @endforeach
                </p>
            </div>
        </div>
    </div>
    <!-- title -->
    <div class="small-container">
        <div class="row row-2">
            <h2>Related products</h2>
            <p>View more</p>
        </div>
    </div>
    <!-- ------product------- -->
    <div class="small-container">
        <div class="row related-products">
           
           
        </div>
    </div>
    <!-- -------footer--- -->
    @include('user.footer')
    <!-- js for toggle menu -->
  @include('user.script')

  <script>
    function changeThumbnail(image){
        document.getElementById('ProductImg').src = image;
    }
  </script>
  
    <script>

           
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

     
    fetchCart();
    fetchRelatedProducts();

         function fetchRelatedProducts(){

            var data = {
               'id': $('.productID').val(),
            }
            console.log(data);
            $.ajax({
                type:"GET",
                url:"/related_products",
                data: data,
                dataType: 'json',
                success: function (response){
                    $('.related-products').html('');
                   console.log(response.products);
                   $.each(response.products, function(key,item){
                    
                        $('.related-products').append('<div class="col-4">\
                        \
                         <img  src="'+item.image+'">\
                     \
                        <a href ="http://127.0.0.1:8000/product_details/'+item.id+'"><h4 ">'+item.title+'</h4></a>    \
                      \
                            <p>$'+item.price+'</p>\
                        </div>');
                    })
                }
            });
         }
        
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
   

      $(document).ready(function(){
       
        
        $(document).on('click', '.add_to_cart',function(e){
            var size = null;
            if($('#size').length != 0){
                size = $('#size').val();
            }
            e.preventDefault();
            var data = {
                'productID' : $('.productID').val(),
                'userID' : $('.userID').val(),
                'quantity' : $('#quantity').val(),
                'size' : size,
            }
            console.log(data);

            $.ajax({
                type:"POST",
                  url:"/add_to_cart",
                  data: data,
                  dataType:"json",

                    success: function(response){
                        console.log(response.data);
                        console.log(response.data1);
                        console.log('added')
                        swal("Added!", "Product(s) added to cart successfully!", "success");
                        fetchCart();
                    }
            });
        });


        $(document).on('click','product-details1',function(e){
            e.preventDefault();
            // var id = $(this).val(),
         
            // window.location.replace("http://127.0.0.1:8000/product_details/"+id);
        })



      });


    </script>

      
</body>

</html>