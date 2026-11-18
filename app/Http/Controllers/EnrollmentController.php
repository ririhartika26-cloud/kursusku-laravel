<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the enrollments.
     */
    public function index(): View
    {
        $enrollments = Enrollment::with(['participant', 'course'])
            ->latest()
            ->get();

        return view('enrollments.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new enrollment.
     */
    public function create(): View
    {
        $participants = Participant::orderBy('name')->get();
        $courses = Course::where('status', 'open')->orderBy('name')->get();

        return view('enrollments.create', compact('participants', 'courses'));
    }

    /**
     * Store a newly created enrollment in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'participant_id' => ['required', 'exists:participants,id'],
            'course_id' => [
                'required',
                'exists:courses,id',
                Rule::unique('enrollments')->where(function ($query) use ($request) {
                    return $query->where('participant_id', $request->participant_id);
                }),
            ],
        ], [
            'participant_id.required' => 'Peserta wajib dipilih.',
            'participant_id.exists' => 'Peserta yang dipilih tidak valid.',
            'course_id.required' => 'Kursus wajib dipilih.',
            'course_id.exists' => 'Kursus yang dipilih tidak valid.',
            'course_id.unique' => 'Participant ini sudah terdaftar pada course tersebut.',
        ]);

        $validated['status'] = 'registered';

        Enrollment::create($validated);

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Enrollment berhasil ditambahkan.');
    }
}
