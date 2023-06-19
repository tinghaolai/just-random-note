<?php

use App\Repositories\ContextualBindingRepositories;
use App\Services\ContextualBindingAService;
use Tests\TestCase;

class ContextualBindingAControllerTest extends TestCase
{
    public function testContextualBindingAController()
    {
        $this->app->when(ContextualBindingAService::class)
            ->needs(ContextualBindingRepositories::class)
            ->give(function () {
                $mockRepo = $this->mock(ContextualBindingRepositories::class);
                $mockRepo->shouldReceive('get')->andReturn('Mocked value');
                return $mockRepo;
            });

        $response = $this->get('/test3-1');
        $response->assertStatus(200);
        $response->assertSeeText('value from default: ContextualBindingService, rep: Mocked value');
    }
}
