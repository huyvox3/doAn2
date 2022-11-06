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
                  <h1 class="font_size bg-gradient">Orders</h1>
    
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

                          <th scope="col">ID</th>
                          <th scope="col">User ID</th>
                          <th scope="col">User Name</th>
                          <th scope="col">Payment Method</th>
                          <th scope="col">Payment Status</th>
                          <th scope="col">Status</th>
                          <th scope="col">Total</th>
                          <th scope="col">Action</th>
                         
                      </tr>
                    </thead>
                    <tbody>
                     
                    </tbody>
                
                   
                  
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

        fetchOrder();
        function fetchOrder(){
          $.ajax({
            method:"GET",
               url:"/order_admin",
               dataType:'json',
               success:function(response){
                  // console.log(response.data)
                  $('tbody').html('');
                $.each(response.data,function(key,item){
                
                  
                 
                  $('tbody').append('\
                    <tr value ="'+item.id+'">\
                        <th scope="col">'+item.id+'</th>\
                        <th scope="col">'+item.userID+'</th>\
                        <th scope="col" class ="username"></th>\
                        <th scope="col">'+item.paymentMethod+'</th>\
                        <th scope="col">'+item.paymentStatus+'</th>\
                        <th scope="col">'+item.status+'</th>\
                        <th scope="col">$'+item.total+'</th>\
                       \
                    </tr>');

                    if(item.status == 'Placed Order'){
                      $('tr[value="'+item.id+'"]').append('\
                        <th scope="col" >\
                          <button  type ="button" class = "btn btn-primary confirm-ship" value ="'+item.id+'">Ship</button>\
                          <button  type ="button" class = "btn btn-danger cancel" value ="'+item.id+'">Cancel</button>\
                          </th>\
                      \
                       \
                        ');
                    }
                    if(item.status == 'Delivering'){
                      $('tr[value="'+item.id+'"]').append('\
                        <th scope="col" >\
                          <button type ="button" class = "btn btn-success complete" value ="'+item.id+'">Complete</button>\
                          <button  type ="button" class = "btn btn-danger cancel" value ="'+item.id+'">Cancel</button>\
                      \
                          </th>\
                       \
                       \
                        ');
                    }
                    if(item.status =='Completed' ){
                      $('tr[value="'+item.id+'"]').append('\
                        <th scope="col" >\
                          <button  type ="button" class = "btn btn-primary print-invoice" value ="'+item.id+'">Print Invoice</button>\
                          \
                          </th>\
                       \
                       \
                        ');
                    }
                    userName(item.userID);
                });
               }
          })
        }

        function userName(userID){
         
          var data = {
            'id': userID,
          }
            $.ajax({
              method:"GET",
              url:"/name",
              data: data,
               dataType:'json',
               success:function(response){
                $('.username').html(response.name) ;
                
               }
            })
           
        }

        $(document).on('click','.confirm-ship',function(e){
              e.preventDefault();
              var orderID = $(this).val();
              var data = {
                'productID': $(this).val(),
                
              }
             
             
              $.ajax({
                  type:"GET",
                  url:"/confirm_ship",
                  data: data,
                  dataType:"json",
                  success:function(response){
                    fetchOrder();
                    var data1 = {
                      'orderID': orderID,
                      'userID': response.userID,
                      'message': 'confirm ship',
                    }
                    console.log(data1);
                      $.ajax({
                          type:"GET",
                          url:"/send_email",
                          data: data1 ,
                          dataType:"json",
                          success:function(response1){
                            console.log(response1.message);
                            fetchOrder();
                          }

                      });
                  }

               });
               

          });

          $(document).on('click','.complete',function(e){
              e.preventDefault();
              var orderID = $(this).val();
              console.log(orderID);
              var data = {
                'productID': $(this).val(),
                
              }
            
              $.ajax({
                  type:"GET",
                  url:"/complete_order",
                  data: data,
                  dataType:"json",
                  success:function(response){
                    fetchOrder();
                    var data1 = {
                      'orderID': orderID,
                      'userID': response.userID,
                      'message': 'complete order',
                    }
                    console.log(data1);
                      $.ajax({
                          type:"GET",
                          url:"/send_email",
                          data: data1 ,
                          dataType:"json",
                          success:function(response1){
                            console.log(response1.message);
                            fetchOrder();
                          }

                      });
                  }

               });
               

          });


          $(document).on('click','.cancel',function(e){
            var orderID = $(this).val();
              e.preventDefault();
              var data = {
                'productID': $(this).val(),
                
              }
             
              $.ajax({
                  type:"GET",
                  url:"/cancel_order",
                  data: data,
                  dataType:"json",
                  success:function(response){
                    fetchOrder();
                    var data1 = {
                      'orderID': orderID,
                      'userID': response.userID,
                      'message': 'cancel order',
                    }
                    console.log(data1);
                      $.ajax({
                          type:"GET",
                          url:"/send_email",
                          data: data1 ,
                          dataType:"json",
                          success:function(response1){
                            console.log(response1.message);
                            fetchOrder();
                          }

                      });
                  }

               });
               

          });

         

        
      });


  
  </script>
  </body>
</html>