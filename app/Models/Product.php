<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use Sortable;
    
    public function getList($keyword, $company_search){
        $products = Product::
            join('companies','products.company_id','=','companies.id')
            ->select('products.*','companies.company_name');

        
        if($keyword){
            $products->where('products.product_name', 'like', "%{$keyword}%");
        }
        if($company_search){
            $products->where('products.company_id', '=', $company_search);
        }

        $productsList = $products->sortable()->get();
        
        return $productsList;
    }

    public function registProduct($data, $img_path) {
        // 登録処理
        DB::table('products')->insert([
            'product_name' => $data->input('product_name'),
            'company_id' => $data->input('company_id'),
            'price' => $data->input('price'),
            'stock' => $data->input('stock'),
            'comment' => $data->input('comment'),
            'img_path' => $img_path
        ]);
    }

    public function getUserNameById()
    {
        return DB::table('products')
                ->join('products', 'product', '=', 'company')
                ->get();
    }

    public function deleteP($id) {
        DB::table('products')
            ->where('id', '=', $id)
            ->delete();
    }

    public function getProductByID($id){
        $products = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name')
            ->where('products.id', '=', $id)
            ->first();

        return $products;
    }

    public function registEdit($request, $img_path, $id) {
        DB::table('products')
        ->where('products.id', '=', $id)
        ->update([
            'product_name' => $request->input('product_name'),
            'company_id' => $request->input('company_id'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'comment' => $request->input('comment'),
            'img_path' => $img_path
        ]);
    }

    public function registEditNoImg($request, $id) {
        DB::table('products')
        ->where('products.id', '=', $id)
        ->update([
            'product_name' => $request->input('product_name'),
            'company_id' => $request->input('company_id'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'comment' => $request->input('comment'),
        ]);
    }
}
