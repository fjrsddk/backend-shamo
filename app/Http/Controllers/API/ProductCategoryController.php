<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function all(Request $request){

        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('id');
        $show_product = $request->input('show_product');

        // proses pengambilan data produk dari Model ProductCategory melalui Id
        if($id){
            $category = ProductCategory::with(['products'])->find($id); // with() merupakan fungsi query untuk mengambil relasi yang ada di dalam Model
            
            if($category){
                return ResponseFormatter::success(
                    $category,
                    'Data kategori berhasil diambil!'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data kategori tidak ada!',
                    404
                );
            }
        }

         // Pengambilan data dari Model ProductCategory melalui beberapa validasi selain Id
         $category = ProductCategory::query();

         if($name){
             $category->where(`name`, `like`, `%`, $name, `%`);
         }

         if($show_product){
            $category->with('products');
         }

         return ResponseFormatter::success(
            $category->paginate($limit),
            'Data kategori berhasil diambil!'
         );
    }
}
