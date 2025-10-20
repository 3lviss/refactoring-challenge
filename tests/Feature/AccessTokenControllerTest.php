<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\AccessTokenSeeder;

class AccessTokenControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed: test-token-01 ['read'], test-token-02 ['write','read'], test-token-03 [], test-token-04 ['all']
        $this->seed(AccessTokenSeeder::class);
    }

    public function test_read_access_granted_when_token_has_read(): void
    {
        $this->get('/token/test-token-01/read')
            ->assertOk()
            ->assertJsonPath('data.has_permission', true)
            ->assertJsonPath('data.permission', 'read');
    }

    public function test_write_access_denied_when_token_is_read_only(): void
    {
        $this->get('/token/test-token-01/write')
            ->assertOk()
            ->assertJsonPath('data.has_permission', false)
            ->assertJsonPath('data.permission', null);
    }

    public function test_requesting_all_is_true_only_when_token_has_all(): void
    {
        $this->get('/token/test-token-04/all')
            ->assertOk()
            ->assertJsonPath('data.has_permission', true)
            ->assertJsonPath('data.permission', 'all');
    }

    public function test_invalid_permission_returns_422_with_errors(): void
    {
        $this->get('/token/test-token-02/delete')
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['permission'],
            ]);
    }

    public function test_missing_token_returns_404_json(): void
    {
        $this->get('/token/does-not-exist/read')
            ->assertStatus(404)
            ->assertJson(['message' => 'Access token not found']);
    }
}
