<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

use App\Http\Controllers\CoinPackageController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\CoinTransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\ForgotPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('guest1-pages.home');
})->name('home');

Route::get('/marketplace', function () {
    return view('guest1-pages.marketplace');
})->name('marketplace');

Route::get('/how-it-works', function () {
    return view('guest1-pages.how-it-works');
})->name('how-it-works');

Route::get('/testimonials', function () {
    return view('guest1-pages.testimonials');
})->name('testimonials');

Route::get('/contact', function () {
    return view('guest1-pages.contact');
})->name('contact');

Route::get('/affiliate', function () {
    return view('guest1-pages.affiliate');
})->name('guest.affiliate');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Coin Packages
    Route::get('/coin-packages', [CoinPackageController::class, 'index'])
        ->name('coin-packages.index');
    Route::get('/coin-packages/data', [CoinPackageController::class, 'getData'])
        ->name('coin-packages.data');

    // Payment Methods
    Route::prefix('payment-methods')->group(function () {
        Route::get('/manual', [PaymentMethodController::class, 'getManualMethods'])
            ->name('payment.methods.manual');
        Route::get('/data', [PaymentMethodController::class, 'getData'])
            ->name('payment-methods.data');
    });

    // User Address Update
    Route::post('/user/update-address', [UserController::class, 'updateAddress'])
        ->name('user.update-address');

    // User Coin Balance
    Route::get('/user/coin-balance', [UserController::class, 'getCoinBalance'])
        ->name('user.coin-balance');

    // Coin Transactions
    Route::prefix('coin-transactions')->group(function () {
        Route::post('/submit', [CoinTransactionController::class, 'submit'])
            ->name('coin-transaction.submit');
        Route::post('/complete', [CoinTransactionController::class, 'complete'])
            ->name('coin-transaction.complete');
    });

    // Stores
    Route::get('/stores', [App\Http\Controllers\StoreController::class, 'index'])
        ->name('stores');
    Route::get('/stores/create', [App\Http\Controllers\StoreController::class, 'create'])
        ->name('stores.create');
    Route::post('/stores', [App\Http\Controllers\StoreController::class, 'store'])
        ->name('stores.store');

    // Wallets
    Route::get('/wallet', function () {
        return view('wallets.index');
    })->name('wallet');

    // Orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [App\Http\Controllers\OrderController::class, 'index'])
            ->name('orders.index');
        Route::get('/{order}', [App\Http\Controllers\OrderController::class, 'show'])
            ->name('orders.show');
        Route::post('/{order}/received', [App\Http\Controllers\OrderController::class, 'markAsReceived'])
            ->name('orders.received');
    });

    // Store Orders (for store owners)
    Route::prefix('store/orders')->group(function () {
        Route::get('/', [App\Http\Controllers\OrderController::class, 'storeOrders'])
            ->name('store.orders.index');
        Route::get('/{order}', [App\Http\Controllers\OrderController::class, 'storeOrderShow'])
            ->name('store.orders.show');
        Route::post('/{order}/shipped', [App\Http\Controllers\OrderController::class, 'markAsShipped'])
            ->name('store.orders.shipped');
        Route::post('/{order}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])
            ->name('store.orders.status');
    });



    // Ideas
    Route::get('/ideas', [IdeaController::class, 'index'])
        ->name('ideas.index');
    Route::post('/ideas', [IdeaController::class, 'store'])
        ->name('ideas.store');

    // Authenticated Marketplace (user-facing authenticated marketplace view)
    Route::get('/market-place', function () {
        return view('market-place.index');
    })->name('market-place.index');

    // User Assets
    Route::get('/user-assets', function () {
        return view('user-assets.index');
    })->name('user-assets.index');

    // Support (authenticated)
    Route::get('/support', function () {
        return view('support.index');
    })->name('support.index');

    Route::get('/support/faqs', [App\Http\Controllers\FaqController::class, 'index'])
        ->name('support.faqs');

    Route::get('/help', [App\Http\Controllers\HelpCenterController::class, 'index'])
        ->name('help.center');
    Route::get('/help/search', [App\Http\Controllers\HelpCenterController::class, 'search'])
        ->name('help.search');
    Route::get('/help/category/{category}', [App\Http\Controllers\HelpCenterController::class, 'category'])
        ->name('help.category');
    Route::get('/help/{slug}', [App\Http\Controllers\HelpCenterController::class, 'show'])
        ->name('help.article');

    // Profile Details
    Route::get('/profile/details', function () {
        return view('profile.view-profile-details');
    })->name('profile.details');



    // Password Change
    Route::post('/password/send-code', [App\Http\Controllers\PasswordChangeController::class, 'sendCode'])
        ->name('password.send-code');
    Route::post('/password/verify-change', [App\Http\Controllers\PasswordChangeController::class, 'verifyAndChange'])
        ->name('password.verify-change');







    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('/', function () {
            return view('settings.index');
        })->name('settings');



        Route::get('/rates', function () {
            return view('settings.rates');
        })->name('settings.rates');

        Route::get('/account', function () {
            return view('settings.account');
        })->name('settings.account');

        Route::get('/security', function () {
            return view('settings.security');
        })->name('settings.security');

        Route::get('/appearance', function () {
            return view('settings.appearance.index');
        })->name('settings.appearance');

        Route::get('/kyc', function () {
            return view('settings.kyc');
        })->name('settings.kyc');

        Route::post('/kyc', function () {
            return response()->json(['success' => true, 'message' => 'KYC application submitted successfully']);
        })->name('settings.kyc.store');

        Route::get('/withdrawal-bank', function () {
            return view('settings.withdrawal-bank');
        })->name('settings.withdrawal-bank');

        Route::get('/withdrawal-bank/list', function () {
            return response()->json(['accounts' => []]);
        })->name('settings.withdrawal-bank.list');

        Route::post('/withdrawal-bank', function () {
            return response()->json(['success' => true, 'message' => 'Bank account added successfully']);
        })->name('settings.withdrawal-bank.store');

        Route::put('/withdrawal-bank/{id}', function () {
            return response()->json(['success' => true, 'message' => 'Bank account updated successfully']);
        })->name('settings.withdrawal-bank.update');

        Route::delete('/withdrawal-bank/{id}', function () {
            return response()->json(['success' => true, 'message' => 'Bank account deleted successfully']);
        })->name('settings.withdrawal-bank.destroy');
    });
    // Theme Management
    Route::post('/user/theme', [UserController::class, 'updateTheme'])
        ->name('user.theme.update');

    // Phone Verification
    Route::post('/user/phone/send-verification', [UserController::class, 'sendPhoneVerification'])
        ->name('user.phone.send-verification');
    Route::post('/user/phone/verify', [UserController::class, 'verifyPhone'])
        ->name('user.phone.verify');

    // Username Update
    Route::post('/user/username', [UserController::class, 'updateUsername'])
        ->name('username.update');

    // Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [App\Http\Controllers\NotificationController::class, 'index'])
            ->name('notifications.index');
        Route::get('/unread', [App\Http\Controllers\NotificationController::class, 'getUnread'])
            ->name('notifications.unread');
        Route::post('/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])
            ->name('notifications.read');
        Route::post('/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])
            ->name('notifications.mark-all-read');
    });

    // Inbox/Chat Routes
    Route::get('/inbox', [App\Http\Controllers\ChatController::class, 'index'])
        ->name('inbox.index');
    Route::get('/inbox/unread/count', [App\Http\Controllers\ChatController::class, 'getUnreadCount'])
        ->name('inbox.unread.count');
    Route::get('/inbox/{conversationId}', [App\Http\Controllers\ChatController::class, 'index'])
        ->name('inbox.conversation');
    Route::get('/inbox/{conversationId}/data', [App\Http\Controllers\ChatController::class, 'getConversationData'])
        ->name('inbox.conversation.data');
    Route::post('/inbox/{conversationId}/messages', [App\Http\Controllers\ChatController::class, 'sendMessage'])
        ->name('inbox.send-message');

    Route::post('/inbox/start-chat', [App\Http\Controllers\ChatController::class, 'startChat'])
        ->name('inbox.start-chat');
    Route::post('/inbox/block-user', [App\Http\Controllers\ChatController::class, 'blockUser'])
        ->name('inbox.block-user');
    Route::post('/inbox/unblock-user', [App\Http\Controllers\ChatController::class, 'unblockUser'])
        ->name('inbox.unblock-user');

    Route::delete('/inbox/{conversationId}', [App\Http\Controllers\ChatController::class, 'deleteConversation'])
        ->name('inbox.delete-conversation');

    // Follow System
    Route::post('/follow', [App\Http\Controllers\FollowController::class, 'follow'])
        ->name('follow');
    Route::post('/unfollow', [App\Http\Controllers\FollowController::class, 'unfollow'])
        ->name('unfollow');
    Route::get('/follow-status', [App\Http\Controllers\FollowController::class, 'status'])
        ->name('follow.status');
    Route::post('/follow-status', [App\Http\Controllers\FollowController::class, 'batchStatus'])
        ->name('follow.batch-status');








});

