<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Intl\Locale;
use Symfony\Component\Intl\Locales;

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
        Cache::rememberForever('languages', function () {
            $languages = [];
            foreach (Locales::getNames() as $key => $value) {
                logger('generating');
                $region = Locale::getRegion($key);
                $supported_locales = isset(config('locale.supported')[config('locale.fallback')[$key]]) ? config('locale.supported')[config('locale.fallback')[$key]] : [];
                if (! $region || is_numeric($region) || ! in_array($key, $supported_locales)) {
                    continue;
                }
                $value = Locale::getDisplayName($key, $key);
                $languages[$key] = [
                    'name' => $value,
                    'flag' => country($region)->getEmoji(),
                ];
            }

            return $languages;
        });
    }
}
