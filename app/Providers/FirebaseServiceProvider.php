<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Kreit\Firebase\ServiceAccount;
use Log;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('firebase', function ($app) {
            $credentials = config('firebase.credentials');
            $databaseUrl = config('firebase.database_url');
            
            Log::info("Firebase credentials: $credentials");
            Log::info("Firebase database URL: $databaseUrl");
        
            $firebase = (new Factory)
                ->withServiceAccount($credentials)
                ->withDatabaseUri($databaseUrl);
        
            return $firebase->createDatabase();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
