<?php

namespace App\Http\Controllers;

use App\Jobs\ProductLiked;
use App\Models\Product;
use App\Models\ProductUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function like(Request $request, $id)
    {
        $getUser = Http::withHeaders([
                'X-Requested-With' => 'XMLHttpRequest'
            ])
            ->get("http://admin_app:8000/api/user");

        if( $getUser->status() != 200 ) throw new NotFoundHttpException("User not found");

        $user = $getUser->json();

        try {
            ProductUser::create([
                'user_id' => $user['id'],
                'product_id' => $id,
            ]);

            $product = Product::find($id);
            $product->likes = $product->likes + 1;
            $product->save();

            ProductLiked::dispatch($product->toArray())->onQueue('admin-queue');

            return response()->json(['message' => 'success']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'You already like this product'], Response::HTTP_BAD_REQUEST);
        }
    }
}