// Forgot Password routes (guest)
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])
    ->name('password.request');
Route::post('/password/send-reset-code', [ForgotPasswordController::class, 'sendResetCode'])
    ->name('password.send-reset-code');
Route::post('/password/reset-with-code', [ForgotPasswordController::class, 'resetWithCode'])
    ->name('password.reset-with-code');

// Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/', [App\Http\Controllers\CartController::class, 'index'])
        ->middleware('auth')
        ->name('cart.index');
    Route::post('/add', [App\Http\Controllers\CartController::class, 'add'])
        ->name('cart.add');
    Route::post('/update-quantity', [App\Http\Controllers\CartController::class, 'updateQuantity'])
        ->name('cart.update-quantity');
    Route::post('/remove', [App\Http\Controllers\CartController::class, 'remove'])
        ->name('cart.remove');
    Route::post('/clear', [App\Http\Controllers\CartController::class, 'clear'])
        ->name('cart.clear');
    Route::get('/count', [App\Http\Controllers\CartController::class, 'count'])
        ->name('cart.count');
    Route::post('/sync', [App\Http\Controllers\CartController::class, 'syncGuestCartToDatabase'])
        ->middleware('auth')
        ->name('cart.sync');
    Route::post('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])
        ->middleware('auth')
        ->name('cart.checkout');
});

