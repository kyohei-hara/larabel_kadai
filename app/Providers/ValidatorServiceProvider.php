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
                if($value === null) return true;
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
         /**
         * 数値比較
         *
         * @return bool
         */
        Validator::extend(
            'comparison',
            function ($attribute, $value, $parameters, $validator) {
                $min = $validator->getData()[$parameters[0]];
                if($min === null) return true;
                if(!is_numeric($min)) return true;
                if($min <= $value) return true;
                return false;
            }
        );
         /**
         * 数値判定 null はok
         *
         * @return bool
         */
        Validator::extend(
            'null_numeric',
            function ($attribute, $value, $parameters, $validator) {
                if($value === null) return true;
                 return is_numeric($value);
            }
        );
    }
}
