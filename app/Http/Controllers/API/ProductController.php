<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Helpers\ResponseFormatter;

class ProductController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $category = $request->input('category');

        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        if($id) {
            $product = Product::with(['category', 'galleries'])->find($id);

            if($product) {
                return ResponseFormatter::success(
                    $product,
                    'Data produk berhasil diambil!'
                ); 
            }else {
                return ResponseFormatter::error(
                    null,
                    'Data produk tidak ada',
                    404
                ); 
            }
        }

        $product = Product::with(['category', 'galleries']);

        // Filter pencarian data berdasarkan nama
        if($name) {
            $product->where('name', 'like', '%'.$name.'%');
        }
        
        // Filter pencarian data berdasarkan description
        if($description) {
            $product->where('description', 'like', '%'.$description.'%');
        }

        // Filter pencarian data berdasarkan tags
        if($tags) {
            $product->where('tags', 'like', '%'.$tags.'%');
        }

        // Filter pencarian data berdasarkan price_from
        if($price_from) {
            $product->where('price', '>=', $price_from);
        }

        // Filter pencarian data berdasarkan price_to
        if($price_to) {
            $product->where('price', '<=', $price_to);
        }

        // Filter pencarian data berdasarkan category
        if($category) {
            $product->where('category', $category);
        }

        return ResponseFormatter::success(
            $product->paginate($limit),
            'Data produk berhasil diambil'
        );
    }
}
