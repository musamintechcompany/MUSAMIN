<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Events\Admin\UserRegistered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $termsRequired = $this->shouldRequireTerms();
        
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => $termsRequired ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        
        // Dispatch Laravel's Registered event to notify admins
        event(new \Illuminate\Auth\Events\Registered($user));
        
        return $user;
    }
    
    /**
     * Determine if terms and privacy should be required
     */
    private function shouldRequireTerms(): bool
    {
        try {
            $settings = \App\Models\Setting::first();
            $configEnabled = \Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature();
            $settingsEnabled = $settings ? $settings->terms_privacy_required : true;
            
            // Only require terms if both config and settings allow it
            return $configEnabled && $settingsEnabled;
        } catch (\Exception $e) {
            // Fallback to Jetstream default during setup/migration
            return \Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature();
        }
    }
}
