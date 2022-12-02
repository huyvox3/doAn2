<?php

namespace App\Http\Controllers;
use App\Models\cart;
use App\Models\User;
use App\Models\order;
use App\Models\products;
use Illuminate\Support\Facades\DB;
use App\Models\order_line;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Providers\PayPalServiceProvider;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class UserController extends Controller
{
    public function homePage(){
        
        $userType = Auth::user()->userType;
        
            if($userType == 1) {
                $products = products::all();
                $users = User::where('userType', '=',0)->get();
                $orders = Order::all();
                $revenue = order::where('status','=','Completed')->get()->sum('total') ;
                $delivery = order::where('status','=','Delivering')->get()->count();
                $processing = order::where('status','=','Placed Order')->get()->count();
                return view('admin.home',compact('products','users','orders','revenue','delivery','processing'));
            }
            if($userType == 0) {return view('user.home');}
            
    
    }

    
    public function loginPage(){
        return view('user.account');
    }

    //Product
    public function productPage(){

        $data = products::paginate(12);
     return view('user.products',compact('data'));   
    } 

    
    public function productDetails($id){
        
        $product = products::find($id);
      
        return view('user.product_details',compact('product'));
    }
     
    

    public function relatedProducts(Request $request){
        $product = products::find($request->input('id'));
        // $product = products::find(1);
        $products = products::where('category','=',$product->category)->where('id','!=',$product->id)->take(3)->get();
        return response()->json([
            'products'=> $products,
        ]);
    }

    public function featuresProducts(){
        $products = products::inRandomOrder()->where('id','!=','1')->take(4)->get();
        return response()->json([
            'products' => $products,
        ]);
    }

    public function latestProducts(){
        $products = products::latest()->take(8)->get();
        return response()->json([
            'products' => $products,
        ]);
    }
    public function singeCategory($category){
        $title ='Product| '.$category.'- FHDStore';
    
        $data = products::where('category','=',$category)->paginate(12);

        return view('user.single_category_products',compact('data','title','category'));
    }

    public function searchProducts(Request $request){
        
     

        if($request->title != "" && $request->title != NULL){
            if($request->category != "" && $request->category != NULL){
                $products = products::where('title','LIKE','%'.$request->title.'%')->Where('category','=',$request->category)->get();
                return response()->json([
    
                    'products' => $products,
                ]);
            }

            $products = products::where('title','LIKE','%'.$request->title.'%')->orWhere('category','LIKE','%'.$request->title.'%')->get();
            return response()->json([

                'products' => $products,
            ]);
        }
       
        if($request->category != "" && $request->category != NULL){
            $products = products::where('category','=',$request->category)->get();
            return response()->json([

                'products' => $products,
            ]);
        }
        
        $products = products::all();
        return response()->json([

            'products' => $products,
        ]);

       
    }
    //Cart
    public function cartPage(){
        return view('user.cart');
    }

    public function addToCart(Request $request){
        $validator = Validator::make($request->all(),[
            'productID' => 'required',
            'userID' => 'required',
        ]);

        $query = cart::where('userID','=',$request->input('userID'))->where('productID','=',$request->input('productID'))->where('size','=',$request->input('size'));
        $cart1 = $query->first();

       
       
        if($validator->fails()){
            return response()->json([
                'status'=>'400',
                'errors'=>$validator->messages(), 
            ]);
        }
        else{

            if($cart1 != null && $cart1->quantity != null){
               
              
                // $cart1->update([
                //     'quantity'=>$cart1->quantity + $request->input('quantity'),
                // ]);
                $cart1->quantity += $request->input('quantity');
                $cart1->save();

                return response()->json([
                    'status'=>200,
                    'message'=>'Success',
                    'data' =>$cart1->quantity,
                    'data1'=>$request->input('quantity'),
                    ]);
            
               
            }
            $product = products::find($request->input('productID'));
            $cart = new cart();

            $cart->userID = $request->input('userID');
            $cart->productID = $request->input('productID');
            $cart->product_title = $product->title;
            if($request->input('size') != null){
                $cart->size = $request->input('size');
            }
            $cart->price = $product->price;
            $cart->quantity = $request->input('quantity');
            $cart->img = explode('|',$product->image)[0];
            $cart->save();
          
            return response()->json([
             'status'=>200,
             'message'=>'Success',
             ]);
           
        }

    }
   
    public function countCart(){
        $userID =   Auth::user()->id;
        $cart = cart::where('userID','=',$userID)->get();

        $count = cart::where('userID', '=', Auth::user()->id)->get()->count();
       
        return response()->json([
            'count'=>$count,
            'data'=>$cart,
        ]);
    }


    public function cartInfo(){
        $userID =   Auth::user()->id;
        $cart = cart::where('userID','=',$userID)->get();

        return response()->json([
            'data'=>$cart,
        ]);
    }


    public function removeCartItem(Request $request){
        $validator = Validator::make($request->all(),[
            'productsID'=>'required',
       ]);

       if($validator->fails()){
            return response()->json([
                'message'=>$validator->messages(), 
            ]);
       }

       if($request->size != null){
            $product = cart::where('userID','=',Auth::user()->id)->where('productID','=',$request->input('productsID'))->where('size','=',$request->size)->first();

            $product->delete();
            return response()->json([
                'message'=>'Success',
            ]);
       }

        $product = cart::where('userID','=',Auth::user()->id)->where('productID','=',$request->input('productsID'))->first();
    
        $product->delete();

        return response()->json([
            'message'=>'Success',
        ]);
    }

    //Payment
    public function createpaypal(){
        $cart = cart::where('userID','=' ,Auth::user()->id)->get();
        return view('user.payment',compact('cart'));
    }


   
    public function processPaypal(Request $request)
    {  
        $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $cart = $request->cart;
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('processSuccess'),
                    "cancel_url" => route('processCancel'),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $request->price,
                        ]
                    ]
                ]
            ]);
    
            if (isset($response['id']) && $response['id'] != null) {
    
                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                       
                        return redirect()->away($links['href']);
                    }
                }
    
                return redirect()
                    ->route('createpaypal')
                    ->with('error', 'Something went wrong.');
    
            } else {
                return redirect()
                    ->route('createpaypal')
                    ->with('error', $response['message'] ?? 'Something went wrong.');
            }
    }
    
    
    public function processSuccess(Request $request)
    {
    
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request['token']);
    
            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
               $userID = Auth::user()->id;
                self::makeOrder($userID);
                return redirect()
                    ->route('orders')
                    ->with('success');
            } else {
                return redirect()
                    ->route('createpaypal')
                    ->with('error' );
            }
    
    }
    
     public function processCancel(Request $request)
    {
        return redirect()
            ->route('createpaypal')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
    
    //Order
    public function viewOrder(){
        return view('user.order');
    }

    public function makeOrder($userID){

        $cart = cart::where('userID','=',$userID)->get();
        $order = new order();
        $id = $order->id;
       
        $order->userID =$userID;
        $order->paymentMethod = 'PayPal';
        $order->paymentStatus = 'Paid';
        $order->status = 'Placed Order';
        $sum = 0;
        $tax = 0.2;
        $total = 0;
        $order->save();
        $id = $order->id;
       
        // $order->save();
       
        foreach($cart as $item){
            $img = explode('|',products::find($item->productID)->image)[0]; 
       
            $orderLine =  new order_line();
            $orderLine->orderID = $order->id;
            $orderLine->productID = $item->productID;
            $orderLine->title = $item->product_title;
            $orderLine->img = $img;
            $orderLine->quantity = $item->quantity;
            $orderLine->size = $item->size;
            $orderLine->price = $item->price * $item->quantity;
            $orderLine->save();
            $sum += $orderLine->price;
            $item->delete();
        }

        $tax *= $sum;

        $total += $sum + $tax;
        
       

        $change = order::find($id);
        // dd($change);
        // die();
        $change->total = $total;
        $change->tax = $tax;
        $change->subTotal = $sum;
        $change->save();
        
        
    }
    
   


    public function orderDetails(){
        // $input = $request->input('id');
        $orders = order::where('userID','=',Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'orders' => $orders,
            // 'message' =>$input,
        ]);

    }

    public function orderLines(Request $request){


        // return response()->json([
        //     'message' => $request->input('orderID'),
        // ]);

        

        $data = order_line::where('orderID','=',$request->input('orderID'))->get();
        // // $data = order_line::where('orderID','=',$request->input('id'))->get();
      
       
       
        return response()->json([
            'data'=>$data,
            'orderID'=>$request->orderID,
        ]);

    }
}
   
