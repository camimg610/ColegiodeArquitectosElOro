<?php

namespace Tests\Feature;

// Importamos el TestCase base correctamente
use Tests\TestCase;

class ApplicationBootTest extends TestCase
{
    /**
     * Verifica que la aplicación inicie correctamente.
     */
    public function test_application_boots_correctly(): void
    {
        // Al extender de TestCase, $this ya reconoce assertTrue
        $this->assertTrue(app()->isBooted());
    }
}
