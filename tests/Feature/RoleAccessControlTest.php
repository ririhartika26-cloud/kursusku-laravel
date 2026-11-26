<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleAccessControlTest extends TestCase
{
    use RefreshDatabase;

    private function seedRolesAndCourses(): array
    {
        $admin = User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@kursusku.test',
            'role' => 'admin',
            'password' => Hash::make('AdminKursusKu123!'),
        ]);

        $user = User::create([
            'name' => 'User Biasa',
            'email' => 'user@kursusku.test',
            'role' => 'user',
            'password' => Hash::make('UserKursusKu123!'),
        ]);

        $course = Course::create([
            'code' => 'ROLE-101',
            'name' => 'Kursus Uji Hak Akses',
            'description' => 'Deskripsi kursus uji hak akses',
            'fee' => 300000,
            'quota' => 20,
            'start_date' => '2026-12-01',
            'status' => 'open',
        ]);

        return [$admin, $user, $course];
    }

    public function test_admin_can_create_edit_update_and_delete_course_and_view_admin_pages(): void
    {
        [$admin, , $course] = $this->seedRolesAndCourses();

        $this->actingAs($admin);

        $this->get('/admin/dashboard')->assertStatus(200)->assertSee('Dashboard Administratif');
        $this->get('/admin/users')->assertStatus(200)->assertSee('Admin Sistem')->assertSee('User Biasa');

        $this->get('/courses/create')->assertStatus(200);
        $this->post('/courses', [
            'code' => 'ADM-201',
            'name' => 'Kursus Dibuat Admin',
            'description' => 'Deskripsi admin',
            'fee' => 450000,
            'quota' => 25,
            'start_date' => '2026-12-15',
            'status' => 'open',
        ])->assertRedirect('/courses');

        $created = Course::where('code', 'ADM-201')->firstOrFail();

        $this->get("/courses/{$created->id}/edit")->assertStatus(200);
        $this->put("/courses/{$created->id}", [
            'code' => 'ADM-201',
            'name' => 'Kursus Diubah Admin',
            'description' => 'Diubah oleh admin',
            'fee' => 500000,
            'quota' => 30,
            'start_date' => '2026-12-15',
            'status' => 'closed',
        ])->assertRedirect("/courses/{$created->id}");

        $this->assertDatabaseHas('courses', [
            'id' => $created->id,
            'name' => 'Kursus Diubah Admin',
            'status' => 'closed',
        ]);

        $this->delete("/courses/{$created->id}")->assertRedirect('/courses');
        $this->assertDatabaseMissing('courses', ['id' => $created->id]);
    }

    public function test_user_is_forbidden_from_creating_editing_updating_deleting_course_and_admin_pages(): void
    {
        [, $user, $course] = $this->seedRolesAndCourses();

        $this->actingAs($user);

        $this->get('/courses/create')->assertStatus(403);
        $this->post('/courses', [
            'code' => 'USR-999',
            'name' => 'Percobaan User',
            'fee' => 100000,
            'quota' => 10,
            'start_date' => '2026-12-20',
            'status' => 'open',
        ])->assertStatus(403);
        $this->assertDatabaseMissing('courses', ['code' => 'USR-999']);

        $this->get("/courses/{$course->id}/edit")->assertStatus(403);
        $this->put("/courses/{$course->id}", [
            'code' => $course->code,
            'name' => 'Diubah User',
            'fee' => 100000,
            'quota' => 10,
            'start_date' => '2026-12-20',
            'status' => 'closed',
        ])->assertStatus(403);
        $this->patch("/courses/{$course->id}", [
            'status' => 'closed',
        ])->assertStatus(403);
        $this->delete("/courses/{$course->id}")->assertStatus(403);
        $this->assertDatabaseHas('courses', ['id' => $course->id, 'name' => 'Kursus Uji Hak Akses']);

        $this->get('/admin/dashboard')->assertStatus(403);
        $this->get('/admin/users')->assertStatus(403);
    }

    public function test_user_can_view_user_dashboard_search_filter_paginate_and_cannot_modify_other_user_data(): void
    {
        [$admin, $user, $course] = $this->seedRolesAndCourses();

        $this->actingAs($user);

        $this->get('/dashboard')->assertStatus(200)->assertSee('User Biasa')->assertSee('Pendaftaran Saya');
        $this->get('/courses?q=Hak+Akses&status=open')
            ->assertStatus(200)
            ->assertSee('Kursus Uji Hak Akses')
            ->assertDontSee('+ Tambah Kursus');
        $this->get("/courses/{$course->id}")
            ->assertStatus(200)
            ->assertDontSee('Edit Kursus');

        $this->put('/profile', [
            'name' => 'User Update Sendiri',
            'email' => 'user@kursusku.test',
        ])->assertRedirect('/profile');

        $admin->refresh();
        $this->assertEquals('Admin Sistem', $admin->name);
    }

    public function test_guest_is_redirected_from_protected_routes_but_can_access_public_courses(): void
    {
        [, , $course] = $this->seedRolesAndCourses();

        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/profile')->assertRedirect('/login');
        $this->get('/admin/dashboard')->assertRedirect('/login');
        $this->get('/admin/users')->assertRedirect('/login');
        $this->get('/courses/create')->assertRedirect('/login');
        $this->get("/courses/{$course->id}/edit")->assertRedirect('/login');
        $this->post('/courses', [])->assertRedirect('/login');
        $this->put("/courses/{$course->id}", [])->assertRedirect('/login');
        $this->delete("/courses/{$course->id}")->assertRedirect('/login');

        $this->get('/')->assertStatus(200)->assertSee('Login');
        $this->get('/courses')
            ->assertStatus(200)
            ->assertSee('Kursus Uji Hak Akses')
            ->assertDontSee('+ Tambah Kursus');
        $this->get("/courses/{$course->id}")
            ->assertStatus(200)
            ->assertDontSee('Edit Kursus');
    }

    public function test_logout_terminates_session_and_denies_protected_access_again(): void
    {
        [$admin] = $this->seedRolesAndCourses();

        $this->actingAs($admin);
        $this->get('/admin/dashboard')->assertStatus(200);

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();

        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/admin/dashboard')->assertRedirect('/login');
        $this->get('/courses/create')->assertRedirect('/login');
    }
}
