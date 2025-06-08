<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\CartGroup;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartGroupModel;
    protected $cartItemModel;
    protected $productModel;

    public function __construct()
    {
        $this->productModel = Product::class;
        $this->cartGroupModel = CartGroup::class;
        $this->cartItemModel = CartItem::class;
    }

    public function index()
    {
        $cartStores = $this->getCart();
        return view('Pages.Visitor.cart', compact('cartStores'));
    }

    public function getCart()
    {
        $authenticatedUser = Auth::user();
        if (!$authenticatedUser) {
            return [];
        }

        $cartGroups = $this->cartGroupModel::with(['store', 'items.product'])
            ->where('id_user', $authenticatedUser->id_user)
            ->get();

        Log::info('Cart groups found: ' . $cartGroups->count());

        $stores = [];
        foreach ($cartGroups as $cartGroup) {
            if (!$cartGroup->store) continue; // Skip if store relation is missing
            $stores[] = [
                'storeID' => $cartGroup->store->id_store,
                'storeName' => $cartGroup->store->store_name,
                'products' => $cartGroup->items->map(function ($item) {
                    return [
                        'cartItemID' => $item->id_cart_item,
                        'product_id' => $item->product->id_product,
                        'product_name' => $item->product->product_name,
                        'quantity' => $item->quantity,
                        'product_price' => $item->product->price,
                        'product_image' => $item->product->product_image,
                    ];
                })->toArray()
            ];
        }
        return $stores;
    }

    public function removeCartItem(Request $request, $id)
    {
        $cartItem = $this->cartItemModel::findOrFail($id);
        $cartItem->delete();
        $cartGroup = $this->cartGroupModel::find($cartItem->id_group);
        if ($cartGroup && $cartGroup->items()->count() === 0) {
            $cartGroup->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => true]);
    }


    public function addToCart(Request $request, $product_id)
    {
        $authenticatedUser = Auth::user();

        if (!$authenticatedUser) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to add items to cart'
            ], 401);
        }

        $quantity = max(1, (int) $request->input('quantity', 1));

        try {
            $product = $this->productModel::findOrFail($product_id);

            // Tambah atau buat CartGroup untuk user dan store
            $cartGroup = $this->cartGroupModel::firstOrCreate([
                'id_user' => $authenticatedUser->id_user,
                'id_store' => $product->id_store,
                'status' => 'active'
            ]);

            // Tambah atau update CartItem
            $cartItem = $this->cartItemModel::firstOrNew([
                'id_group' => $cartGroup->id_group,
                'id_product' => $product_id
            ]);

            $cartItem->quantity += $quantity;
            $cartItem->save();

            // Count total items in user's cart
            $totalItems = $this->cartItemModel::whereHas('cartGroup', function ($query) use ($authenticatedUser) {
                $query->where('id_user', $authenticatedUser->id_user);
            })->sum('quantity');

            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart',
                    'cart_count' => $totalItems
                ]);
            }

            // Return redirect response for non-AJAX requests
            return redirect()->back()->with('success', 'Product added to cart');
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add product to cart: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to add product to cart');
        }
    }

    public function updateCart(Request $request)
    {
        // Handle JSON request
        $data = $request->json()->all();

        // Validate the request data
        if (!isset($data['cart_item_id']) || !isset($data['quantity']) || $data['quantity'] < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request data'
            ], 422);
        }

        $cartItem = $this->cartItemModel::findOrFail($data['cart_item_id']);

        // Make sure the cart item belongs to the authenticated user
        $authenticatedUser = Auth::user();
        $cartGroup = $this->cartGroupModel::find($cartItem->id_group);

        if (!$cartGroup || $cartGroup->id_user !== $authenticatedUser->id_user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access to cart item'], 403);
        }

        $cartItem->quantity = $data['quantity'];
        $cartItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'new_quantity' => $cartItem->quantity,
            'subtotal' => $cartItem->quantity * $cartItem->product->price,
        ]);
    }

    public function checkoutStore(Request $request, $storeId)
    {
        $authenticatedUser = Auth::user();
        if (!$authenticatedUser) {
            return redirect()->route('login');
        }

        $cartGroup = $this->cartGroupModel::where('id_user', $authenticatedUser->id_user)
            ->where('id_store', $storeId)
            ->with(['items.product'])
            ->firstOrFail();

        $pickedupAt = $request->input('pickedup_at');

        // Validate stock availability
        foreach ($cartGroup->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->back()->with('error', 'Insufficient stock for product: ' . $item->product->product_name);
            }
        }

        // Create order
        $order = Order::create([
            'id_user' => $authenticatedUser->id_user,
            'id_store' => $storeId,
            'total_amount' => $cartGroup->items->sum(function ($item) {
                return $item->quantity * $item->product->price;
            }),
            'order_status' => 'pending',
            'pickedup_at' => $pickedupAt,
        ]);

        // Create order details for each cart item
        foreach ($cartGroup->items as $item) {
            OrderDetail::create([
                'id_order' => $order->id_order,
                'id_product' => $item->product->id_product,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'subtotal' => $item->quantity * $item->product->price,
            ]);

            // Decrease product stock
            $product = $item->product;
            $product->stock -= $item->quantity;
            $product->save();
        }

        // Delete all cart items before deleting the cart group
        $cartGroup->items()->delete();
        $cartGroup->delete();

        // Redirect to payment page instead of cart page
        return redirect()->route('customer.payment.show', $order->id_order)
            ->with('success', 'Order created successfully! Please complete your payment.');
    }
}
