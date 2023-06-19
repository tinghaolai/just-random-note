<?php

use Tests\TestCase;

class ContextualBindingBControllerTest extends TestCase
{
    public function testContextualBindingBController()
    {
        $response = $this->get('/test3-2');
        $response->assertStatus(200);
        $response->assertSeeText('value from default: ContextualBindingService, rep: get from ContextualBindingRepositories, value: from provider interface');
    }
}
