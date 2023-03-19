<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->get();

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $attributes = $request->validated();
        $attributes['path'] = $request->file('path')->storePublicly('/');
        $product = Product::create($attributes);

        return ProductResource::make($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $attributes = $request->validated();
        if ($request->has('path')) {
            $attributes['path'] = $request->file('path')->storePublicly('/');
        }

        $product = tap($product)->update($attributes);

        return ProductResource::make($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
