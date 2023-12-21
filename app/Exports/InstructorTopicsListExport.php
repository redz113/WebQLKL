<?php

namespace App\Exports;

use App\Models\User;
use App\Topic;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InstructorTopicsListExport implements FromView, ShouldAutoSize
{
    protected $data = [];
    public function view(): View
    {
        $this->data['user'] = (request()->id) ? DB::table('users')->where('id', request()->id)->get() : Auth::user();
        // dd($this->data['user']);
        $this->data['topics'] = \App\Models\Topic::where("user_id", $this->data['user'][0]->id)->get();
        // $this->data['param'] = ['user_id' => $this->data['user']->id];
        $this->data['instructorName'] = $this->data['user'][0]->name;
        // $this->data['i'] = 0;

        return view("exports.instructor-topics-list", $this->data)
        ->with('i', 0);
    }
}
