<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConfigurationsController extends Controller
{
    private $configurations;
    private $data = [];

    public function __construct(){
         $this->configurations = DB::table("configurations")
                        ->select('academic_year', 'reg_open_date', 'reg_close_date')
                        ->first();
                        
        $this->data['nien_khoa'] = $this->configurations->academic_year;
        
        $current_academic_year = idate('Y') - 1953;    //Niên khóa hiện tại
        //DS NIên khóa (tính từ K60)
        for($i = $current_academic_year - 5; $i <= $current_academic_year + 5 ; $i++){
            $this->data['academic_year_arr']['K'.$i] = "K" .$i;
        }


        $start = $this->configurations->reg_open_date;
        $this->data['start_date'] = Carbon::parse($start)->format('Y-m-d\TH:i');
        
        $end = $this->configurations->reg_close_date;
        $this->data['end_date'] = Carbon::parse($end)->format('Y-m-d\TH:i');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("configurations.index", $this->data);
    }


    public function edit()
    {
        return view("configurations.edit", $this->data);

    }

    public function add(Request $request){
        $this->data['start_date'] = $request->input("start_date");
        $this->data['end_date'] = $request->input("end_date");

        $start_date = new \DateTime($this->data['start_date']);
        $end_date = new \DateTime($this->data['end_date']);

        $current_date = Carbon::now();

        if($end_date < $start_date){
            return view('configurations.edit', $this->data)
                ->with('error', 'Ngày mở cổng đăng ký phải trước ngày đóng!');
        }

        if($current_date > $end_date){
            return view('configurations.edit', $this->data)
                ->with('error', 'Ngày đóng cổng đăng ký phải trước ngày hiện tại!');
        }


        //cập nhập ngày đăng ký
        DB::table('configurations')
        ->update([
            'academic_year' => $request->academic_year,
            'reg_open_date'=> $this->data['start_date'], 
            'reg_close_date'=> $this->data['end_date']
        ]);

        Toastr::success("Cập nhập thành công!");
        return redirect()->route('configurations.index');
    }
}
