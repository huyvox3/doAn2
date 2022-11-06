<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
   @include('admin.css')
   <base href="/public">
   <title>Admin Home</title>
    <style>
      
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
                  <h1 class="font_size bg-gradient">Category</h1>
    
                   <div style="margin-bottom: 2em" >

                           
                            {{-- <input type="text" class ="name"name = "name" placeholder="Enter the category name">
                            <button type="submit" class="btn btn-primary add_category" name="submit">Add</button> --}}
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                             Add Category
                            </button>
                            
                            <!-- Modal -->

                            <div style="color:#7DBDBD !important" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                              
                                <div class="noti">
                                </div>
                                <div style="background-color:#7DBDBD;color: white" class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Add</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="form-group mb-3">
                                      <label for="title">Title</label>
                                      <input id="title-input" style="background-color:#fff" type="text" class="title form-control">
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary add_category">Save</button>
                                  </div>
                                </div>
                                
                              </div>
                            </div>

                            
                           
                  
                   </div>
                  

                   <table class="center table table-bordered " style="color:#7DBDBD; ">
                    <thead class="thead-dark">
                      <tr style="border-bottom: solid  rgb(125, 189, 189) 3px">

                          <th scope="col">Category Name</th>
                         
                          <th scope="col">Action</th>
                         
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                
                   
                    {{-- @foreach ($data as $item  )
                        <tr>
                            <td>
                                {{ $item->title }}
                            </td>
                            <td>
                                <a onclick="return confirm('Are you sure to delete this')" class="btn btn-danger" href="{{ url('delete_category',$item->id) }}">Delete</a>
                                
                            </td>
                        </tr>

                    @endforeach
                    --}}
                </table>
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
    <script>
       
        
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $(document).ready(function(){


        

          function fetchCategory(){
              $.ajax({
                  type:"GET",
                  url:"/view_category",
                  dataType:"json",
                  success: function(response){
                      // console.log(response.categories);
                      $('tbody').html('');
                      $.each(response.categories, function(key, item){
                          $('tbody').append('<tr><td>'+item.title+'</td><td><button class="btn btn-danger delete_category id" value = "'+item.id+'">Delete</button></td></tr>');
                      });
                  }
              });
          }


          fetchCategory();
          
          $(document).on('click','.add_category',function(e){
              e.preventDefault();
              var data = {
                  'title': $('.title').val(),
              }
              console.log(data);
              $.ajax({
                  type:"POST",
                  url:"/add_category",
                  data: data,
                  dataType:"json",
                  success:function(response){
                      if(response.status == 400) {
                          $('.noti').html('');
                          $('.noti').addClass('alert alert-danger');
                          $('.noti').html('Category added failed');
                      }
                      else{
                          $('.noti').html('');
                          $('.noti').addClass('alert alert-success');
                          $('.noti').html('Category added successfully');
                         
                      }
                      document.getElementById("title-input").value = "";
                      fetchCategory();
                  }

               });
      

          });

          $(document).on('click','.delete_category',function(e){
            e.preventDefault();
           
            var data = {
              'id' : $(this).val(),
            };
            console.log(data);
            $.ajax({
              type:"GET",
              url:"/delete_category",
              data:data,
              dataType:"json",
              success:function(response){
                  if(response.status == 400) {
                            $('.noti').html('');
                            $('.noti').addClass('alert alert-danger');
                            $('.noti').html('Category added failed');
                  }
                  else{
                            $('.noti').html('');
                            $('.noti').addClass('alert alert-success');
                            $('.noti').html('Category deleted successfully');
                          
                  }
                  fetchCategory();
              }
            })
          });

            
              //     function showCategory(){
              //         $.ajax{
              //             type:"GET",
              //             url:'show_category',
              //             data: 'data',
              //             dataType
              //         }
              //     }
              
              // });
      });
  
  </script>
  </body>
</html>