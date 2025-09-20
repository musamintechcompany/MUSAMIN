<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function general()
    {
        $settings = Setting::getSettings();
        return view('management.portal.admin.settings.general', compact('settings'));
    }

    public function sms()
    {
        $settings = Setting::getSettings();
        return view('management.portal.admin.settings.sms', compact('settings'));
    }

    public function fees()
    {
        $settings = Setting::getSettings();
        return view('management.portal.admin.settings.fees', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'email_verification_required' => 'boolean',
            'sms_enabled' => 'boolean',
            'hide_admin_registration' => 'boolean',
            'terms_privacy_required' => 'boolean',
            'profile_information_required' => 'boolean',
            'password_change_required' => 'boolean',
            'browser_sessions_required' => 'boolean',
            'two_factor_auth_required' => 'boolean',
            'account_deletion_required' => 'boolean',
            'usd_to_coins_rate' => 'required|numeric|min:0',
            'affiliate_program_fee' => 'required|numeric|min:0',
            'minimum_withdrawal_amount' => 'required|numeric|min:0',
        ]);

        $settings = Setting::getSettings();
        $settings->update($validated);

        return redirect()->back()->with('success', 'General settings updated successfully!');
    }

    public function updateSms(Request $request)
    {
        $validated = $request->validate([
            'twilio_sid' => 'nullable|string',
            'twilio_token' => 'nullable|string',
            'twilio_from' => 'nullable|string',
            'sms_provider' => 'nullable|string',
        ]);

        $settings = Setting::getSettings();
        $settings->update($validated);

        return redirect()->back()->with('success', 'SMS settings updated successfully!');
    }

    public function updateFees(Request $request)
    {
        $validated = $request->validate([
            'purchase_fee_type' => 'required|in:percentage,fixed',
            'purchase_fee' => 'required|numeric|min:0',
            'withdrawal_fee_type' => 'required|in:percent,fixed',
            'withdrawal_fee' => 'required|numeric|min:0',
        ]);

        $settings = Setting::getSettings();
        $settings->update($validated);

        return redirect()->back()->with('success', 'Fee settings updated successfully!');
    }
}