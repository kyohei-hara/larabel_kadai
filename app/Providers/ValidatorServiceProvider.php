<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
         /**
         * 郵便番号 ハイフンありなしのバリデーション
         *
         * @return bool
         */
        Validator::extend(
            'zip',
            function ($attribute, $value, $parameters, $validator) {
                return preg_match('/^[0-9]{3}-?[0-9]{4}$/', $value);
            }
        );
         /**
         * 年齢 正の数のバリデーション
         *
         * @return bool
         */
        Validator::extend(
            'positive',
            function ($attribute, $value, $parameters, $validator) {
                return is_numeric($value) && $value >= 0;
            }
        );
         /**
         * 半角数字 ハイフンバリデーション
         *
         * @return bool
         */
        Validator::extend(
            'num_hyphen',
            function ($attribute, $value, $parameters, $validator) {
                return preg_match("/^[0-9\-]+$/u", $value);
            }
        );
    }
}