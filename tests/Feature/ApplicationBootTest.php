<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApplicationBootTest extends TestCase
{
	public function test_application_boots_correctly(): void
	{
		$this->assertTrue(app()->isBooted());
	}
}
