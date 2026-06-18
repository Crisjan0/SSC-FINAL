<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Payment;
use App\Models\Course;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Start the query builder
        $query = Payment::query();

        // 2. Apply search filters IF a search term exists
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            
            // Use a "Nested Where" to keep the search logic grouped
            $query->where(function($q) use ($searchTerm) {
                $q->where('student_name', 'like', "%{$searchTerm}%")
                ->orWhere('course', 'like', "%{$searchTerm}%")
                ->orWhere('year_level', 'like', "%{$searchTerm}%");
            });
        }

        // 3. Finalize the query with sorting and pagination
        // Do NOT use Payment::paginate() here; use the $query variable!
        $payments = $query->latest()
                        ->paginate(10)
                        ->onEachSide(1)
                        ->withQueryString(); // Keeps search term in pagination links

        return view('payments.index', compact('payments')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
       // This looks for resources/views/payments/create.blade.php
        return view('payments.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
        'student_name' => 'required|string|max:255',
        'course'       => 'required|string|max:255',
        'year_level'   => 'nullable|string|max:50',
        'amount'       => 'required|numeric',
        'date'         => 'required|date',
        'description'  => 'required|string|max:255',
    ]);

    // 2. Auto-capitalize student name
    $validated['student_name'] = ucwords(strtolower($validated['student_name']));

    // 3. Add the 'recorded_by' automatically from the logged-in user
    $validated['recorded_by'] = auth()->user()->name;

    // 4. Save to the database
    Payment::create($validated);

    // 4. Redirect back with a success message
    return redirect()->route('payments.index')->with('success', 'Payment recorded successfully!');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payment $payment)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'user') {
            abort(403, 'Unauthorized. Only admins can edit payments.');
        }

        $courses = Course::all();
        return view('payments.edit', compact('payment', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, payment $payment)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'user') {
            abort(403, 'Unauthorized. Only admins can update payments.');
        }

        $validated = $request->validate([
        'student_name' => 'required|string',
        'course'       => 'required|string',
        'amount'       => 'required|numeric',
        'date'         => 'required|date',
        'description'  => 'required|string',
        'year_level'   => 'nullable|string|max:50',
    ]);

    // Auto-capitalize student name
    $validated['student_name'] = ucwords(strtolower($validated['student_name']));

    // Keep the original 'recorded_by' or update it to the person who edited it
    $validated['recorded_by'] = auth()->user()->name;

    $payment->update($validated);

    return redirect()->route('payments.index')->with('success', 'Payment record updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payment $payment)
    {
       if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can delete payments.');
       }

       $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment archived successfully!');
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDelete($id)
    {
       if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can delete payments.');
       }

       $payment = Payment::withTrashed()->findOrFail($id);
       $payment->forceDelete();
       return redirect()->back()->with('success', 'Payment permanently deleted!');
    }
   
    // --- EXPORT METHOD ---
    public function export()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=payments_" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Student Name', 'Course', 'Year Level', 'Amount', 'Date', 'Description', 'Recorded By'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Chunking the data for better performance
            Payment::chunk(500, function($payments) use ($file) {
                foreach ($payments as $payment) {
                    fputcsv($file, [
                        $payment->student_name,
                        $payment->course,
                        $payment->year_level,
                        $payment->amount,
                        $payment->date,
                        $payment->description,
                        $payment->recorded_by ?? 'System User', // Fallback if recorded_by is null
                    ]);
                }
            });
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // --- IMPORT METHOD ---
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = fopen($request->file('file')->getRealPath(), 'r');
        
        // Read the header row to determine column indices dynamically
        $header = fgetcsv($file);
        if (!$header) {
            return back()->with('error', 'Invalid CSV file format.');
        }

        // Convert headers to lowercase for easier matching
        $header = array_map('strtolower', array_map('trim', $header));

        $nameIndex = array_search('student name', $header);
        $courseIndex = array_search('course', $header);
        $yearLevelIndex = array_search('year level', $header);
        $amountIndex = array_search('amount', $header);
        $dateIndex = array_search('date', $header);
        $descIndex = array_search('description', $header);
        $recordedByIndex = array_search('recorded by', $header);

        // Standard comma separated
        while (($data = fgetcsv($file, 2000, ",")) !== FALSE) {
            $studentName = $nameIndex !== false ? ucwords(strtolower(trim($data[$nameIndex] ?? ''))) : '';

            // Only process if the row isn't empty (check student name)
            if (trim($studentName) !== '') {
                
                // Parse Date to ensure valid format, fallback to today if invalid
                $dateStr = $dateIndex !== false ? ($data[$dateIndex] ?? '') : '';
                $parsedDate = date('Y-m-d', strtotime($dateStr));
                if (!$parsedDate || $parsedDate == '1970-01-01') {
                    $parsedDate = now()->toDateString();
                }

                $course = $courseIndex !== false ? trim($data[$courseIndex] ?? '') : '';
                
                $yearLevel = $yearLevelIndex !== false ? trim($data[$yearLevelIndex] ?? '') : null;
                if ($yearLevel === '') $yearLevel = null;
                
                $amount = $amountIndex !== false ? (float) ($data[$amountIndex] ?? 0) : 0;
                $description = $descIndex !== false ? trim($data[$descIndex] ?? 'No description') : 'No description';

                // Use firstOrCreate to prevent duplicate records.
                // It checks if a record exists matching the first array, 
                // and if not, creates one merging both arrays.
                Payment::firstOrCreate(
                    [
                        'student_name' => $studentName,
                        'course'       => $course,
                        'year_level'   => $yearLevel,
                        'amount'       => $amount,
                        'date'         => $parsedDate,
                        'description'  => $description,
                    ],
                    [
                        'recorded_by'  => auth()->user()->name,
                    ]
                );
            }
        }

        fclose($file);
        return back()->with('success', 'Payments imported successfully!');
    }

    // --- ARCHIVED / TRASHED PAYMENTS ---
    public function archiveAll(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can archive all payments.');
        }

        $request->validate([
            'archive_batch_name' => 'required|string|max:255'
        ]);

        $batchName = $request->archive_batch_name;

        // Add the batch name to all active records
        Payment::query()->update(['archive_batch_name' => $batchName]);
        
        // Soft deletes all active payments
        Payment::query()->delete(); 

        return redirect()->route('payments.index')->with('success', "All active records archived under '{$batchName}' successfully!");
    }
    public function archived(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can view archived payments.');
        }

        $query = Payment::onlyTrashed()
            ->selectRaw('
                archive_batch_name, 
                count(*) as total_records, 
                sum(amount) as total_amount, 
                max(deleted_at) as archived_date
            ')
            ->groupBy('archive_batch_name');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('archive_batch_name', 'like', "%{$searchTerm}%");
        }

        $batches = $query->orderBy('archived_date', 'desc')
                        ->paginate(10)
                        ->withQueryString();

        return view('payments.archived.index', compact('batches'));
    }

    public function showArchivedBatch(Request $request, $batchName)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can view archived payments.');
        }

        $query = Payment::onlyTrashed();

        if ($batchName === 'Uncategorized') {
            $query->whereNull('archive_batch_name');
        } else {
            $query->where('archive_batch_name', $batchName);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('student_name', 'like', "%{$searchTerm}%")
                ->orWhere('course', 'like', "%{$searchTerm}%")
                ->orWhere('year_level', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        $payments = $query->orderBy('deleted_at', 'desc')
                        ->paginate(10)
                        ->withQueryString();

        return view('payments.archived.show', compact('payments', 'batchName'));
    }

    public function restoreBatch(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can restore payments.');
        }

        $batchName = $request->input('batch_name');

        if (empty($batchName) || $batchName === 'N/A') {
            // Restore all where batch name is null
            Payment::onlyTrashed()->whereNull('archive_batch_name')->restore();
            Payment::whereNull('archive_batch_name')->update(['archive_batch_name' => null]);
            $displayName = 'Uncategorized';
        } else {
            Payment::onlyTrashed()->where('archive_batch_name', $batchName)->restore();
            Payment::where('archive_batch_name', $batchName)->update(['archive_batch_name' => null]);
            $displayName = $batchName;
        }

        return redirect()->route('payments.archived')->with('success', "Batch '{$displayName}' restored successfully!");
    }

    public function restore($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized. Only admins can restore payments.');
        }

        $payment = Payment::withTrashed()->findOrFail($id);
        $payment->restore();

        return redirect()->route('payments.index')->with('success', 'Payment record restored successfully!');
    }
}
