<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return $this->admin($request);
        }

        $participant = Participant::where('email', $user->email)->first();
        $myEnrollments = $participant
            ? $participant->enrollments()->with('course')->latest()->get()
            : collect();

        $stats = [
            'totalCourses' => Course::count(),
            'openCourses' => Course::where('status', 'open')->count(),
            'myEnrollmentsCount' => $myEnrollments->count(),
        ];

        return view('dashboard.index', compact('user', 'stats', 'myEnrollments'));
    }

    public function admin(Request $request): View
    {
        $user = $request->user();
        abort_unless($user?->isAdmin(), 403);

        $stats = [
            'totalCourses' => Course::count(),
            'openCourses' => Course::where('status', 'open')->count(),
            'closedCourses' => Course::where('status', 'closed')->count(),
            'draftCourses' => Course::where('status', 'draft')->count(),
            'totalParticipants' => Participant::count(),
            'totalEnrollments' => Enrollment::count(),
            'totalUsers' => User::count(),
        ];

        return view('admin.dashboard', compact('user', 'stats'));
    }
}
