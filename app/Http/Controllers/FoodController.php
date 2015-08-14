<?php

namespace App\Http\Controllers;
  
use App\Food;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  
  
class FoodController extends Controller{

public function index(){
 
        $foods  = Food::all();
 
        return response()->json($foods);
 
    }
 
    public function getFood($id){
 
        $food  = Food::find($id);
 
        return response()->json($food);
    }
 
}

?>
