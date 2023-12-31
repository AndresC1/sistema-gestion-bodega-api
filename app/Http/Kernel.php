<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        // Custom middleware
        'check_status_user' => \App\Http\Middleware\User\check_status_user::class,
        'blocking_change_role' => \App\Http\Middleware\User\Change_role\blocking_change_role::class,
        'check_permission' => \App\Http\Middleware\Permission\check_permission::class,
        'match_organization' => \App\Http\Middleware\User\Change_status\match_organization::class,
        'check_role_super_admin' => \App\Http\Middleware\User\Change_status\check_role_super_admin::class,
        'check_different_role' => \App\Http\Middleware\User\Change_status\check_both_user_have_different_roles::class,
        'check_both_super_admin' => \App\Http\Middleware\User\Change_role\check_super_admin_change_another_super_admin::class,
        'check_admin_change_user_super_admin' => \App\Http\Middleware\User\Change_role\check_admin_change_user_super_admin::class,
        'check_different_organization' =>  \App\Http\Middleware\User\Change_role\check_different_organization::class,
        'check_both_admin' =>  \App\Http\Middleware\User\Change_role\check_admin_change_another_admin::class,
        'check_different_organization_for_provider' => \App\Http\Middleware\Provider\check_different_organization::class,
        'check_different_organization_for_client' => \App\Http\Middleware\Client\check_different_organization::class,
        'validate_listDetailsPurchase' => \App\Http\Middleware\Purchase\validate_listDetailsPurchase::class,
        'validate_date_range' => \App\Http\Middleware\ValidateDateRange::class,

    ];
}
