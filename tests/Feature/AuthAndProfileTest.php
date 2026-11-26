<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AuthAndProfileTest extends TestCase
{
    use RefreshDatabase;

    private function createUsers(): array
    {
        $admin = User::create([
            'name' => 'Admin Uji',
            'email' => 'admin@kursusku.test',
            'role' => 'admin',
            'password' => Hash::make('AdminKursusKu123!'),
        ]);

        $user = User::create([
            'name' => 'User Uji',
            'email' => 'user@kursusku.test',
            'role' => 'user',
            'password' => Hash::make('UserKursusKu123!'),
        ]);

        return [$admin, $user];
    }

    public function test_login_page_renders_with_password_toggle_and_remember_me(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('toggle-password');
        $response->assertSee('remember');
        $response->assertSee('Lupa Password?');
    }

    public function test_valid_admin_and_user_can_login_and_access_dashboard(): void
    {
        [$admin, $user] = $this->createUsers();

        $adminLogin = $this->post('/login', [
            'email' => 'admin@kursusku.test',
            'password' => 'AdminKursusKu123!',
        ]);
        $adminLogin->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($admin);

        $dashboard = $this->get('/dashboard');
        $dashboard->assertStatus(200);
        $dashboard->assertSee('Admin Uji');
        $dashboard->assertSee('Admin');
        $dashboard->assertDontSee($admin->password);

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();

        $userLogin = $this->post('/login', [
            'email' => 'user@kursusku.test',
            'password' => 'UserKursusKu123!',
        ]);
        $userLogin->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_wrong_password_fails_without_leaking_sensitive_info(): void
    {
        $this->createUsers();

        $response = $this->from('/login')->post('/login', [
            'email' => 'user@kursusku.test',
            'password' => 'PasswordSalah123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_remember_me_sets_remember_token(): void
    {
        [$admin, $user] = $this->createUsers();
        $this->assertNull($user->remember_token);

        $response = $this->post('/login', [
            'email' => 'user@kursusku.test',
            'password' => 'UserKursusKu123!',
            'remember' => '1',
        ]);

        $response->assertRedirect('/dashboard');
        $user->refresh();
        $this->assertNotNull($user->remember_token);
    }

    public function test_forgot_password_and_reset_password_flow_works(): void
    {
        [$admin, $user] = $this->createUsers();

        $this->get('/forgot-password')->assertStatus(200);

        $forgotResponse = $this->post('/forgot-password', [
            'email' => 'user@kursusku.test',
        ]);
        $forgotResponse->assertSessionHas('status');

        $token = Password::createToken($user);

        $this->get("/reset-password/{$token}?email=user@kursusku.test")
            ->assertStatus(200)
            ->assertSee('toggle-password');

        $invalidReset = $this->post('/reset-password', [
            'token' => 'token-tidak-valid',
            'email' => 'user@kursusku.test',
            'password' => 'PasswordBaru999!',
            'password_confirmation' => 'PasswordBaru999!',
        ]);
        $invalidReset->assertSessionHasErrors('email');

        $validReset = $this->post('/reset-password', [
            'token' => $token,
            'email' => 'user@kursusku.test',
            'password' => 'PasswordBaru999!',
            'password_confirmation' => 'PasswordBaru999!',
        ]);
        $validReset->assertRedirect('/login');

        $user->refresh();
        $this->assertTrue(Hash::check('PasswordBaru999!', $user->password));
    }

    public function test_authenticated_user_can_update_name_and_email_with_unique_validation(): void
    {
        [$admin, $user] = $this->createUsers();

        $this->actingAs($user);

        $this->get('/profile')
            ->assertStatus(200)
            ->assertDontSee($user->password);

        $duplicateEmail = $this->put('/profile', [
            'name' => 'User Baru',
            'email' => 'admin@kursusku.test',
        ]);
        $duplicateEmail->assertSessionHasErrors('email');

        $validUpdate = $this->put('/profile', [
            'name' => 'User Diperbarui',
            'email' => 'user.baru@kursusku.test',
        ]);
        $validUpdate->assertRedirect('/profile');
        $validUpdate->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals('User Diperbarui', $user->name);
        $this->assertEquals('user.baru@kursusku.test', $user->email);
    }

    public function test_authenticated_user_can_change_password_with_current_password_verification(): void
    {
        [, $user] = $this->createUsers();

        $this->actingAs($user);

        $wrongOld = $this->put('/profile/password', [
            'current_password' => 'SalahPasswordLama',
            'password' => 'PasswordBaru123!',
            'password_confirmation' => 'PasswordBaru123!',
        ]);
        $wrongOld->assertSessionHasErrors('current_password');

        $validChange = $this->put('/profile/password', [
            'current_password' => 'UserKursusKu123!',
            'password' => 'PasswordBaru123!',
            'password_confirmation' => 'PasswordBaru123!',
        ]);
        $validChange->assertRedirect('/profile');
        $validChange->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('PasswordBaru123!', $user->password));
    }

    public function test_guest_cannot_access_dashboard_or_profile_but_can_access_public_routes_after_logout(): void
    {
        [, $user] = $this->createUsers();

        Course::create([
            'code' => 'PUB-101',
            'name' => 'Kursus Publik',
            'fee' => 300000,
            'quota' => 20,
            'start_date' => '2026-12-01',
            'status' => 'open',
        ]);

        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/profile')->assertRedirect('/login');

        $this->actingAs($user);
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();

        $this->get('/')->assertStatus(200);
        $this->get('/courses')->assertStatus(200)->assertSee('Kursus Publik');
        $this->get('/enrollments')->assertStatus(200);
        $this->get('/enrollments/create')->assertStatus(200);
    }
}
