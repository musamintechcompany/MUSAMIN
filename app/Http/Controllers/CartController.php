<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\StoreOrder;
use App\Models\StoreOrderItem;
use App\Models\StoreProduct;
use App\Models\User;
use App\Mail\OrderConfirmation;
use App\Mail\NewOrderNotification;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    const COINS_PER_CURRENCY_UNIT = 100;
    public function index(Request $request)
    {
        // If it's an AJAX request, return JSON data
        if ($request->wantsJson()) {
            if (Auth::check()) {
                $cartItems = Cart::where('user_id', Auth::id())->get()->map(function ($item) {
                    return [
                        'id' => $item->product_id,
                        'name' => $item->name,
                        'price' => $item->price,
                        'store_name' => $item->store_name,
                        'image' => $item->image,
                        'type' => $item->type,
                        'quantity' => $item->quantity
                    ];
                });
            } else {
                $cart = Session::get('cart', []);
                $cartItems = collect(array_values($cart));
            }
            
            return response()->json([
                'success' => true,
                'items' => $cartItems
            ]);
        }

        return view('cart.index');
    }

    public function add(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|string',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'store_name' => 'required|string|max:255',
                'image' => 'nullable|string|max:500',
                'type' => 'required|in:digital,physical'
            ]);

            if (Auth::check()) {
                $cartItem = Cart::where('user_id', Auth::id())
                    ->where('product_id', $validated['product_id'])
                    ->first();

                if ($cartItem) {
                    $cartItem->increment('quantity');
                } else {
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $validated['product_id'],
                        'name' => e($validated['name']),
                        'price' => $validated['price'],
                        'store_name' => e($validated['store_name']),
                        'image' => $validated['image'],
                        'type' => $validated['type'],
                        'quantity' => 1
                    ]);
                }

                $cartCount = Cart::where('user_id', Auth::id())->count();
            } else {
                $cart = Session::get('cart', []);
                $productId = $validated['product_id'];

                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity']++;
                } else {
                    $cart[$productId] = [
                        'id' => $productId,
                        'name' => e($validated['name']),
                        'price' => $validated['price'],
                        'store_name' => e($validated['store_name']),
                        'image' => $validated['image'],
                        'type' => $validated['type'],
                        'quantity' => 1
                    ];
                }

                Session::put('cart', $cart);
                $cartCount = count($cart);
            }

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart',
                'cart_count' => $cartCount
            ]);
        } catch (\Exception $e) {
            Log::error('Cart add error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error adding item to cart'
            ], 500);
        }
    }

    public function updateQuantity(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|string',
                'quantity' => 'required|integer|min:1|max:999'
            ]);

            if (Auth::check()) {
                $cartItem = Cart::where('user_id', Auth::id())
                    ->where('product_id', $validated['product_id'])
                    ->first();

                if (!$cartItem) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cart item not found'
                    ], 404);
                }

                $cartItem->update(['quantity' => $validated['quantity']]);
                $cartCount = Cart::where('user_id', Auth::id())->count();
            } else {
                $cart = Session::get('cart', []);
                if (isset($cart[$validated['product_id']])) {
                    $cart[$validated['product_id']]['quantity'] = $validated['quantity'];
                    Session::put('cart', $cart);
                }
                $cartCount = count($cart);
            }

            return response()->json([
                'success' => true,
                'cart_count' => $cartCount
            ]);
        } catch (\Exception $e) {
            Log::error('Cart update quantity error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating quantity'
            ], 500);
        }
    }

    public function remove(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|string'
            ]);

            $productId = $validated['product_id'];

            if (Auth::check()) {
                Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->delete();
                $cartCount = Cart::where('user_id', Auth::id())->count();
            } else {
                $cart = Session::get('cart', []);
                if (isset($cart[$productId])) {
                    unset($cart[$productId]);
                    Session::put('cart', $cart);
                }
                $cartCount = count($cart);
            }

            return response()->json([
                'success' => true,
                'cart_count' => $cartCount
            ]);
        } catch (\Exception $e) {
            Log::error('Cart remove error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error removing product from cart'
            ], 500);
        }
    }

    public function clear()
    {
        try {
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                Session::forget('cart');
            }

            return response()->json([
                'success' => true,
                'cart_count' => 0
            ]);
        } catch (\Exception $e) {
            Log::error('Cart clear error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error clearing cart'
            ], 500);
        }
    }

    public function count()
    {
        try {
            if (Auth::check()) {
                $count = Cart::where('user_id', Auth::id())->count();
            } else {
                $cart = Session::get('cart', []);
                $count = count($cart);
            }
            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            Log::error('Cart count error: ' . $e->getMessage());
            return response()->json(['count' => 0]);
        }
    }

    public function syncGuestCartToDatabase(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Not authenticated']);
            }

            $cartData = $request->input('cart_data');
            if ($cartData) {
                $guestCart = json_decode($cartData, true);
            } else {
                $guestCart = Session::get('cart', []);
            }

            Log::info('Cart sync attempt', ['user_id' => Auth::id(), 'cart_items' => count($guestCart)]);

            if (!empty($guestCart)) {
                // Validate cart items before processing
                $validItems = [];
                foreach ($guestCart as $item) {
                    if (isset($item['id'], $item['name'], $item['price'], $item['type'], $item['quantity'])) {
                        $validItems[] = [
                            'user_id' => Auth::id(),
                            'product_id' => $item['id'],
                            'name' => e($item['name']),
                            'price' => (float)$item['price'],
                            'store_name' => e($item['store_name'] ?? ''),
                            'image' => $item['image'] ?? null,
                            'type' => $item['type'],
                            'quantity' => (int)$item['quantity']
                        ];
                    }
                }

                // Batch process valid items
                foreach ($validItems as $itemData) {
                    Cart::updateOrCreate(
                        [
                            'user_id' => $itemData['user_id'],
                            'product_id' => $itemData['product_id']
                        ],
                        $itemData
                    );
                }

                Log::info('Cart sync completed', ['synced_items' => count($validItems)]);

                Session::forget('cart');
            }

            $cartCount = Cart::where('user_id', Auth::id())->count();
            return response()->json([
                'success' => true,
                'cart_count' => $cartCount
            ]);

        } catch (\Exception $e) {
            Log::error('Cart sync error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Sync failed']);
        }
    }

    private function loadUserCart()
    {
        if (Auth::check()) {
            $dbCart = Cart::where('user_id', Auth::id())->get();
            $cart = [];

            foreach ($dbCart as $item) {
                $cart[$item->product_id] = [
                    'id' => $item->product_id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'store_name' => $item->store_name,
                    'image' => $item->image,
                    'type' => $item->type,
                    'quantity' => $item->quantity
                ];
            }

            Session::put('cart', $cart);
        }
    }

    private function getCart()
    {
        if (Auth::check()) {
            $this->loadUserCart();
        }
        return Session::get('cart', []);
    }

    /**
     * @phpstan-ignore-next-line
     */
    public function checkout(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'shipping_cost' => 'required|numeric|min:0',
            'delivery_name' => 'required|string|max:255',
            'delivery_email' => 'required|email',
            'delivery_phone' => 'nullable|string|max:20',
            'delivery_address' => 'required|string',
            'delivery_city' => 'required|string|max:100',
            'delivery_state' => 'required|string|max:100',
            'delivery_country' => 'required|string|max:100',
            'delivery_postal_code' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $cart = $this->getCart();

            if (empty($cart)) {
                return response()->json(['success' => false, 'message' => 'Cart is empty']);
            }

            // Get all product IDs and fetch products in one query
            $productIds = array_column($cart, 'id');
            $products = StoreProduct::whereIn('id', $productIds)
                ->with('store')
                ->get()
                ->keyBy('id');

            // Validate all products exist and are available
            foreach ($cart as $item) {
                if (!isset($products[$item['id']])) {
                    return response()->json(['success' => false, 'message' => 'Product not found: ' . e($item['name'])]);
                }

                $product = $products[$item['id']];
                if (!$product->is_active) {
                    return response()->json(['success' => false, 'message' => 'Product no longer available: ' . e($product->name)]);
                }
            }

            // Group cart items by store
            $ordersByStore = [];
            $totalCoinsNeeded = 0;

            foreach ($cart as $item) {
                $product = $products[$item['id']];
                $storeId = $product->store_id;

                if (!isset($ordersByStore[$storeId])) {
                    $ordersByStore[$storeId] = [
                        'store' => $product->store,
                        'items' => [],
                        'subtotal' => 0
                    ];
                }

                $itemTotal = $product->price * $item['quantity'];
                $ordersByStore[$storeId]['items'][] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $itemTotal
                ];
                $ordersByStore[$storeId]['subtotal'] += $itemTotal;
                $totalCoinsNeeded += $itemTotal * self::COINS_PER_CURRENCY_UNIT;
            }

            // Add shipping cost once (convert to coins)
            $shippingCoins = $validated['shipping_cost'] * self::COINS_PER_CURRENCY_UNIT;
            $totalCoinsNeeded += $shippingCoins;

            // Check if user has enough coins
            if ($user->spendable_coins < $totalCoinsNeeded) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient coins. You need ' . number_format($totalCoinsNeeded) . ' coins.'
                ]);
            }

            // Create orders for each store
            $createdOrders = [];
            foreach ($ordersByStore as $storeData) {
                $store = $storeData['store'];
                $subtotal = $storeData['subtotal'];
                // Distribute shipping cost proportionally across stores
                $storeShippingCost = count($ordersByStore) > 1 ?
                    ($validated['shipping_cost'] * $subtotal) / array_sum(array_column($ordersByStore, 'subtotal')) :
                    $validated['shipping_cost'];
                $totalAmount = $subtotal + $storeShippingCost;
                $totalCoins = $totalAmount * self::COINS_PER_CURRENCY_UNIT;

                // Create order
                $order = StoreOrder::create([
                    'user_id' => $user->id,
                    'store_id' => $store->id,
                    'subtotal' => $subtotal,
                    'shipping_cost' => $storeShippingCost,
                    'total_amount' => $totalAmount,
                    'total_coins_used' => $totalCoins,
                    'status' => StoreOrder::STATUS_CONFIRMED,
                    'payment_status' => StoreOrder::PAYMENT_COMPLETED,
                    'delivery_name' => $validated['delivery_name'],
                    'delivery_email' => $validated['delivery_email'],
                    'delivery_phone' => $validated['delivery_phone'],
                    'delivery_address' => $validated['delivery_address'],
                    'delivery_city' => $validated['delivery_city'],
                    'delivery_state' => $validated['delivery_state'],
                    'delivery_country' => $validated['delivery_country'],
                    'delivery_postal_code' => $validated['delivery_postal_code'],
                    'notes' => $validated['notes']
                ]);

                // Create order items
                foreach ($storeData['items'] as $itemData) {
                    StoreOrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $itemData['product']->id,
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'total_price' => $itemData['total_price'],
                        'product_snapshot' => [
                            'name' => e($itemData['product']->name),
                            'description' => e($itemData['product']->description),
                            'type' => $itemData['product']->type,
                            'images' => $itemData['product']->images
                        ]
                    ]);
                }

                // Add coins to store owner's pending balance
                $storeOwner = User::find($store->user_id);
                if ($storeOwner) {
                    $storeOwner->increment('pending_earned_coins', $totalCoins);
                }

                $createdOrders[] = $order;

                // Send notification to store owner
                if ($storeOwner) {
                    Mail::to($storeOwner->email)->queue(new NewOrderNotification($order));
                }
            }

            // Deduct coins from customer
            User::where('id', $user->id)->decrement('spendable_coins', $totalCoinsNeeded);

            // Clear cart
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            }
            Session::forget('cart');

            // Send confirmation to customer
            Mail::to($user->email)->queue(new OrderConfirmation($createdOrders));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Orders placed successfully!',
                'orders' => collect($createdOrders)->pluck('order_number')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Checkout failed. Please try again.']);
        }
    }
}
