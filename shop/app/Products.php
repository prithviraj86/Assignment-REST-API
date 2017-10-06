<?php


namespace App;

use Config;
use DB;
use App;

use Illuminate\Database\Eloquent\Model;


class Products extends Model
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
		$db_name=$this->getdb($sid);
		
		//echo $dn_name;die;
		//$this->configureConnectionByName($dn_name);
		$this->configDB($db_name);
		$product_id=DB::connection('mysql_'.$db_name)->table('product')->insertGetId(
				[
				'category' => $data->category, 
				'product' => $data->product, 
				'discount' => $data->discount, 
				'price' => $data->price
				
				]
			);
		DB::connection('mysql')->table('shops')->whereId($sid)->increment('requests');
		return $product_id;
	}
	public function getProducts($sid)
	{
		$shop = DB::table('shops')
				->select('db_name')
				->where('id', $sid)->first();
		$db_name=$this->getdb($sid);
		$this->configDB($db_name);
		return DB::connection('mysql_'.$db_name)->table('product')->get();
	}
	public function updateProduct($sid,$pid,$data)
	{
		
		$db_name=$this->getdb($sid);
		$this->configDB($db_name);
		$result=DB::connection('mysql_'.$db_name)->table('product')
		->where('id', $pid)
		->update([
					'category' => $data->category, 
					'product' => $data->product, 
					'discount' => $data->discount, 
					'price' => $data->price
				  ]);
		DB::connection('mysql')->table('shops')->whereId($sid)->increment('requests');
		return $result;
	}
	public function deleteProduct($sid,$pid)
	{
		
		$db_name=$this->getdb($sid);
		$this->configDB($db_name);
		$result=DB::connection('mysql_'.$db_name)->table('product')
		->where('id',$pid)->delete();
		DB::connection('mysql')->table('shops')->whereId($sid)->increment('requests');
		return $result;
	}
	public function configDB($db_name)
	{
		Config::set('database.connections.mysql'.'_'.$db_name, array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => $db_name,
			'username'  => 'root',
			'password'  => '',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		));
	}
	public function getdb($sid)
	{
		$shop = DB::table('shops')
				->select('db_name')
				->where('id', $sid)->first();
		return $shop->db_name;
	}
}
