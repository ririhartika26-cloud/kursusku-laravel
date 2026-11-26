<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseSearchFilterPaginationTest extends TestCase
{
    use RefreshDatabase;

    private function seedSampleCourses(int $openCount = 12, int $closedCount = 2, int $draftCount = 2): void
    {
        for ($i = 1; $i <= $openCount; $i++) {
            Course::create([
                'code' => sprintf('OPEN-%03d', $i),
                'name' => $i === 1 ? 'Laravel Fundamental' : "Kursus Open {$i}",
                'description' => "Deskripsi kursus open {$i}",
                'fee' => 300000,
                'quota' => 20,
                'start_date' => '2026-12-01',
                'status' => 'open',
            ]);
        }

        for ($i = 1; $i <= $closedCount; $i++) {
            Course::create([
                'code' => sprintf('CLSD-%03d', $i),
                'name' => "Kursus Closed {$i}",
                'description' => "Deskripsi kursus closed {$i}",
                'fee' => 350000,
                'quota' => 15,
                'start_date' => '2026-12-05',
                'status' => 'closed',
            ]);
        }

        for ($i = 1; $i <= $draftCount; $i++) {
            Course::create([
                'code' => sprintf('DRFT-%03d', $i),
                'name' => "Kursus Draft {$i}",
                'description' => "Deskripsi kursus draft {$i}",
                'fee' => 250000,
                'quota' => 10,
                'start_date' => '2026-12-10',
                'status' => 'draft',
            ]);
        }
    }

    public function test_search_with_zero_results_shows_empty_state_without_error(): void
    {
        $this->seedSampleCourses(3, 1, 1);

        $response = $this->get('/courses?q=tidakadakursusini');

        $response->assertStatus(200);
        $response->assertSee('Tidak ditemukan kursus yang sesuai dengan kriteria pencarian.');
        $response->assertSee('Reset Pencarian');
    }

    public function test_search_with_single_result_displays_exact_one_course(): void
    {
        $this->seedSampleCourses(5, 1, 1);

        $response = $this->get('/courses?q=Laravel');

        $response->assertStatus(200);
        $response->assertSee('Laravel Fundamental');
        $response->assertSee('OPEN-001');
        $courses = $response->viewData('courses');
        $this->assertEquals(1, $courses->total());
    }

    public function test_pagination_limits_ten_items_per_page_and_page_two_works(): void
    {
        $this->seedSampleCourses(12, 0, 0);

        $page1 = $this->get('/courses');
        $page1->assertStatus(200);
        $this->assertEquals(10, $page1->viewData('courses')->count());
        $this->assertEquals(12, $page1->viewData('courses')->total());

        $page2 = $this->get('/courses?page=2');
        $page2->assertStatus(200);
        $this->assertEquals(2, $page2->viewData('courses')->count());
    }

    public function test_search_trims_leading_and_trailing_spaces(): void
    {
        $this->seedSampleCourses(3, 0, 0);

        $response = $this->get('/courses?q=' . urlencode('   OPEN-001   '));

        $response->assertStatus(200);
        $response->assertSee('Laravel Fundamental');
        $this->assertEquals('OPEN-001', $response->viewData('q'));
    }

    public function test_filter_and_search_persist_across_pagination_page_two(): void
    {
        $this->seedSampleCourses(12, 2, 2);

        $response = $this->get('/courses?q=Kursus&status=open&page=2');

        $response->assertStatus(200);
        $courses = $response->viewData('courses');
        $this->assertEquals(11, $courses->total());
        $this->assertEquals(1, $courses->count());
        $this->assertEquals('Kursus', $response->viewData('q'));
        $this->assertEquals('open', $response->viewData('status'));
        $response->assertSee('q=Kursus');
        $response->assertSee('status=open');
    }

    public function test_status_filters_open_closed_draft_and_invalid_status_handling(): void
    {
        $this->seedSampleCourses(2, 1, 1);

        $openRes = $this->get('/courses?status=open');
        $openRes->assertStatus(200);
        $this->assertEquals(2, $openRes->viewData('courses')->total());

        $closedRes = $this->get('/courses?status=closed');
        $closedRes->assertStatus(200);
        $this->assertEquals(1, $closedRes->viewData('courses')->total());

        $draftRes = $this->get('/courses?status=draft');
        $draftRes->assertStatus(200);
        $this->assertEquals(1, $draftRes->viewData('courses')->total());

        $invalidRes = $this->get('/courses?status=invalid_hack');
        $invalidRes->assertStatus(200);
        $this->assertNull($invalidRes->viewData('status'));
        $this->assertEquals(4, $invalidRes->viewData('courses')->total());
    }

    public function test_ajax_request_returns_partial_table_without_full_layout(): void
    {
        $this->seedSampleCourses(2, 0, 0);

        $response = $this->get('/courses?q=Laravel', [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Laravel Fundamental');
        $response->assertDontSee('<!doctype html>');
    }

    public function test_home_dashboard_count_displays_real_database_statistics(): void
    {
        $this->seedSampleCourses(3, 1, 1);
        $participant = Participant::create([
            'name' => 'Peserta Uji',
            'email' => 'peserta@example.test',
        ]);
        $course = Course::first();
        Enrollment::create([
            'participant_id' => $participant->id,
            'course_id' => $course->id,
            'status' => 'registered',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $stats = $response->viewData('stats');
        $this->assertEquals(5, $stats['totalCourses']);
        $this->assertEquals(3, $stats['openCourses']);
        $this->assertEquals(1, $stats['totalParticipants']);
        $this->assertEquals(1, $stats['totalEnrollments']);
    }

    public function test_existing_course_crud_continues_to_work(): void
    {
        $admin = \App\Models\User::create([
            'name' => 'Admin CRUD',
            'email' => 'admin.crud@kursusku.test',
            'role' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('AdminKursusKu123!'),
        ]);
        $this->actingAs($admin);

        $storeResponse = $this->post('/courses', [
            'code' => 'NEW-101',
            'name' => 'Kursus Baru Uji',
            'description' => 'Deskripsi uji CRUD',
            'fee' => 450000,
            'quota' => 25,
            'start_date' => '2026-12-30',
            'status' => 'open',
        ]);
        $storeResponse->assertRedirect('/courses');

        $course = Course::where('code', 'NEW-101')->firstOrFail();

        $this->get("/courses/{$course->id}")->assertStatus(200)->assertSee('Kursus Baru Uji');
        $this->get("/courses/{$course->id}/edit")->assertStatus(200);

        $updateResponse = $this->put("/courses/{$course->id}", [
            'code' => 'NEW-101',
            'name' => 'Kursus Baru Diubah',
            'description' => 'Deskripsi diperbarui',
            'fee' => 500000,
            'quota' => 30,
            'start_date' => '2026-12-30',
            'status' => 'closed',
        ]);
        $updateResponse->assertRedirect("/courses/{$course->id}");
        $this->assertDatabaseHas('courses', ['id' => $course->id, 'name' => 'Kursus Baru Diubah', 'status' => 'closed']);

        $deleteResponse = $this->delete("/courses/{$course->id}");
        $deleteResponse->assertRedirect('/courses');
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
