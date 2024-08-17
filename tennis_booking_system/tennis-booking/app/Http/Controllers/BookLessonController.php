<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BookLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookLessonController extends Controller
{
    public function store(Request $request)
    {
       
        $validated_data = $request->validate([
            'coach' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        
        $booking = BookLesson::create([
            'student_id' => Auth::id(), 
            'coach_id' => $validated_data['coach'],
            'booking_date' => $validated_data['date'],
            'booking_time' => $validated_data['time'],
        ]);

        return response()->json([
            'message' => 'Lesson booked successfully!',
            'booking' => $booking,
        ], 201);
    }
}
