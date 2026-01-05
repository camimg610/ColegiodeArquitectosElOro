<?php

namespace Tests;

trait CreatesApplication
{
    /**
     * Crea la aplicación para pruebas.
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }
}
