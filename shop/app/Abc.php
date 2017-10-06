<?php


namespace App;

use Config;
use DB;
use App;

use Illuminate\Database\Eloquent\Model;


class Abc extends Model
{
	protected $table = 'product';
    protected $fillable = ['category', 'product','discount', 'price'];
	protected $database;
	/**
	 * The on the fly database connection.
	 *
	 * @var \Illuminate\Database\Connection
	 */
	protected $connection;
	public function saveproduct($sid,$data)
	{
		$shop = DB::table('shops')
				->select('db_name')
				->where('id', $sid)->first();
		$dn_name=$shop->db_name;
		//echo $dn_name;die;
		//$this->configureConnectionByName($dn_name);
		$product_id=DB::table('product')->insertGetId(
				[
				'category' => $data->category, 
				'product' => $data->product, 
				'discount' => $data->discount, 
				'price' => $data->price
				
				]
			);
		return $product_id;
	}
	
}
