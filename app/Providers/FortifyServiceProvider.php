<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        
        // Share terms/privacy status with all views
        view()->composer('*', function ($view) {
            $view->with('termsPrivacyStatus', $this->getTermsPrivacyStatus());
        });
    }
    
    /**
     * Get terms and privacy policy status
     */
    private function getTermsPrivacyStatus(): array
    {
        try {
            $settings = \App\Models\Setting::first();
            $configEnabled = \Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature();
            $settingsEnabled = $settings ? $settings->terms_privacy_required : true;
            
            return [
                'config_enabled' => $configEnabled,
                'settings_enabled' => $settingsEnabled,
                'should_show' => $configEnabled && $settingsEnabled,
                'admin_warning' => !$configEnabled && $settingsEnabled
            ];
        } catch (\Exception $e) {
            return [
                'config_enabled' => false,
                'settings_enabled' => false,
                'should_show' => false,
                'admin_warning' => false
            ];
        }
    }
}
