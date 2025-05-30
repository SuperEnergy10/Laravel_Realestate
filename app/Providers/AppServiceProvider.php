<?php

namespace App\Providers;

use App\Models\SmtpSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        if (Schema::hasTable('smtp_settings')) {
            $smtp_settings = SmtpSetting::first();

            if ($smtp_settings) {
                $data = [
                    'mailer' => $smtp_settings->mailer,
                    'host' => $smtp_settings->host,
                    'port' => $smtp_settings->port,
                    'username' => $smtp_settings->username,
                    'password' => $smtp_settings->password,
                    'encryption' => $smtp_settings->encryption,
                    'from' => [
                        'address' => $smtp_settings->from_address,
                        'name' => "Hello World"
                    ]
                ];

                Config::set('mail', $data);
            }
        }
    }
}