// Email verification routes
Route::post('/email/verify', App\Http\Controllers\Auth\EmailVerificationController::class)
    ->middleware(['auth'])
    ->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $user = $request->user();
    $user->generateNewVerificationCode();
    $user->sendEmailVerificationNotification();

    if ($request->wantsJson()) {
        return response()->json(['message' => 'Verification code sent successfully']);
    }

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Email Change routes (outside verified middleware)
Route::post('/email/change', [App\Http\Controllers\Auth\EmailVerificationController::class, 'initiateChange'])
    ->middleware(['auth'])
    ->name('email.change');
Route::post('/email/verify-change', [App\Http\Controllers\Auth\EmailVerificationController::class, 'verifyChange'])
    ->middleware(['auth'])
    ->name('email.verify-change');

// Include affiliate routes
require __DIR__.'/affiliate.php';

// Broadcasting routes
Broadcast::routes(['middleware' => ['web', 'auth']]);

// Dynamic store routes (must be last to avoid conflicts)
Route::get('/{handle}', [App\Http\Controllers\StoreController::class, 'show'])
    ->where('handle', '^@[a-zA-Z0-9]+$')
    ->name('store.show');

Route::get('/{handle}/product/{product}', [App\Http\Controllers\StoreController::class, 'showProduct'])
    ->where('handle', '^@[a-zA-Z0-9]+$')
    ->name('store.product.show');
