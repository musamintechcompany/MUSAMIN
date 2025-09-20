<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Update the user's address details
     */
    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::find(Auth::id());
            $user->update([
                'country' => $request->country,
                'state' => $request->state,
                'address' => $request->address
            ]);

            $user->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully',
                'user' => $user->only(['country', 'state', 'address'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update address',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getCoinBalance()
    {
        $user = Auth::user();
        
        return response()->json([
            'balance' => $user->spending_wallet ?? 0
        ]);
    }

    /**
     * Update user theme preference
     */
    public function updateTheme(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|in:light,dark'
        ]);

        $request->user()->update([
            'theme' => $validated['theme']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Theme preference updated successfully',
            'theme' => $validated['theme']
        ]);
    }

    /**
     * Send phone verification code
     */
    public function sendPhoneVerification(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:20'
        ]);

        $user = $request->user();
        $user->update(['phone' => $validated['phone']]);
        
        $result = $user->sendPhoneVerificationCode();
        
        return response()->json($result);
    }

    /**
     * Verify phone with code
     */
    public function verifyPhone(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:6'
        ]);

        $user = $request->user();
        $verified = $user->verifyPhone($validated['code']);
        
        if ($verified) {
            return response()->json([
                'success' => true,
                'message' => 'Phone verified successfully'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired verification code'
        ], 422);
    }

    /**
     * Update username
     */
    public function updateUsername(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:50|unique:users,username,' . $request->user()->id
            ]);

            $username = $validated['username'];
            
            // Ensure username starts with @
            if (!str_starts_with($username, '@')) {
                $username = '@' . $username;
            }

            $request->user()->update([
                'username' => $username
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Username updated successfully',
                'username' => $username
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Username already exists'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating username'
            ], 500);
        }
    }
}
