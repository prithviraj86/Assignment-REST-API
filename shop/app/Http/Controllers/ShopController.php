<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use DB;
use App;
use App\Shop;
use App\Products;

class ShopController extends Controller
{
    public function store(Request $request)
    {
		 
      $name = $request->input('name');
	  //return  $name;
      $db_name = str_replace(" ","_",strtolower($name));
      
        
		$ndb=$this->createNewdb($db_name);
		if($ndb)
		{
			$shop_id=DB::table('shops')->insertGetId(
				[
				'shop_name' => $name, 
				'db_name' => $db_name
				]
			);
			$this->configureConnectionByName($db_name);
			$this->createNewtable($db_name);
		}
		else
		{
			return response('Hello World', 200)
                  ->header('Content-Type', 'text/plain');
		}
		
		
		
		return  $shop_id;
    }
	public function storeProduct(Request $request, $sid)
    {
		 
      $data=(object)[];
      $data->category = $request->input('category');
      $data->product = $request->input('product');
      $data->discount = $request->input('discount');
      $data->price = $request->input('price');
	  
	  $proobj=new Products();
	  $proid=$proobj->saveproduct($sid,$data);
	  
		
		
		return  $proid;
    }
	public function upProduct(Request $request,$sid,$pid)
    {
		 
      $data=(object)[];
      $data->category = $request->input('category');
      $data->product = $request->input('product');
      $data->discount = $request->input('discount');
      $data->price = $request->input('price');
	  
	  $proobj=new Products();
	  $prostatus=$proobj->updateProduct($sid,$pid,$data);
	  
		
		
		return  $prostatus;
    }
	public function delProduct($sid,$pid)
    {
		 
      
	  
	  $proobj=new Products();
	  $prostatus=$proobj->deleteProduct($sid,$pid);
	  
		
		
		return  $prostatus;
    }
	public function getPro($sid)
	{
		$proobj=new Products();
		return json_encode($proobj->getProducts($sid));
		
	}
	public function createNewdb($dbName)
	{
		// We will use the `statement` method from the connection class so that
		// we have access to parameter binding.
		//$result=false;
		try {
			$result=DB::statement("CREATE DATABASE $dbName");
			// all good
		 } catch (\Illuminate\Database\QueryException $ex) {
			return dd('test', $ex->getMessage());

		} catch (PDOException $e) {
			return dd('Error', $ex->getMessage());
		}    
		return $result;
	}
	public function createNewtable($dbName)
	{
		
		Schema::connection($dbName)->create('product', function($table)
		{
			$table->increments('id');
			$table->string('category', 50);
			$table->string('product', 50);
			$table->integer('discount');
			$table->integer('price');
		});
	}
	function configureConnectionByName($tenantName)
	{
		// Just get access to the config. 
		$config = App::make('config');

		// Will contain the array of connections that appear in our database config file.
		$connections = $config->get('database.connections');

		// This line pulls out the default connection by key (by default it's `mysql`)
		$defaultConnection = $connections[$config->get('database.default')];

		// Now we simply copy the default connection information to our new connection.
		$newConnection = $defaultConnection;
		// Override the database name.
		$newConnection['database'] = $tenantName;

		// This will add our new connection to the run-time configuration for the duration of the request.
		App::make('config')->set('database.connections.'.$tenantName, $newConnection);

	}
}
