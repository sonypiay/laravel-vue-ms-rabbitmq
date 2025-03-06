<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required']
        ]);
        
        $result = Product::create([
            'title' => $request->title,
            'image' => $request->image,
        ]);

        return Response::json($result, HttpFoundationResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required']
        ]);
        
        $product = Product::find($id);
        if( ! $product ) throw new NotFoundHttpException("Product not found");

        $product->title = $request->title;
        $product->image = $request->image ?? $product->image;
        $product->save();

        return Response::json($product, HttpFoundationResponse::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        Product::where('id', $id)->delete();
        return Response::json(['message' => 'Product successfully deleted'], HttpFoundationResponse::HTTP_OK);
    }
}
