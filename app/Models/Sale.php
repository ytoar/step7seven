<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function getList(){
        $sales = DB::table('sales')->get();
        return $sales;
    }

    public function registProduct($data) {
        // 登録処理
        DB::table('product')->insert([
            'title' => $data->title,
            'url' => $data->url,
            'comment' => $data->comment,
        ]);
    }
}
