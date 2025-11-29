<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $products = Product::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('type', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => number_format($product->price, 2),
                    'type' => ucfirst($product->type ?? 'Other'),
                    'stock' => $product->stock_quantity,
                    'image' => $product->image ? asset('storage/' . $product->image) : asset('admin/images/thumb-bananas.png'),
                ];
            });

        return response()->json($products);
    }

    public function results(Request $request)
    {
        $query = $request->input('q');
        
        $products = Product::where('is_active', true)
            ->when($query, function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('type', 'LIKE', "%{$query}%");
            })
            ->paginate(12);

        return view('search.results', compact('products', 'query'));
    }
}
