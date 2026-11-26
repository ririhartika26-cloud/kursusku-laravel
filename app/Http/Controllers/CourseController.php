<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $rawStatus = $request->query('status');
        $allowedStatuses = ['open', 'closed', 'draft'];
        $status = in_array($rawStatus, $allowedStatuses, true) ? $rawStatus : null;

        $query = Course::query();

        if ($q !== '') {
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('code', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%");
            });
        }

        if ($status !== null) {
            $query->where('status', $status);
        }

        $courses = $query->latest()->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('courses._table', compact('courses', 'q', 'status'));
        }

        return view('courses.index', compact('courses', 'q', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Course::class);

        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        Gate::authorize('create', Course::class);

        Course::create($request->validated());

        return to_route('courses.index')
            ->with('success', 'Kursus berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        Gate::authorize('update', $course);

        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        Gate::authorize('update', $course);

        $course->update($request->validated());

        return to_route('courses.show', $course)
            ->with('success', 'Kursus berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        Gate::authorize('delete', $course);

        $course->delete();

        return to_route('courses.index')
            ->with('success', 'Kursus berhasil dihapus.');
    }
}
