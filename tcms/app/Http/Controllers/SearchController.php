<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $results = ['students' => collect(), 'teachers' => collect(), 'classes' => collect()];

        if (strlen($query) >= 2) {
            $results['students'] = Student::where('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->with('classrooms')
                ->take(10)
                ->get();

            $results['teachers'] = Teacher::where('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%")
                ->take(10)
                ->get();

            $results['classes'] = Classroom::where('name', 'like', "%{$query}%")
                ->orWhere('section', 'like', "%{$query}%")
                ->take(10)
                ->get();
        }

        return view('search', compact('query', 'results'));
    }
}
