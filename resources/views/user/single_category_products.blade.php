<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.css')
    <style>
        .search{
            width: 70%;
            text-align: center;
            padding: 2em 0 ;

           
        };

       
    </style>
    <title>{{ $title }}</title>
    <base href="/public">
</head>

<body>
    @include('user.header1')
    <!-- featured categories -->
    <div class="small-container">
        <div class="row row-2">

            <div class="search">
                <input style="width: 60em; border-radius: 6px; " type="search" name="search" id = "search" placeholder="Search for product(s)" class="form-control ">
            </div>
        </div>
        <div class="row row-2">
            <h2 class="category-name-h2" style="font-size: 3em" >{{ $category }}</h2>
           
        </div>
        <div class="row products-row">
            @foreach ($data as $product)
                @php
                     $img = $product->image;
                      $thumbnail = explode('|',$img)[0];

                @endphp
                     

                     
                
                <div class="col-4">
                    <a href="{{ url('product_details',$product->id) }}"><img src="{{ $thumbnail }}"></a>
                    <a href="">
                        <h4>{{ $product->title }}</h4>
                    </a>
                    <div class="rating">
                        {{-- <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half"></i> --}}
                    </div>
                    <p>${{ $product->price }}.00</p>
                </div>
            @endforeach
           
        </div>
        <span    >
            {!! $data->withQueryString()->links('pagination::bootstrap-5')!!}
        </span>
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

      $('#search').on('keyup', function(){
       var data = {
            'title': $(this).val(),
            'category': $('.category-name-h2').html(),
       }
     
       
        $.ajax({
            type:'GET',
            url: '/searchProducts',
            data: data,
            dataType: 'json',
          
            success: function(response){
                
                $('.products-row').html('');
                $.each(response.products, function(key,item){
                    var thumbnail = item.image.split('|')[0];
                   
                   $('.products-row').append("<div class='col-4'>\
                            <a href='http://127.0.0.1:8000/product_details/"+item.id+"'><img src="+thumbnail+"></a>\
                            <a href='http://127.0.0.1:8000/product_details/"+item.id+"'>\
                                <h4>"+item.title+"</h4>\
                            </a>\
                          \
                            <p>$"+item.price+".00</p>\
                    </div>'");
                })
            }   

           
        })
      })
</script>
</body>

</html>