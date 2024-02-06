<?php

namespace App\Http\Controllers;

use App\Models\InvestigationDetails;
use Illuminate\Http\Request;
use App\Models\Appoinment;
use App\Models\DiagnosticCategory;
use App\Models\Drugs;
use App\Models\investigationHistory;
use App\Models\medicalTests;
use App\Models\Patients;
use App\Models\reccomandedOpdDrugs;
use App\Models\reccomandOutsideDrugs;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

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
        try {

            $currentDate = Carbon::today();

            $appoinments =  Appoinment::with('patients')->select('appoinments.*', 'patients.name as patientname', 'patients.id as patientid')->leftJoin('patients', 'appoinments.patient_id', '=', 'patients.id')->where('appoinments.status', '=', '0')->where('appoinments.date', '=', $currentDate)->where('patients.status', '=', '0')->where('appoinments.active', '=', '0')->get();

            return view('newDoctorScreen', ['appoinments' => $appoinments]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function helps()
    {
        return view('help');
    }
    public function view_patient_details($id)
    {

        try {

            $currentDate = Carbon::today();
            $diagnostic_categories =  DiagnosticCategory::all()->where('status', '=', '0');
            
            $patientDtl =  Patients::select('patients.*', 'titles.title as title')->leftJoin('titles', 'patients.title', '=', 'titles.id')->where('patients.id', '=', $id)->get();

            $investigationDel =  InvestigationDetails::all()->where('patient_id', '=', $id)->where('channel_date', '=', $currentDate);

            $drugs =  Drugs::all()->where('status', '=', '0');

            $medical_tests =  medicalTests::all()->where('status', '=', '0');

            $names = Patients::all()->where('status', '=', '0')->pluck('name', 'id');


            $investigation_history =  investigationHistory::all()->where('patient_id', '=', $id)->where('appointment_date', '=', $currentDate);

            $reccomanded_opd_drugs =  reccomandedOpdDrugs::all()->where('patient_id', '=', $id)->where('appoinment_date', '=', $currentDate);


            $reccomanded_outside_drugs =  reccomandOutsideDrugs::all()->where('patient_id', '=', $id)->where('appoinment_date', '=', $currentDate);

            $reccomanded_medical_test =  medicalTests::all()->where('patient_id', '=', $id)->where('appoinment_date', '=', $currentDate);

            return view('newPatientDashBoardv1', ['diagnostic_categories' => $diagnostic_categories, 'patientDtl' => $patientDtl, 'drugs' => $drugs, 'names' => $names, 'medical_tests' => $medical_tests, 'investigationDel' => $investigationDel, 'investigation_history' => $investigation_history, 'reccomanded_opd_drugs' => $reccomanded_opd_drugs, 'reccomanded_outside_drugs' => $reccomanded_outside_drugs, 'reccomanded_medical_test' => $reccomanded_medical_test]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function view_appoiment_details($channel_date, $patient_id)
    {
        try {

            $diagnostic_categories =  DiagnosticCategory::all()->where('status', '=', 0);

            $patientDtl =  Patients::with('title')->select('patients.*', 'titles.title as title')->leftJoin('titles', 'patients.title', '=', 'titles.id')->where('patients.id', '=', $patient_id)->get();

            $investigationDel =  InvestigationDetails::all()->where('patient_id', '=', $patient_id)->where('channel_date', '=', $channel_date);

            $drugs =  Drugs::all()->where('status', '=', '0');

            $medical_tests =  medicalTests::all()->where('status', '=', '0');

            $names = Patients::all()->where('status', '=', '0')->pluck('name', 'id');

            $investigation_history =  investigationHistory::all()->where('patient_id', '=', $patient_id)->where('appoinment_date', '=', $channel_date);

            $reccomanded_opd_drugs =  reccomandedOpdDrugs::all()->where('patient_id', '=', $patient_id)->where('appoinment_date', '=', $channel_date);

            $reccomanded_outside_drugs =  reccomandOutsideDrugs::all()->where('patient_id', '=', $patient_id)->where('appoinment_date', '=', $channel_date);

            $reccomanded_medical_test =  medicalTests::all()->where('patient_id', '=', $patient_id)->where('appoinment_date', '=', $channel_date);
            return view('newPatientDashBoardv1', ['diagnostic_categories' => $diagnostic_categories, 'patientDtl' => $patientDtl, 'drugs' => $drugs, 'names' => $names, 'medical_tests' => $medical_tests, 'investigationDel' => $investigationDel, 'investigation_history' => $investigation_history, 'reccomanded_opd_drugs' => $reccomanded_opd_drugs, 'reccomanded_outside_drugs' => $reccomanded_outside_drugs, 'reccomanded_medical_test' => $reccomanded_medical_test]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function appointment_search(Request $request)
    {

        try {

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
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function homeview()
    {
        try {

            $currentDate = Carbon::today();
            $waiting_list =  Appoinment::with('patients')->select('appoinments.*')->leftJoin('patients', 'appoinments.patient_id', '=', 'patients.id')->where('appoinments.status', '=', '0')->where('appoinments.date', '=', $currentDate)->where('patients.status', '=', '0')->get()->count();

            $finished_list =  Appoinment::with('patients')->select('appoinments.*', 'patients.name as patientname')->leftJoin('patients', 'appoinments.patient_id', '=', 'patients.id')->where('appoinments.status', '=', '1')->where('appoinments.date', '=', $currentDate)->where('patients.status', '=', '0')->get()->count();

            $patient_list = Patients::with('title')->select('patients.*', 'titles.title as title')->join('titles', 'titles.id', '=', 'patients.title')->where('patients.status', '=', '0')->count();

            $drugs_list =  Drugs::all()->where('status', '=', '0')->count();


            return view('home', ['waiting_list' => $waiting_list, 'finished_list' => $finished_list, 'patient_list' => $patient_list, 'drugs_list' => $drugs_list]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
