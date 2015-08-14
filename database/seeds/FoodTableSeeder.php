<?php


use App\Food;  
use Illuminate\Database\Seeder;

class FoodTableSeeder extends Seeder  
{
    public function run()
    {

        Food::create([
            'name' => 'soup',
            'category' => 'starter',
            'price' => 120.00,
            'quantity' => 50
        Food::create([
            'name' => 'Pakoras',
            'category' => 'starter',
            'price' => 220.00,
            'quantity' => 50 
        ]);
        Food::create([
            'name' => 'Briyani',
            'category' => 'main_course',
            'price' => 300.00,
            'quantity' => 50
        ]);
        Food::create([
            'name' => 'Thali',
            'category' => 'main_course',
            'price' => 500.00,
            'quantity' => 50
        ]);
        Food::create([
            'name' => 'Rasmalai',
            'category' => 'dessert',
            'price' => 110.00,
            'quantity' => 50
        ]);
       Food::create([
            'name' => 'Kulfi',
            'category' => 'dessert',
            'price' => 60.00,
            'quantity' => 50
        ]);
    }
}
?>
