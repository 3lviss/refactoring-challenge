<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\Permissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccessTokenControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_read_access()
    {
        // Arrange
        DB::table('access_tokens')->insert([
            'token' => 'test-token-123',
            'permissions' => Permissions::serialize(Permissions::create(['read', 'write']))
        ]);

        // Act
        $response = $this->get('/token/test-token-123/read');

        // Assert
        $response->assertStatus(200);
        $response->assertJson(['has_permission' => true]);
    }

    public function test_has_all_permission()
    {
        // Arrange
        DB::table('access_tokens')->insert([
            'token' => 'admin-token-456',
            'permissions' => Permissions::serialize(Permissions::create(['all']))
        ]);

        // Act
        $response = $this->get('/token/admin-token-456/delete');

        // Assert
        $response->assertStatus(200);
        $response->assertJson(['has_permission' => true]);
    }

    public function test_user_requesting_all_permission_succeeds_when_token_has_any_permissions()
    {
        // Arrange
        DB::table('access_tokens')->insert([
            'token' => 'limited-token-789',
            'permissions' => Permissions::serialize(Permissions::create(['read']))
        ]);

        // Act
        $response = $this->get('/token/limited-token-789/all');

        // Assert
        $response->assertStatus(200);
        $response->assertJson(['has_permission' => true]);
    }

    public function test_user_cannot_access_permission_when_token_lacks_required_permission()
    {
        // Arrange
        DB::table('access_tokens')->insert([
            'token' => 'readonly-token-999',
            'permissions' => Permissions::serialize(Permissions::create(['read']))
        ]);

        // Act
        $response = $this->get('/token/readonly-token-999/write');

        // Assert
        $response->assertStatus(200);
        $response->assertJson(['has_permission' => false]);
    }
}
