<?php namespace App;

use Illuminate\Database\Eloquent\Model;
 
 
 class Order_detail extends Model
 {
     
     protected $fillable = ['order_id','food_id','ordered_quantity'];
     
 }

?>
