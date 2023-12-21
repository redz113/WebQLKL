<?php

namespace App\Http\Controllers;

// use Maatwebsite\Excel\Facades\Excel;

use App\Exports\InstructorTopicsListExport;
use App\Exports\TopicsRegisterExport;
use Auth;
use App\Models\File;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DateTime;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Spatie\Permission\Models\Role;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class TopicController extends Controller
{
    var $configuratons;
    var $nien_khoa;
    var $departmentArr =  array('1' => 'CNPM', '2' => 'KHMT', '3' => 'HTTT', '4' => 'KTMT', '5' => 'PPGD');
    var $academic_year_arr = [];

    var $instructorArr = [];
    function __construct()
    {
        $this->configurations = DB::table("configurations")
                        ->select('academic_year', 'reg_open_date', 'reg_close_date')
                        ->first();
                        
        $this->nien_khoa = $this->configurations->academic_year;
           
        //ds GVHD
        $instructors = DB::table('users')
                        ->select(['id', 'name'])
                        ->where('role', 4)
                        ->get();

        foreach($instructors as $item){
            $this->instructorArr[$item->id] = $item->name;
        }

        $current_academic_year = idate('Y') - 1953;    //Niên khóa hiện tại
        //DS NIên khóa (tính từ K60)
        for($i = $current_academic_year - 5; $i <= $current_academic_year + 5 ; $i++){
            $this->academic_year_arr['K'.$i] = "K" .$i;
        }

        $this->middleware('permission:topic-list|topic-create|topic-edit|topic-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:topic-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:topic-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:topic-delete', ['only' => ['destroy']]);
        $this->middleware('permission:topic-report', ['only' => ['export']]);
        $this->middleware('permission:topic-register', ['only' => ['topicRegister', 'topicRegisterList']]);
        $this->middleware('permission:instructor-topic-list', ['only' => ['instructorTopicList', 'instructorShow']]);
    }

    public function index(Request $request)
    {
        $param = $request->all();

        // $topics = Topic::filter($param);

        $topics = DB::table('topics')
            ->join('users', 'topics.user_id', '=', 'users.id')
            ->select('topics.*', 'users.name as instructor_name');

        if(!empty($request->department)){
            $topics = $topics->where('department', $request->department);
        }

        if(!empty($request->academic_year)){
            $topics = $topics->where('topics.academic_year', $request->academic_year);
        }

        
        if(isset($request->status) && $request->status != ""){
            $topics = $topics->where('status', $request->status);
        }
        
        if(isset($request->keyword) && trim($request->keyword) != ""){
            $kw = trim($request->keyword);
            $topics->where(function($query) use ($kw){
                $query->orWhere('topics.name', 'LIKE', '%' . $kw . '%');
                $query->orWhere('users.name', 'LIKE', '%' . $kw . '%');
            });
        }

        $topics = $topics->paginate(10)->fragment('topics-list');

        $departmentArr = $this->departmentArr;
        $academic_year_arr = $this->academic_year_arr;

        // $topics = $topics->paginate(10)->appends($param);
        return view('topics.index', compact('topics', 'param', 'departmentArr', 'academic_year_arr'))
            ->with('i', (request()->input('page', 1) - 1) * 10);


        // $param = $request->all();
        // if (Auth::user()->can('topic-list')) {
        //     $fields = Field::pluck('name', 'id')->all();
        //     $provinces = Province::pluck('name', 'id')->all();
        //     $users = User::whereIn('role', [3, 6])->pluck('name', 'id')->all();
        //     $groups = Group::pluck('name', 'id')->all();
        //     $medals = Medal::pluck('name', 'id')->all();
        // }
        // $researchs = Research::filter($param);

        // if (Auth::user()->role > 2 && Auth::user()->role != 8) {
        //     $researchs->where('user_id', Auth::user()->id);
        //     $param = ['user_id' => Auth::user()->id];
        // } else {
        //     $researchs->orderBy('id', 'ASC');
        // }
        // $researchs = $researchs->paginate(10)->appends($param);
        // return view('researchs.index', compact('researchs', 'param', 'fields', 'provinces', 'users', 'groups', 'medals'))
        //     ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create() {
        $departmentArr = $this->departmentArr;
        $instructorArr = $this->instructorArr;
        $nien_khoa = $this->nien_khoa;
        $academic_year_arr = $this->academic_year_arr;

        $roles = Role::where('id', ">", Auth::user()->role)->pluck('name', 'id')->all();
        return view("topics.create", compact(
            'roles', 
            'instructorArr', 
            'departmentArr', 
            'nien_khoa',
            'academic_year_arr'
        ));
    }

    

    public function topicRegisterList(Request $request, $sort)
    {
        $param = $request->all();
        
        $start = $this->configurations->reg_open_date;
        $end = $this->configurations->reg_close_date;
        $end_time = strtotime($end);
        $start_date = new DateTime($start);//start time
        $end_date = new DateTime($end);//end time
        $current_date_time = Carbon::now();

        $topics = DB::table('topics')
            ->join('users', 'topics.user_id', '=', 'users.id')
            ->select('topics.id', 'topics.name', 'topics.department', 'topics.number_student', 
            'topics.note', 'users.name as instructor_name', 'topics.status', 'topics.description', 'topics.required')
            ->where('topics.academic_year', '=', $this->nien_khoa);
        
        // Ngoài thời gian đăng ký
        if ($start_date >= $current_date_time) {
            $topics = $topics->paginate(10);
            return view('topics.register_timeout', ['topics' => $topics])
            ->with('i', (request()->input('page', 1) - 1) * 10);
        }
        // Ngoài thời gian đăng ký
        if ($current_date_time >= $end_date) {
            $topics = $topics->paginate(10);
             return view('topics.register_timeout', ['topics' => $topics])
             ->with('i', (request()->input('page', 1) - 1) * 10);
        }
        
        
        $number_student = DB::table('user_register_topics')
                        ->select(DB::raw('count(user_id) as number_student'))
                        ->where('user_id', '=', Auth::User()->id)
                        ->value('number_student');
                        
        //SV da dang ky de tai
        if ((int)$number_student > 0){
            return redirect('topic-register-details');
        }

        $sort_param = [
            'topics_name' => 'topics_name_asc',
            'topics_department' => 'topics_department_asc',
            'users_name' => 'users_name_asc',
            'topics_status' => 'topics_status_asc'
        ];
        $orderBy = 'topics.created_at';
        $order_direct = 'desc';
        
        $sort = explode("_", $sort);
        if(count($sort) == 3){
            $sort_key = $sort[0] . "_" . $sort[1];
            $direct = $sort[2];
            foreach ($sort_param as $key => $value) {
                if($sort_key == $key){
                    $orderBy = str_replace('_', '.', $key);
                    $order_direct = $direct;
                    $direct = ($direct == 'asc') ? 'desc' : 'asc';
                    $sort_param[$key] = $key . "_" . $direct;
                }
            }
        }

        $topics = $topics->orderBy($orderBy, $order_direct)
                        ->orderBy('topics.department', 'asc')
                        ->paginate(10)->appends($param);
        
        // Kiểm tra đăng ký
        $currentUser = User::find(Auth::user()->id);
        $userAY = $currentUser->academic_year;
        $checkRegister = true;
        if(Auth::user()->role == 5){
            $checkRegister = ($userAY == $this->nien_khoa) ? true : false;   
        }

        return view('topics.register', compact('topics', 'param', 'sort_param', 'checkRegister'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function topicRegister(Request $request)
    {
        $user_id = Auth::User()->id;
        $topic_id = $request->topic_id;
        echo $user_id.' Đăng ký đề tài '.$topic_id;

        //Tìm thông tin topic theo id
        $topic = DB::table('topics')->where(['id' => $topic_id]);
        $topic_status = $topic->value('status');
        $max_student = $topic->value('number_student');
        $number_student = DB::table('user_register_topics')
                        ->select(DB::raw('count(user_id) as number_student'))
                        ->where('topic_id', '=', $topic_id)
                        ->value('number_student');
        
        echo '<br>'.$topic_status.' - '.$max_student.' - '.$number_student;
        if ($topic_status = '1' && ((int)$number_student < (int)$max_student)) {
            echo '<br>Có thể đăng ký';
            //Lưu thông tin đăng ký đề tài
            DB::table('user_register_topics')->insert([
                'user_id' => $user_id,
                'topic_id' => $topic_id,
                'semester' => $this->nien_khoa
            ]);
            $topic = DB::table('topics')->where(['id' => $topic_id]);
            $max_student = $topic->value('number_student');
            $number_student = DB::table('user_register_topics')
                            ->select(DB::raw('count(user_id) as number_student'))
                            ->where('topic_id', '=', $topic_id)
                            ->value('number_student');
            if (((int)$number_student >= (int)$max_student)){
                DB::table('topics')
                ->where('id', $topic_id)
                ->update(['status' => 0]);
            }
            Toastr::success('Đăng ký đề tài thành công');
            return redirect('topic-register-details');
        }
        else {
            echo '<br>Đề tài đã đủ sinh viên';
            DB::table('topics')
                ->where('id', $topic_id)
                ->update(['status' => 0]);
            Toastr::error('Đề tài đã đủ sinh viên');
            return redirect('topics-register-list/all');
        }
        
    }

    public function topicRegisterDetails(Request $request)
    {
        $user_id = Auth::User()->id;
        $topic_id = DB::table('user_register_topics')->where('user_id', $user_id)->value('topic_id');
        if ($topic_id == ''){
            Toastr::warning('Bạn chưa đăng ký đề tài nào!');
            return redirect('topics-register-list/all');
        }
        else{
            $topic = DB::table('topics')
            ->join('users', 'topics.user_id', '=', 'users.id')
            ->select('topics.id', 'topics.name', 'topics.department', 'topics.number_student', 
            'topics.note', 'users.name as instructor_name', 'topics.status', 'topics.required', 'topics.description')
            ->where('topics.id', $topic_id)
            ->get()->first();
            
            return view('topics.register_details', ['topic' => $topic]);
        }
    }

    public function showTopicConfirm($topic_id)
    {

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $start = $this->configurations->reg_open_date;
        $end = $this->configurations->reg_close_date;
        $end_time = strtotime($end);
        $start_date = new DateTime($start);//start time
        $end_date = new DateTime($end);//end time
        $current_date_time = Carbon::now();

        if ($start_date >= $current_date_time) {
            return view('topics.register_timeout');
        }

        if ($current_date_time >= $end_date) {
             return view('topics.register_timeout');
        }

        $user_id = Auth::User()->id;
        $registed_topic_id = DB::table('user_register_topics')->where('user_id', $user_id)->value('topic_id');
        if ($registed_topic_id != ''){

            $registed_topic = DB::table('topics')
            ->join('users', 'topics.user_id', '=', 'users.id')
            ->select('topics.id', 'topics.name', 'topics.department', 'topics.number_student', 
            'topics.note', 'users.name as instructor_name', 'topics.status', 'topics.required', 'topics.description')
            ->where('topics.id', $registed_topic_id)
            ->get()->first();

            Toastr::warning('Bạn đã có đề tài rồi!');
            return view('topics.register_details', ['topic' => $registed_topic]);
        }

        $topic = Topic::where('id', $topic_id)->get();
        $topic = $topic[0];
        $user_id = $topic->user_id;
        $user = User::where('id', '=', $user_id)->get();
        $user = $user[0];

        if ($topic->status == '1') {
            return view('topics.register_details_confirm', ['topic' => $topic, 'user' => $user]);
        } else {
            Toastr::warning('Bạn không được phép xem đề tài này');
            return redirect('topics-register-list/all');
        }

        
    }

    public function topicRegisterCancel(Request $request)
    {
        $user_id = Auth::User()->id;
        $topic_id = DB::table('user_register_topics')->where('user_id', $user_id)->value('topic_id');
        DB::table('user_register_topics')->where('user_id', $user_id)->delete();
        DB::table('topics')
        ->where('id', $topic_id)
        ->update(['status' => 1]);
        Toastr::error('Bạn đã hủy đăng ký đề tài!');

        return redirect('topics-register-list/all');
        
    }

    public function testTime() {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $start = $this->configurations->reg_open_date;
        $end = $this->configurations->reg_close_date;
        echo $start.' - '.$end.'<br>';

        $start_date = new DateTime($start);//start time
        $end_date = new DateTime($end);//end time
        $current_date_time = Carbon::now();
        if ($start_date <= $current_date_time && $current_date_time <= $end_date) {
            $interval = $end_date->diff($current_date_time);
        }
        
        // echo $interval->format('%Y years %m months %d days %H hours %i minutes %s seconds');
        echo $interval->format('%D Ngày %H Giờ %I Phút %S Giây');
            
        echo '<br>'.$current_date_time = Carbon::now()->toDateTimeString();
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'department' => 'required',
            'user_id' => 'required',
            'number_student' => 'required'
        ], [
            'required' => "Vui lòng nhập :attribute",
        ], [
            'name' => "tên Đề tài",
            'department' => "tên Bộ môn",
            'number_student' => "Số lượng sinh viên",
            'user_id' => "tên Giảng viên hướng dẫn"
        ]
        );
        
        $data = $request->only(['name', 'number_student', 'required', 'user_id', 'note']);
        $data['department'] = $this->departmentArr[$request->department];
        $data['academic_year'] = $this->nien_khoa;
    
        // Kiểm tra đề tài đã tồn tại
        $checkExist = Topic::where(['name' => $data['name'], 'user_id' => $data['user_id'], 'academic_year' => $data['academic_year']])->get();
        if(!empty($checkExist[0]->id)){
            return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'checkExist' => 'Tên đề tài đã tồn tại!',
                    ]);
        }
    
    Topic::create($data);
    
    Toastr::success('Thêm đề tài thành công');
    return redirect()->route($request->routeRedirect);
    }

    public function show(Topic $topic)
    {
        $user_id = $topic->user_id;
        $user = User::where('id', '=', $user_id)->get();

        $students = DB::table('user_register_topics')
        ->join('users', 'user_register_topics.user_id', '=', 'users.id')
        ->where('user_register_topics.topic_id', $topic->id)
        ->get();
        return view('topics.show', [
            'topic' => $topic, 
            'user' => $user[0],
            'students'=> $students,
            'i'=> 0,
        ]);
    }

    public function showRegisterResult () {
        $register_result = DB::table('user_register_topics')
        ->join('users as students', 'user_register_topics.user_id', '=', 'students.id')
        ->join('topics', 'user_register_topics.topic_id', '=', 'topics.id')
        ->join('users as instructors', 'topics.user_id', '=', 'instructors.id')
        ->select('topics.id as topic_id', 'topics.name as topic_name', 'topics.department', 
        'students.name as student_name', 'students.username as student_id', 'instructors.name as instructor_name')
        ->where('topics.academic_year', '=', $this->nien_khoa)
        ->orderBy('instructor_name', 'asc')
        ->orderBy('topic_name', 'asc')
        ->paginate(30);
        return view('topics.show_register_result', ['register_result' => $register_result])
        ->with('i', (request()->input('page', 1) - 1) * 30); 
    }

    public function edit(Topic $topic)
    {
        $user_id = $topic->user_id;
        //thoong tin taif khoan
        // $user = User::where('id', '=', $user_id)->get();
       
        return view('topics.edit', [
            'topic' => $topic, 
            // 'user' => $user[0], 
            'departmentArr' => $this->departmentArr,
            'instructorArr' => $this->instructorArr,
            'nien_khoa' => $this->nien_khoa,
            'academic_year_arr' => $this->academic_year_arr,
        ]);
    }

    public function update(Request $request, Topic $topic)
    {
        request()->validate([
            'name' => 'required',
            'department' => 'required',
            'user_id' => 'required',
            'number_student' => 'required'
        ], [
            'required' => "Vui lòng nhập :attribute",
        ], [
            'name' => "tên Đề tài",
            'department' => "tên Bộ môn",
            'number_student' => "Số lượng sinh viên",
            'user_id' => "tên Giảng viên hướng dẫn"
        ]);

        $students = DB::table('user_register_topics')
        ->join('users', 'user_register_topics.user_id', '=', 'users.id')
        ->where('user_register_topics.topic_id', $topic->id)
        ->get();

       
        $data = $request->only('_token', '_method', 'name', 'department', 'number_student', 'note', 'required', 'user_id');
        $data['department'] = $this->departmentArr[$data['department']];
        $data['academic_year'] = $request->academic_year;
        $data['status'] = (count($students) == $data['number_student']) ? 0 : 1;

        $topic->update($data);
        Toastr::success('Cập nhật đề tài thành công');

        return redirect()->route($request->routeRedirect, $topic);
    }

    //Instructuor
    public function instructorTopicList () {
        $user = Auth::User();
        $topics = Topic::where('user_id', $user->id)->paginate(10);
        $param = ['user_id' => $user->id];
        $instructorName = auth()->user()->name;
        return view('topics.instructor.show', compact('user', 'param', 'topics', 'instructorName'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function instructorShow (Topic $topic) {
        $user_id = $topic->user_id;
        $user = User::where('id', '=', $user_id)->get();
        $students = DB::table('user_register_topics')
        ->join('users', 'user_register_topics.user_id', '=', 'users.id')
        ->where('user_register_topics.topic_id', $topic->id)
        ->get();
        return view('topics.instructor.show_details', ['topic' => $topic, 'user' => $user[0], 'students' => $students, 'i' => 0]);
    }

    public function instructorEdit (Topic $topic) {
        $user_id = $topic->user_id;
        $user = User::where('id', '=', $user_id)->get();
        $departmentArr = ($this->departmentArr);
    
        return view('topics.instructor.edit', [
            'topic' => $topic, 
            'user' => $user[0], 
            'departmentArr' => $departmentArr,
            'academic_year_arr' => $this->academic_year_arr,
        ]);
    }

    public function instructorCreate (Topic $topic) {
        $departmentArr = ($this->departmentArr);
        $roles = Role::where('id', ">", Auth::user()->role)->pluck('name', 'id')->all();
        return view("topics.instructor.create", [
            'roles' => $roles,
            'departmentArr' => $this->departmentArr,
            'nien_khoa' => $this->nien_khoa,
        ]);
    }

    public function destroy($id)
    {
        Topic::where('id', '=', $id)->delete();
        DB::table('user_register_topics')->where('topic_id', $id)->delete();
        return redirect()->back()->with('Success', 'Xóa đề tài thành công');
    }


     // export topics register result
     public function topicsRegisterExport() 
     {
        return Excel::download(new TopicsRegisterExport, 'topics_register_result.xlsx');
     }

     public function instructorTopicsListExport() 
     {
        return Excel::download(new InstructorTopicsListExport, 'instructor_topics_list.xlsx');
     }
}
