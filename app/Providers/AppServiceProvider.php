<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * diretivas para usar no blade em tela
         */

        Blade::directive('datetime', function (string $expression) {
            return "<?php echo is_null($expression) ? '' : date('d/m/Y H:i', strtotime($expression)); ?>";
        });

        Blade::directive('date', function (string $expression) {
            return "<?php echo is_null($expression) ? '' : date('d/m/Y', strtotime($expression)); ?>";
        });

        Blade::directive('money', function ($amount) {
            return "<?php echo 'R$ ' . number_format($amount, 2, ',', '.'); ?>";
        });

        Blade::directive('km', function ($expression) {
            return "<?php echo number_format($expression, 1, ',', '.'); ?>";
        });

        Blade::directive('peso', function ($expression) {
            return "<?php echo number_format($expression, 2, ',', '.'); ?>";
        });

        Blade::directive('litros', function ($expression) {
            return "<?php echo number_format($expression, 2, ',', '.'); ?>";
        });
       
    }
}
