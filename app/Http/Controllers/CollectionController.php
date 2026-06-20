<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class CollectionController extends Controller
{
    public function index()
    {
        $courseCollections = Payment::selectRaw('course, sum(amount) as total')
                                    ->groupBy('course')
                                    ->orderBy('course', 'asc')
                                    ->get();

        return view('collections.index', compact('courseCollections'));
    }

    public function show(Request $request, $course)
    {
        // Handle empty/null courses mapped to 'unknown'
        if ($course === 'unknown') {
            $baseQuery = Payment::where(function($q) {
                $q->whereNull('course')->orWhere('course', '');
            });
        } else {
            $baseQuery = Payment::where('course', $course);
        }

        // Grand total for this course (unfiltered)
        $totalCollection = (clone $baseQuery)->sum('amount');

        $query = clone $baseQuery;

        // Year level filter
        if ($request->filled('year_level')) {
            $query->where('year_level', $request->year_level);
        }

        // Search filter
        if ($request->filled('search')) {
            $searchTerms = preg_split('/\s+/', trim($request->search), -1, PREG_SPLIT_NO_EMPTY);

            foreach ($searchTerms as $term) {
                $query->where(function($q) use ($term) {
                    $q->where('student_name', 'like', "%{$term}%")
                      ->orWhere('year_level', 'like', "%{$term}%")
                      ->orWhere('description', 'like', "%{$term}%");
                });
            }
        }

        // Filtered total (after year level filter)
        $filteredTotal = (clone $query)->sum('amount');

        $payments = $query->orderBy('student_name', 'asc')
                          ->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->onEachSide(1)
                          ->withQueryString();

        return view('collections.show', compact('payments', 'course', 'totalCollection', 'filteredTotal'));
    }
}
