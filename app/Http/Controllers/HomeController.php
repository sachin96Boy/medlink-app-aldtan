<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appoinment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $currentDate = Carbon::today();

        $appoinments =  DB::table('appoinments')
        ->select('appoinments.*', DB::raw('patients.name as patientname'),DB::raw('patients.id as patientid'))
        ->leftjoin('patients','appoinments.patient_id','=','patients.id')
        ->where('appoinments.status' , '=', '0')
        ->where('appoinments.date' , '=', $currentDate)
         ->where('patients.status' , '=', '0')
             ->where('appoinments.active' , '=', '0')
        ->get();
        
        
        return view('newDoctorScreen', ['appoinments' => $appoinments]);

    }
        public function helps(){
        return view('help');
    }
    public function view_patient_details($id)
    {

        $diagnostic_categories =  DB::table('diagnostic_categories')
        ->select('diagnostic_categories.*')
        ->where('diagnostic_categories.status' , '=', '0')
        ->get();
        $currentDate = Carbon::today();
        
        $patientDtl =  DB::table('patients')
        ->select('patients.*', DB::raw('titles.title as title'))
        ->leftjoin('titles','patients.title','=','titles.id')
        ->where('patients.id' , '=', $id)
        ->get();

        $investigationDel =  DB::table('investigation_details')
        ->select('investigation_details.*')
        ->where('investigation_details.patient_id' , '=', $id)
        ->where('investigation_details.channel_date' , '=', $currentDate)

        ->get();

        $drugs =  DB::table('drugs')
        ->select('drugs.*')
        ->where('drugs.status' , '=', '0')
        ->get();

        $medical_tests =  DB::table('medical_tests')
        ->select('medical_tests.*')
        ->where('medical_tests.status' , '=', '0')
        ->get();

        $names = DB::table('patients')->where('status', 0)->pluck('name', 'id');
        


        $investigation_history =  DB::table('investigation_history')
        ->select('investigation_history.*')
        ->where('investigation_history.patient_id' , '=', $id)
        ->where('investigation_history.appointment_date' , '=', $currentDate)
        ->get();

        $reccomanded_opd_drugs =  DB::table('reccomanded_opd_drugs')
        ->select('reccomanded_opd_drugs.*')
        ->where('reccomanded_opd_drugs.patient_id' , '=', $id)
        ->where('reccomanded_opd_drugs.appointment_date' , '=', $currentDate)
        ->get();

        $reccomanded_outside_drugs =  DB::table('reccomanded_outside_drugs')
        ->select('reccomanded_outside_drugs.*')
        ->where('reccomanded_outside_drugs.patient_id' , '=', $id)
        ->where('reccomanded_outside_drugs.appointment_date' , '=', $currentDate)
        ->get();

        $reccomanded_medical_test =  DB::table('medical_test')
        ->select('medical_test.*')
        ->where('medical_test.patient_id' , '=', $id)
        ->where('medical_test.appointment_date' , '=', $currentDate)
        ->get();
        return view('newPatientDashBoardv1',['diagnostic_categories' => $diagnostic_categories ,'patientDtl' => $patientDtl ,'drugs' => $drugs,'names' => $names,'medical_tests' => $medical_tests,'investigationDel'=>$investigationDel, 'investigation_history'=>$investigation_history, 'reccomanded_opd_drugs'=>$reccomanded_opd_drugs, 'reccomanded_outside_drugs'=>$reccomanded_outside_drugs, 'reccomanded_medical_test'=>$reccomanded_medical_test]);
    }
    public function view_appoiment_details($channel_date, $patient_id)
    {

        $diagnostic_categories =  DB::table('diagnostic_categories')
        ->select('diagnostic_categories.*')
        ->where('diagnostic_categories.status' , '=', '0')
        ->get();
        
        $patientDtl =  DB::table('patients')
        ->select('patients.*', DB::raw('titles.title as title'))
        ->leftjoin('titles','patients.title','=','titles.id')
        ->where('patients.id' , '=', $patient_id)
        ->get();

        $investigationDel =  DB::table('investigation_details')
        ->select('investigation_details.*')
        ->where('investigation_details.patient_id' , '=', $patient_id)
        ->where('investigation_details.channel_date' , '=', $channel_date)

        ->get();

        $drugs =  DB::table('drugs')
        ->select('drugs.*')
        ->where('drugs.status' , '=', '0')
        ->get();

        $medical_tests =  DB::table('medical_tests')
        ->select('medical_tests.*')
        ->where('medical_tests.status' , '=', '0')
        ->get();

        $names = DB::table('patients')->where('status', 0)->pluck('name', 'id');
        


        $investigation_history =  DB::table('investigation_history')
        ->select('investigation_history.*')
        ->where('investigation_history.patient_id' , '=', $patient_id)
        ->where('investigation_history.appointment_date' , '=', $channel_date)
        ->get();

        $reccomanded_opd_drugs =  DB::table('reccomanded_opd_drugs')
        ->select('reccomanded_opd_drugs.*')
        ->where('reccomanded_opd_drugs.patient_id' , '=', $patient_id)
        ->where('reccomanded_opd_drugs.appointment_date' , '=', $channel_date)
        ->get();

        $reccomanded_outside_drugs =  DB::table('reccomanded_outside_drugs')
        ->select('reccomanded_outside_drugs.*')
        ->where('reccomanded_outside_drugs.patient_id' , '=', $patient_id)
        ->where('reccomanded_outside_drugs.appointment_date' , '=', $channel_date)
        ->get();

        $reccomanded_medical_test =  DB::table('medical_test')
        ->select('medical_test.*')
        ->where('medical_test.patient_id' , '=', $patient_id)
        ->where('medical_test.appointment_date' , '=', $channel_date)
        ->get();
        return view('newPatientDashBoardv1',['diagnostic_categories' => $diagnostic_categories ,'patientDtl' => $patientDtl ,'drugs' => $drugs,'names' => $names,'medical_tests' => $medical_tests,'investigationDel'=>$investigationDel, 'investigation_history'=>$investigation_history, 'reccomanded_opd_drugs'=>$reccomanded_opd_drugs, 'reccomanded_outside_drugs'=>$reccomanded_outside_drugs, 'reccomanded_medical_test'=>$reccomanded_medical_test]);
    }

  public function appointment_search(Request $request)
    {
        
         $validate = $request->validate([
            'keyword' => 'required',
        ]);

        $mytime = Carbon::today();
        $currentDate = $mytime->format('Y-m-d');

        $appoinments = DB::table('appoinments')
            ->leftjoin('patients', 'appoinments.patient_id', '=', 'patients.id');

        if (isset($request->keyword)) {
            $keyword = $request->keyword;
            $appoinments = $appoinments->orwhere("patients.nic", 'LIKE', '%' . $keyword . '%');
            $appoinments = $appoinments->orwhere("patients.family_name", 'LIKE', '%' . $keyword . '%');
            $appoinments = $appoinments->orwhere("patients.name", 'LIKE', '%' . $keyword . '%');
            $appoinments = $appoinments->orwhere("patients.mobile", 'LIKE', '%' . $keyword . '%');
            $appoinments = $appoinments->orwhere("patients.address", 'LIKE', '%' . $keyword . '%');
        }
        $appoinments = $appoinments->where("patients.status", "=", "0")
            ->select('appoinments.*', DB::raw('patients.name as patientname'), DB::raw('patients.id as patientid'))
            ->where('appoinments.status', '=', '0')
            ->where('appoinments.date', '=', $currentDate)
            ->where('patients.status', '=', '0')
            ->orderBy('appoinments.date', 'DESC')->get();

        return view('newDoctorScreen', ['appoinments' => $appoinments]);
    }
    
    public function homeview()
    {

        $currentDate = Carbon::today();
        $waiting_list =  DB::table('appoinments')
        ->select('appoinments.*')
        ->leftjoin('patients','appoinments.patient_id','=','patients.id')
        ->where('appoinments.status' , '=', "0")
        ->where('appoinments.date' , '=', $currentDate)
        ->where('patients.status' , '=', '0')
        ->get()
        ->count();


        $finished_list =  DB::table('appoinments')
    ->select('appoinments.*', DB::raw('patients.name as patientname'))
    ->leftjoin('patients','appoinments.patient_id','=','patients.id')
    ->where('appoinments.status' , '=', "1")
    ->where('appoinments.date' , '=', $currentDate)
    ->where('patients.status' , '=', '0')
    ->get()
    ->count();


    $patient_list = DB::table('patients')
            ->join('titles', 'titles.id', '=', 'patients.title')
            ->where("patients.status", "=", "0")
            ->select('patients.*','titles.title as title')
            ->get()
            ->count();

            $drugs_list =  DB::table('drugs')
            ->select('drugs.*')
            ->where('drugs.status' , '=', "0")
            ->get()
            ->count();


        return view('home', ['waiting_list' => $waiting_list , 'finished_list' => $finished_list , 'patient_list' => $patient_list , 'drugs_list' => $drugs_list]);

    }
    
    
}
