<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $dates =  ['created_at', 'updated_at'];
    protected $fillable = ['id', 'product_id', 'created_at', 'updated_at'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function getList(){
        $sales = DB::table('sales')->get();
        return $sales;
    }

    public function registProduct($data) {
        // 登録処理
        DB::table('products')->insert([
            'product_name' => $data->input('product_name'),
            'company_id' => $data->input('company_id'),
            'price' => $data->input('price'),
            'stock' => $data->input('stock'),
            'comment' => $data->input('comment'),
        ]);
    }
}
