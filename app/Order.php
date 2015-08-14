<?php namespace App;

use Illuminate\Database\Eloquent\Model;
 
 
 class Order extends Model
 {
     
     protected $fillable = array('email','status','address','phone','delivery_charge','item_total', 'payment_type','payment_recieved');

     
 }

?>
