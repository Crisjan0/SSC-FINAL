<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required|unique:courses|max:255',
            'abbreviation' => 'required|max:10',
        ]);

        Course::create($validated);
        return back()->with('success', 'New course added!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return back()->with('success', 'Course removed.');
    }
}
