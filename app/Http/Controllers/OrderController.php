<?php

namespace App\Http\Controllers;
  
use Event;
use Log;
use Validator;
use App\Food;
use App\Order;
use App\Order_detail;
use App\Events\OrderPlaced;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  
  
class OrderController extends Controller{

public function index(){
 
        $orders  = Order::all();
 
        return response()->json($orders);
 
    }
 
    public function getOrder($id){
 
        $order  = Order::find($id);
 
        return response()->json($order);
    }

    public function deleteOrder($id) {
      
        $order = Order::find($id);
        if ($order) {
          $order->delete();
          Log::info('OrderController.deleteOrder');
          return response()->json(['response' => 'success' ]); 
        }
        return response()->json(['response' => 'failure', 'message' => 'Order not found'.$id]);

    }

    public function createOrder(Request $request) {

         Log::info('OrderController.createOrder:');
         $validator = Validator::make($request->all(), [
                       'email' => 'required|email',
                       'address'  => 'required',
                       'phone'  => 'required|size:10',
                       'delivery_charges'  => 'sometimes',
                       'payment_type' => 'sometimes|in:cod,online',
                       'items'  => 'required' //Need to validate that item has two fields 
        ]);

        if ($validator->fails()) {
           return response()->json(['response' => 'failure', 'message' => $validator->errors()]);
        }
 
        $order = Order::create($request->all());
        $order_id = $order->id;
        $total_amount = 0;
        $msg = "";
        if ($request->has('items'))
        {
           $input = $request->input('items');
           foreach ($input as $i) {
          //Check whether the food item exists
                $food = Food::find($i['food_id']);
                if (!$food || ($food->quantity < $i['ordered_quantity']) ) {
                   $msg .= "Item ". $i['food_id']. " is not available.";                   
                   //return response()->json(['response' => 'failure', 'message' => $msg, 'order' => $order]);    
                }
                else {
                    //Add items to the order 
           		$i['order_id'] = $order_id;
            		$order_detail = Order_detail::create($i);
                	$total_amount += $food->price * $i['ordered_quantity'];
                   //Update quantity in food table
         	        $food->quantity = $food->quantity - $i['ordered_quantity'];
               		$food->save(); 
               }
            } 
        
        }
         if ($total_amount > 0) {
         $order->item_total = $total_amount ;
         $order->status = 'placed';
         $order->save();
         Event::fire(new OrderPlaced($order));
         Log::info('Order placed', ['id' => $order->id]);
         
         return response()->json(['response' => 'success', 'message' => $msg, 'order' => $order]); 
         }
         else {
            //Delete the order record as none of the items are available
            
             $order->delete();
             Log::info('Order Deleted as items are not available', ['id' => $order_id]);
             return response()->json(['response' => 'failure', 'message' => $msg]);
         }
   }

   public function updateOrder(Request $request,$id) {

        Log::info('OrderController:updateOrder:');
        $validator = Validator::make($request->all(), [
                       'email' => 'sometimes|email',
                       'address'  => 'sometimes',
                       'phone'  => 'sometimes|size:10',
                       'delivery_charges'  => 'sometimes',
                       'payment_type' => 'sometimes|in:cod,online',
                       'payment_recieved' => 'sometimes|boolean',
                       'status' => 'sometimes|in:on_the_way,delivered'
        ]);

        if ($validator->fails()) {
           return response()->json(['response' => 'failure', 'message' => $validator->errors()]);
        }
        
        $order = Order::find($id);
        if (!$order) {
           return response()->json(['response' => 'failure', 'message' => 'Order with id:'.$id.' does not exist']); 
        }
        if ($request->has('email' )) {
            $order->email = $request->input('email'); 
        }
        
        if ($request->has('address' )) {
            $order->address = $request->input('address');
        }
        if ($request->has('phone' )) {
            $order->phone = $request->input('phone');
        }
        
        if ($request->has('delivery_charges' )) {
            $order->delivery_charges = $request->input('delivery_charges');
        }
        if ($request->has('payment_type' )) {
            $order->payment_type = $request->input('payment_type');
        }
        if ($request->has('payment_recieved' )) {
            $order->payment_recieved = $request->input('payment_recieved');
        }
        if ($request->has('status' )) { 
            $order->status = $request->input('status');
            if ($request->input('status') == 'delivered')
               $order->delivered_at = date("Y-m-d H:i:s"); 
        }
        $order->save();
        Log::info('OrderController.update : Order saved');
       // Event::fire(new OrderPlaced($order));
        return response()->json(['response' => 'success', 'message' => 'Order Updated', 'order' => $order]);

/*
        if ($request->has('items'))
        {
           $order_id = $id;
           $input = $request->input('items');
           foreach ($input as $i) {
                $order_detail = Order_detail::find($i['food_id'],$order_id);
                $order_detail->ordered_quantity = $i['ordered_quantity'];
            }
        }
*/

 }


}
?>
