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
    .content-wrapper  .footer {
        background-color:  rgb(25, 28, 36);
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
       @include('admin.body')
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