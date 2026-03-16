<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth as AuthContract;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AuthContract::class, function ($app) {
            $factory = new Factory();

            // Configuração com credenciais do arquivo
            if ($credentials = config('services.firebase.credentials')) {
                $factory = $factory->withServiceAccount(base_path($credentials));
            }
            if ($projectId = config('services.firebase.project_id')) {
                $factory = $factory->withProjectId($projectId);
            }

            if ($databaseUrl = config('services.firebase.database_url')) {
                $factory = $factory->withDatabaseUri($databaseUrl);
            }

            return $factory->createAuth();
        });
    }

    public function boot()
    {
        //
    }
}
