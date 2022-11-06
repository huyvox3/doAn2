<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.css')
    <title>{{ $title }}</title>
    <base href="/public">
</head>

<body>
    @include('user.header1')
    <!-- featured categories -->
    <div class="small-container">
        <div class="row row-2">
            <h2 style="font-size: 3em">{{ $category }}</h2>
            {{-- <select name="" id="">
                <option value="">Default sorting</option>
                <option value="">Sort by price</option>
                <option value="">Sort by name</option>
                <option value="">Sort by popularity</option>
                <option value="">Sort by rating</option>
                <option value="">Sort by sale</option>
            </select> --}}
        </div>
        <div class="row">
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
</body>

</html>