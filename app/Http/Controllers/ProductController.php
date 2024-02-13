<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use Exception;
use PhpParser\Node\Expr\New_;

class ProductController extends Controller
{
    public function showList(Request $request) {
        $keyword = $request->input('keyword');
        $company_search = $request->input('company_search');

        $model = new Product();
        $products = $model->getList($keyword, $company_search);
        $company_model = new Company();
        $companies = DB::table('companies')->get();

        return view('product', ['products' => $products, 'companies' => $companies]);
    }

    public function index(){
        $products = Product::sortable()->get(); //sortable() を先に宣言
        return view('products.index')->with('products', $products);
    }

    public function showRegistForm() {
        $companies = DB::table('companies')->get();

        return view('regist', compact('companies'));
    }

    public function registSubmit(ProductRequest $request) {

        // トランザクション開始
        DB::beginTransaction();
    
        try {
            // 登録処理呼び出し
            $model = new Product();
            $model->registProduct($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        try{
            $image = $request->file('img_path');
            if($image){
                $filename = $image->getClientOriginalName();
                $image->storeAs('public/images', $filename);
                $img_path = 'storage/images/'.$filename;
                $model->registEdit($request, $img_path, $id);
            }else{
                $model->registEditNoImg($request, $id);
            }
            DB::commit();
            return redirect(route('detail', ['id' => $id]));
        }catch(Exception $e){
            DB::rollBack();
            return back();
        }

        // 処理が完了したらregistにリダイレクト
        return redirect(route('regist'))->with('success','商品が登録されました！');
    }
    
    public function deleteProduct($id) {
        $model = new Product();
        $products = $model->deleteP($id);
        return redirect()->route('list');
    }
    
    public function showDetail($id){
        $model = new Product();
        $product = $model->getProductByID($id);
        return view('detail', ['product' => $product]);
    }

    public function showEdit($id){
        $companies = DB::table('companies')->get();
        $model = New Product;
        $product = $model->getProductByID($id);
        return view('edit', ['companies' => $companies, 'product' => $product]);
    }

    public function registEdit(ProductRequest $request, $id){
        $model = New Product();
        DB::beginTransaction();
        try{
            $image = $request->file('img_path');
            if($image){
                $filename = $image->getClientOriginalName();
                $image->storeAs('public/images', $filename);
                $img_path = 'storage/images/'.$filename;
                $model->registEdit($request, $img_path, $id);
            }else{
                $model->registEditNoImg($request, $id);
            }

            DB::commit();
            return redirect(route('detail', ['id' => $id]));
        }catch(Exception $e){
            DB::rollBack();
            return back();
        }
    }
}
