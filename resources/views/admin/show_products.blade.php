<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
   @include('admin.css')
   <base href="/public">
   <title>Admin Home</title>

  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        @include('admin.header')
        <!-- partial -->
        <div class="main-panel">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
             @endif
            <div class="content-wrapper" style="background-color: rgb(25, 28, 36)">
                <div class="div_center">
                    <h1 class="font_size bg-gradient">Add Product</h1>
    
                   <div >
                    <table class="center table table-bordered " style="color:#7DBDBD; ">
                        <thead class="thead-dark">
                            <tr style="border-bottom: solid  rgb(125, 189, 189) 3px">

                                <th scope="col">Title</th>
                               
                                <th scope="col">Category</th>
                                <th scope="col">Price</th>
                                <th scope="col">Images</th>
                               <th scope="col">Action</th>
                            </tr>
                          </thead>
                       
                       
                        @foreach ($data as $product)
                            <tr>
                                <td>
                                    {{ $product->title }}
                                </td>

                              

                                <td>
                                    {{ $product->category }}
                                </td>

                                <td>
                                    ${{ $product->price }}
                                </td>

                                   @php
                                        $img = $product->image;
                                        $imgs = explode('|',$img);

                                   @endphp

                               <td style="margin-left: 3em">
                                    @foreach ($imgs as $item )
                                        <img src="{{ URL::to($item) }}" style="border-radius: 6px;height:120px; width: 120px" alt="{{ $item }}">
                                        
                                    @endforeach
                               </td>

                                <td>
                                    <a onclick="return confirm('Are you sure to delete this')" class="btn btn-danger" href="{{ url('delete_product',$product->id) }}">Delete</a>
                                    
                                </td>
                            </tr>
    
                        @endforeach
                       
                    </table>
                   </div>
                </div>
            </div>
        </div>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    @include('admin.footer')
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>