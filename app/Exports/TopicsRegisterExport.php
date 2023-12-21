<?php

namespace App\Exports;

use App\Topic;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TopicsRegisterExport implements FromView, ShouldAutoSize
{
    protected $nien_khoa;
    public function view(): View
    {
        $this->nien_khoa = DB::table("configurations")->first()->academic_year;
                            
        $register_result = DB::table('user_register_topics')
        ->join('users as students', 'user_register_topics.user_id', '=', 'students.id')
        ->join('topics', 'user_register_topics.topic_id', '=', 'topics.id')
        ->join('users as instructors', 'topics.user_id', '=', 'instructors.id')
        ->select('topics.id as topic_id', 'topics.name as topic_name', 'topics.department', 
        'students.name as student_name', 'students.username as student_id', 'instructors.name as instructor_name')
        ->where('topics.academic_year', '=', $this->nien_khoa)
        ->orderBy('instructor_name', 'asc')
        ->orderBy('topic_name', 'asc')
        ->get();

        return view('exports.topics-register', [
            'register_result' => $register_result
        ])->with('i',0);
    }
}
