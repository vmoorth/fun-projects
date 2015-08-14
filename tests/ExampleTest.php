<?php

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Wow...');
    }

    /**
     * FoodController 
     *
     */
    public function testGetFood()
    {
        $this->get('/api/food')
             ->seeJson([
                'name' => 'soup',
             ]);

         $response = $this->call('GET', '/api/food');

         $this->assertEquals(200, $response->status());

    }

   /**
    *
    *  OrderController 
    *
    */
    public function testCreateOrder(){

    $param =  array (
     "email"=> "vim@kar.com",
     "address"=> "Apt 123, Bangalore",
     "phone"=> "9455545888",
     "items" => array ( 
        "food_id" => 1,
        "ordered_quantity" => 1
        )
      );

       $response = $this->call('POST', '/api/order', $param);
       $this->assertEquals(200, $response->status());


      //Parameter Validation
      //EMail Format incorrect

      $param =  array (
      "email"=> "vimkom",
      "address"=> "Apt 123, Bangalore",
      "phone"=> "9455545888",
      "items" => array (
        "food_id" => 1,
        "ordered_quantity" => 1
        )
      );

      $response = $this->call('POST', '/api/order', $param);
      $this->assertEquals(200, $response->status());
      $content = $response->content();
      $this->assertEquals('{"response":"failure","message":{"email":["The email must be a valid email address."]}}', $response->content());
    
       
     //Missing required parameters

      $param =  array (
      "address"=> "Apt 123, Bangalore",
      "phone"=> "9455545888"
      );

       $response = $this->call('POST', '/api/order', $param);
       $this->assertEquals(200, $response->status());
       $content = json_decode($response->content());
       $this->assertEquals("failure", $content->response);

   }


    public function testUpdateOrder(){

      $param =  array (
                "email"=> "vim@kar.com"
      );

      $response = $this->call('PUT', '/api/order/1', $param);
      $this->assertEquals(200, $response->status());


    //Invalid order id passed
      $response = $this->call('PUT', '/api/order/11111111', $param);
      $this->assertEquals(200, $response->status());
      $content = json_decode($response->content());
      $this->assertEquals("failure", $content->response);
      $this->assertEquals("Order with id:11111111 does not exist", $content->message);
   }

}
