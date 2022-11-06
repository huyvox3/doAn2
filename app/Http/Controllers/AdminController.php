<?php

namespace App\Http\Controllers;


use App\Models\cart;
use App\Models\User;
use App\Models\order;
use App\Models\products;
use App\Models\order_line;
use App\Models\category;
use  Notifications;


use App\Notifications\MyFirstNotification;
use App\Notifications\OrderIsCanceled;
use App\Notifications\OrderIsCompleted;
use App\Notifications\OrderIsShipped;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AdminController extends Controller
{
    public function adminHome(){
        $products = products::all();
        $users = User::where('userType', '=',0)->get();
        $orders = Order::all();
        $revenue = order::where('status','=','Completed')->get()->sum('total') ;
        $delivery = order::where('status','=','Delivering')->get()->count();
        $processing = order::where('status','=','Processing')->get()->count();
       
        if(Auth::user()->userType == 1){

            return view('admin.home',compact('products','users','orders','revenue','delivery','processing'));
        }else{
            return redirect()->back();
        }
    }
    //Product
    public function createProduct( Request $request){

        $product = new Products();
        $product->title = $request->title;
        $product->description=$request->description;
        $product->category = $request->category;
        $product->price = $request->price;
        
        $img = array();
        if($files = $request->file('image')){
            foreach ($files as $file){
                $img_name = md5(rand(1000,10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $img_fname = $img_name.'.'.$ext;
                $upload_path = 'public/products/';

                $img_url = $upload_path.$img_fname;
                $file->move($upload_path, $img_fname);
                $img[] = $img_url;
            }

        }

        $product->image = implode('|',$img);

        $product->save();
        return redirect()->back()->with('message','Product added successfully');
    }
    public function showProduct(){
        $data = products::all();
        return view('admin.show_products',compact('data'));
    }
    public function addProduct(){

        $data = category::all();
        return view('admin.add_product',compact('data'));
    }

    public function deleteProduct($id){
        $product = products::find($id)  ;
        $product->delete();
        return redirect()->back();
    }

    //Category
    public function viewCategory(){

        $data = category::all();
        return response()->json([
            'categories' => $data,
        ]);
    }
    public function category(){
        return view('admin.category');
    }
    public function deleteCategory(Request $request){
        $validator = Validator::make($request->all(),[
            'id'=>'required|max:191',
       ]);

       if($validator->fails()){
           return response()->json([
               'status'=>'400',
               'errors'=>$validator->messages(), 
           ]);
       }
       else{
           $category = category::find($request->input('id'));

          
           $category->delete();
           return response()->json([
            'status'=>200,
            'message'=>'Category added successfully.',
            ]);
          
       }
    }
    public function addCategory( Request $request){

        $validator = Validator::make($request->all(),[
             'title'=>'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>'400',
                'errors'=>$validator->messages(), 
            ]);
        }
        else{
            $category = new category();

            $category->title = $request->input('title');
            
            $category->save();

            return response()->json([
                'status'=>200,
                'message'=>'Category added successfully.',
            ]);
        }

        // return redirect()->back()->with('message','Category added successfully');

    }

    //Order
    public function orders(){
        return view('admin.orders');
    }

    public function orderDetails(){
        $data = order::all();
       
        return response()->json([
            'data' => $data,
           
        ]);
    }
    public function getName(Request $request){
        $name = User::find($request->input('id'))->name;

        
        return response()->json([
            'name' => $name,
        ]);
    }


    public function confirmShip(Request $request){

        $order = order::find($request->input('productID'));
        $order->status = 'Delivering';
        $order->save();
        return response()->json([
            'message' => 'success',
            'userID' => $order->userID,
        ]);
    }

    public function completeOrder(Request $request){
        $order = order::find($request->input('productID'));
        $order->status = 'Completed';
        $order->save();
        return response()->json([
            'message' => 'success',
            'userID' => $order->userID,
        ]);
    }


    public function cancelOrder(Request $request){
        $order = order::find($request->input('productID'));
        $order->status = 'Canceled';
        $order->save();
        return response()->json([
            'message' => 'success',
            'userID' => $order->userID,
        ]);
    }
    public function sendEmail(Request $request){

        $user = User::find($request->input('userID'));
        $order = order::find($request->input('orderID'));
         if($request->input('message') == 'confirm ship') {$user->notify(new OrderIsShipped($user,$order));
         };
         if($request->input('message') == 'complete order'){

            $user->notify(new OrderIsCompleted($user,$order));
         };

         if($request->input('message') == 'cancel order'){
            $user->notify(new OrderIsCanceled($user,$order));
         };

         return response()->json([
            'message' => 'success',
         ]);
    }
    
}
