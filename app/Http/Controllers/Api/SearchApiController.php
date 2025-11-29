<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/search",
     *     operationId="searchProducts",
     *     tags={"Search"},
     *     summary="Search products",
     *     description="Search for products with various filters like keyword, category, price range, and sorting",
     *     @OA\Parameter(name="q", in="query", description="Search keyword", required=false, @OA\Schema(type="string", example="apple")),
     *     @OA\Parameter(name="category", in="query", description="Category slug", required=false, @OA\Schema(type="string", example="fruits-vegetables")),
     *     @OA\Parameter(name="type", in="query", description="Product type", required=false, @OA\Schema(type="string", example="fruits")),
     *     @OA\Parameter(name="min_price", in="query", description="Minimum price", required=false, @OA\Schema(type="number", format="float", example=5.00)),
     *     @OA\Parameter(name="max_price", in="query", description="Maximum price", required=false, @OA\Schema(type="number", format="float", example=50.00)),
     *     @OA\Parameter(name="sort", in="query", description="Sort option", required=false, @OA\Schema(type="string", enum={"latest", "price_asc", "price_desc", "name_asc", "name_desc"}, example="latest")),
     *     @OA\Parameter(name="per_page", in="query", description="Results per page", required=false, @OA\Schema(type="integer", example=12)),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="5 products found"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="query", type="string", example="apple"),
     *                 @OA\Property(property="filters", type="object"),
     *                 @OA\Property(property="products", type="array", @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Fresh Apples"),
     *                     @OA\Property(property="slug", type="string", example="fresh-apples"),
     *                     @OA\Property(property="price", type="number", example=4.99),
     *                     @OA\Property(property="formatted_price", type="string", example="$4.99"),
     *                     @OA\Property(property="in_stock", type="boolean", example=true)
     *                 )),
     *                 @OA\Property(property="pagination", type="object",
     *                     @OA\Property(property="current_page", type="integer", example=1),
     *                     @OA\Property(property="last_page", type="integer", example=1),
     *                     @OA\Property(property="per_page", type="integer", example=12),
     *                     @OA\Property(property="total", type="integer", example=5)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $categorySlug = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $type = $request->input('type');
        $sort = $request->input('sort', 'latest');
        $perPage = $request->input('per_page', 12);

        $products = Product::where('is_active', true)
            ->when($query, function ($q) use ($query) {
                $q->where(function ($q2) use ($query) {
                    $q2->where('name', 'LIKE', "%{$query}%")
                       ->orWhere('description', 'LIKE', "%{$query}%")
                       ->orWhere('type', 'LIKE', "%{$query}%");
                });
            })
            ->when($categorySlug, function ($q) use ($categorySlug) {
                $category = Category::where('slug', $categorySlug)->first();
                if ($category) {
                    $q->where('category_id', $category->id);
                }
            })
            ->when($type, function ($q) use ($type) {
                $q->where('type', $type);
            })
            ->when($minPrice, function ($q) use ($minPrice) {
                $q->where('price', '>=', $minPrice);
            })
            ->when($maxPrice, function ($q) use ($maxPrice) {
                $q->where('price', '<=', $maxPrice);
            });

        switch ($sort) {
            case 'price_asc':
                $products->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $products->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $products->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $products->orderBy('name', 'desc');
                break;
            default:
                $products->latest();
        }

        $results = $products->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => $results->total() . ' products found',
            'data' => [
                'query' => $query,
                'filters' => [
                    'category' => $categorySlug,
                    'type' => $type,
                    'min_price' => $minPrice,
                    'max_price' => $maxPrice,
                    'sort' => $sort,
                ],
                'products' => $results->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'description' => $product->description,
                        'price' => (float) $product->price,
                        'formatted_price' => '$' . number_format($product->price, 2),
                        'type' => $product->type,
                        'stock_quantity' => $product->stock_quantity,
                        'in_stock' => $product->stock_quantity > 0,
                        'image' => $product->image ? asset('storage/' . $product->image) : asset('admin/images/thumb-bananas.png'),
                        'rating' => $product->rating ?? 4.5,
                    ];
                }),
                'pagination' => [
                    'current_page' => $results->currentPage(),
                    'last_page' => $results->lastPage(),
                    'per_page' => $results->perPage(),
                    'total' => $results->total(),
                    'has_more' => $results->hasMorePages(),
                ],
            ],
        ]);
    }

    /**
     * @OA\Get(
     *     path="/search/quick",
     *     operationId="quickSearchProducts",
     *     tags={"Search"},
     *     summary="Quick search (autocomplete)",
     *     description="Get quick search results for autocomplete functionality. Returns max 8 results.",
     *     @OA\Parameter(name="q", in="query", description="Search keyword (minimum 2 characters)", required=true, @OA\Schema(type="string", example="app")),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Fresh Apples"),
     *                 @OA\Property(property="price", type="string", example="$4.99"),
     *                 @OA\Property(property="type", type="string", example="Fruits"),
     *                 @OA\Property(property="image", type="string", example="http://localhost:8000/storage/products/apple.jpg")
     *             ))
     *         )
     *     )
     * )
     */
    public function quickSearch(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }

        $products = Product::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('type', 'LIKE', "%{$query}%");
            })
            ->limit(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => '$' . number_format($product->price, 2),
                    'type' => ucfirst($product->type ?? 'Other'),
                    'image' => $product->image ? asset('storage/' . $product->image) : asset('admin/images/thumb-bananas.png'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/search/filters",
     *     operationId="getSearchFilters",
     *     tags={"Search"},
     *     summary="Get search filters",
     *     description="Get available filter options including categories, product types, price range, and sort options",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="categories", type="array", @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Fruits & Vegetables"),
     *                     @OA\Property(property="slug", type="string", example="fruits-vegetables")
     *                 )),
     *                 @OA\Property(property="types", type="array", @OA\Items(
     *                     @OA\Property(property="value", type="string", example="fruits"),
     *                     @OA\Property(property="label", type="string", example="Fruits")
     *                 )),
     *                 @OA\Property(property="price_range", type="object",
     *                     @OA\Property(property="min", type="number", example=0.99),
     *                     @OA\Property(property="max", type="number", example=99.99)
     *                 ),
     *                 @OA\Property(property="sort_options", type="array", @OA\Items(
     *                     @OA\Property(property="value", type="string", example="latest"),
     *                     @OA\Property(property="label", type="string", example="Latest")
     *                 ))
     *             )
     *         )
     *     )
     * )
     */
    public function filters()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug']);

        $types = Product::where('is_active', true)
            ->distinct()
            ->pluck('type')
            ->filter()
            ->map(function ($type) {
                return [
                    'value' => $type,
                    'label' => ucfirst($type),
                ];
            })
            ->values();

        $priceRange = [
            'min' => (float) Product::where('is_active', true)->min('price') ?? 0,
            'max' => (float) Product::where('is_active', true)->max('price') ?? 100,
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'categories' => $categories,
                'types' => $types,
                'price_range' => $priceRange,
                'sort_options' => [
                    ['value' => 'latest', 'label' => 'Latest'],
                    ['value' => 'price_asc', 'label' => 'Price: Low to High'],
                    ['value' => 'price_desc', 'label' => 'Price: High to Low'],
                    ['value' => 'name_asc', 'label' => 'Name: A-Z'],
                    ['value' => 'name_desc', 'label' => 'Name: Z-A'],
                ],
            ],
        ]);
    }
}
