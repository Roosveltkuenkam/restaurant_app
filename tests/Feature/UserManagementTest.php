<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    /** @var User */
    private $adminUser;
    /** @var Role */
    private $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin role
        $this->adminRole = Role::firstOrCreate(['name' => 'ADMIN']);

        // Create admin user for authentication
        $this->adminUser = User::factory()->create();
        $this->adminUser->roles()->attach($this->adminRole);
    }

    private function authenticateAsAdmin()
    {
        $this->adminUser->load('roles');
        session()->put('api_token', 'test-token-' . $this->adminUser->id);
        session()->put('user', [
            'id' => $this->adminUser->id,
            'name' => $this->adminUser->name,
            'email' => $this->adminUser->email,
            'roles' => $this->adminUser->roles->toArray(),
        ]);
        return $this;
    }

    private function authenticateAsUser($user)
    {
        $user->load('roles');
        session()->put('api_token', 'test-token-' . $user->id);
        session()->put('user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->toArray(),
        ]);
        return $this;
    }

    /**
     * Test list users page is accessible.
     */
    public function test_list_users_page(): void
    {
        $response = $this->authenticateAsAdmin()
                        ->get('/admin/users');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
    }

    /**
     * Test create user page is accessible.
     */
    public function test_create_user_page(): void
    {
        $response = $this->authenticateAsAdmin()
                        ->get('/admin/users/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.create');
    }

    /**
     * Test store a new user successfully.
     */
    public function test_store_user(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->authenticateAsAdmin()
                        ->post('/admin/users', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    /**
     * Test store user with validation errors.
     */
    public function test_store_user_validation_fails(): void
    {
        $data = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'nomatch',
        ];

        $response = $this->authenticateAsAdmin()
                        ->post('/admin/users', $data);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /**
     * Test show user page.
     */
    public function test_show_user(): void
    {
        $user = User::factory()->create();

        $response = $this->authenticateAsAdmin()
                        ->get("/admin/users/{$user->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.show');
        $response->assertViewHas('user', $user);
    }

    /**
     * Test edit user page.
     */
    public function test_edit_user_page(): void
    {
        $user = User::factory()->create();

        $response = $this->authenticateAsAdmin()
                        ->get("/admin/users/{$user->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.edit');
        $response->assertViewHas('user', $user);
    }

    /**
     * Test update user successfully.
     */
    public function test_update_user(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => '',
            'password_confirmation' => '',
        ];

        $response = $this->authenticateAsAdmin()
                        ->put("/admin/users/{$user->id}", $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
    }

    /**
     * Test delete user.
     */
    public function test_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->authenticateAsAdmin()
                        ->delete("/admin/users/{$user->id}");

        $response->assertRedirect('/admin/users');
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    /**
     * Test non-admin cannot access user management.
     */
    public function test_non_admin_cannot_access_users(): void
    {
        $user = User::factory()->create();

        $response = $this->authenticateAsUser($user)
                        ->get('/admin/users');

        $response->assertStatus(403);
    }

    /**
     * Test unauthenticated user is redirected to login.
     */
    public function test_unauthenticated_redirect_to_login(): void
    {
        $response = $this->get('/admin/users');

        $response->assertRedirect('/login');
    }
}
