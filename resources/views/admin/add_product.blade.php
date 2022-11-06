<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
   @include('admin.css')
   <base href="/public">
   <title>Admin Home</title>
    <style>
        .card-body {
        border-radius: 6px;
        border: 1px solid   rgb(125, 189, 189);
        }
        .div_center{
            text-align: center;
            padding-top: 2em;
            
        }
        
        .font_size{
            font-size:2em;
            padding-bottom: 2em; 
        }
       
      
       .text_color{
        color: #57619E
       }
       label{
        display: inline-block;
        width: 9em;
       }
       .product-info{
        margin: 0 auto;
        padding-bottom: 1em;
        text-align: left;
       }
      
    </style>
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
    
                   <div class="d-flex justify-content-center" >
                        <form action="{{ url('/create_product') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="product-info">
                                <label>Title:</label>
                                <input type="text" name="title" class="text_color" required="" placeholder="Enter Title.">
                            </div>
        
                            <div class="product-info">
                                <label>Description:</label>
                                <input type="text" name="description" class="text_color" required="" placeholder="Enter Description.">
                            </div>
        
                           
                            <div class="product-info">
                                <label>Category:</label>
                                <select required="" name="category" class="text_color">
                                    <option value="" selected="">Choose a category</option>
                                    @foreach ($data as $category  )
                                        <option value ="{{$category->title}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
        
                           
        
                            <div class="product-info">
                                <label>Price:</label>
                                <input type="number" name="price" class="text_color" required="" placeholder="Enter Price.">
        
                            </div>
        
                           
                            
                            <div class="product-info">
                                <label>Image:</label>
                                <input  type="file" name="image[]" class="text_color"  multiple class="images">
                            </div>
        
                            <div class="product-info">
                                <input class="btn btn-success"  type="submit" value="Add Product">
                            </div>
                        </form>
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