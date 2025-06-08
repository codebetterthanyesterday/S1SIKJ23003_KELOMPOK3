<?php

namespace App\Http\Controllers\Customer;

use App\Models\Store;
use App\Models\Product;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $productCategoryModel;
    protected $productModel;
    protected $storeModel;
    protected $authenticatedUser;
    public function __construct()
    {
        $this->authenticatedUser = Auth::user();
        $this->productCategoryModel = ProductCategory::class;
        $this->productModel = Product::class;
        $this->storeModel = Store::class;
    }


    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        $categories = $this->productCategoryModel::all();


        $query = [
            'trendingProducts' => $this->productModel::with(['category', 'store'])
                ->select('products.*')
                ->leftJoin('order_details', 'products.id_product', '=', 'order_details.id_product')
                ->when($categorySlug, function ($q) use ($categorySlug) {
                    $q->whereHas('category', function ($catQ) use ($categorySlug) {
                        $catQ->where('slug', $categorySlug);
                    });
                })
                ->groupBy('products.id_product')
                ->orderByRaw('COALESCE(SUM(order_details.quantity),0) DESC')
                ->limit(16),
            'newEntities' => [
                'products' => $this->productModel::with(['category', 'store'])->orderBy('created_at', 'desc')->limit(4),
                'stores' => $this->storeModel::orderBy('created_at', 'desc')->limit(4),
            ],
            'recommendations' => collect(),
        ];

        if (Auth::check()) {
            // 1. Get category IDs from user's orders
            $orderedCategoryIds = $this->authenticatedUser->orders()->with('details.product.category')->get()->pluck('details')->flatten()->pluck('product.category.id_category')->unique()->filter();

            // 2. Get store IDs from user's favorite stores
            $favoriteStoreIds = $this->authenticatedUser->favoriteStores()->pluck('stores.id_store')->unique();

            // 3. Get recommended products from these categories and stores
            $query['recommendations'] = $this->productModel::with(['category', 'store'])->where(function ($q) use ($orderedCategoryIds, $favoriteStoreIds) {
                if ($orderedCategoryIds->count()) {
                    $q->whereIn('id_category', $orderedCategoryIds);
                }
                if ($favoriteStoreIds->count()) {
                    $q->orWhereIn('id_store', $favoriteStoreIds);
                }
            })->inRandomOrder()->limit(6)->get();

            // 4. If not enough, fill with random products
            if ($query['recommendations']->count() < 6) {
                $moreProducts = $this->productModel::with(['category', 'store'])->whereNotIn('id_product', $query['recommendations']->pluck('id_product'))->inRandomOrder()->limit(6 - $query['recommendations']->count())->get();
                $query['recommendations'] = $query['recommendations']->concat($moreProducts);
            }
        }

        $recommendations = $query['recommendations'];


        $trendingProducts = $query['trendingProducts']->get();

        // Get total quantity for trending products using the relationship properly
        $totalQuantity = 0;
        foreach ($trendingProducts as $product) {
            // Make sure we're working with the proper model instance and relationship
            if (is_object($product) && method_exists($product, 'orderDetails')) {
                $totalQuantity += $product->orderDetails()->sum('quantity');
            }
        }

        $getNewEntities = collect($query['newEntities']['products']->get())
            ->map(function ($item) {
                return [
                    'type' => 'Menu',
                    'title' => $item->product_name,
                    'desc' => ($item->category?->category_name ?? '') . ' • ' . ($item->store?->store_name ?? ''),
                    'img' => $item->product_image
                        ? asset('storage/product_images/' . $item->product_image)
                        : 'https://via.placeholder.com/400x200?text=No+Image',
                    'price' => $item->price,
                    'isNew' => true,
                    'slug' => $item->slug,
                    'created_at_human' => \Carbon\Carbon::parse($item->created_at)->diffForHumans(),
                ];
            })
            ->merge(
                collect($query['newEntities']['stores']->get())->map(function ($item) {
                    return [
                        'type' => 'Store',
                        'title' => $item->store_name,
                        'desc' => $item->store_address,
                        'img_banner' => $item->store_banner
                            ? asset('storage/store_banners/' . $item->store_banner)
                            : 'https://via.placeholder.com/400x200?text=No+Image',
                        'img_logo' => $item->store_logo
                            ? asset('storage/store_logos/' . $item->store_logo)
                            : 'https://via.placeholder.com/400x200?text=No+Image',
                        'isNew' => true,
                        'slug' => $item->slug,
                        'created_at_human' => \Carbon\Carbon::parse($item->created_at)->diffForHumans(),
                    ];
                }),
            )
            ->values();


        // Get cart items for the authenticated user
        $data = [
            'trendingProducts' => $trendingProducts,
            'categories' => $categories,
            'currentCategory' => $categorySlug,
            'newEntities' => $getNewEntities,
            'recommendations' => $recommendations,
            // 'cartStores' => $cartStores,
        ];

        if (Auth::check()) {
            $data['cartStores'] = app(CustomerCartController::class)->getCart();
        }

        return view('Pages.Visitor.home', $data);
    }
}
