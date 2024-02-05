<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function getList(){
        $companies = DB::table('companies')->get();
        return $companies;
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
