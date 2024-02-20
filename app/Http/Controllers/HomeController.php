<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
use App\Models\terms;
use App\Models\User;
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
            $terms = terms::all();

            return view('newPatientDashBoardv1', ['diagnostic_categories' => $diagnostic_categories, 'patientDtl' => $patientDtl, 'drugs' => $drugs, 'names' => $names, 'medical_tests' => $medical_tests, 'investigationDel' => $investigationDel, 'investigation_history' => $investigation_history, 'reccomanded_opd_drugs' => $reccomanded_opd_drugs, 'reccomanded_outside_drugs' => $reccomanded_outside_drugs, 'reccomanded_medical_test' => $reccomanded_medical_test, 'terms'=>$terms]);
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

    public function updateProfilePicture(Request $request)
    {
        try {
            $request->validate([
                'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 2048 kilobytes = 2 megabytes
            ]);
            $user = Auth::user();
            if ($request->hasFile('profile_picture')) {
                // Check if the file size exceeds the limit
                $maxFileSize = 2048 * 1024; // Convert to kilobytes
                if ($request->file('profile_picture')->getSize() > $maxFileSize) {
                    return redirect()->route('profile')->with('error', 'File size exceeds the limit.');
                }
                // Delete existing profile picture
                if ($user->profile_picture) {
                    Storage::disk('public')->delete($user->profile_picture);
                }
                // Store new profile picture
                $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                $user->profile_picture = $profilePicturePath;
                $user->save();
            }
            return redirect()->route('profile')->with('success', 'Profile picture updated successfully.');
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    // need to implement
    public function profile()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        try {
            $currentDate = Carbon::today();
            $Patients = User::find($request->id);
            $Patients->update([
                'name' => $request->name,
                'age' => $request->age,
                'mid' => $request->mid,
                'nic' =>  $request->nic,
                'number' => $request->number,
            ]);

            $appoinments =  Appoinment::with('patients')->select('appoinments.*', 'patients.name as patientname', 'patients.id as patientid')->leftJoin('patients', 'appoinments.patient_id', '=', 'patients.id')->where('appoinments.status', '=', '0')
                ->where('appoinments.date', '=', $currentDate)
                ->where('patients.status', '=', '0')
                ->where('appoinments.active', '=', '0')
                ->get();
            return view('newDoctorScreen', ['appoinments' => $appoinments])->with('success', 'Successfully Updated User !');
        } catch (Exception $e) {

            return view('newDoctorScreen', ['appoinments' => $appoinments])->with('error', $e->getMessage());
        }
    }

    public function printOPd($id)
    {
        try {
            $currentDate = Carbon::today();
            $amount =  InvestigationDetails::all(['amount'])->where('patient_id', '=', $id)->where('channel_date', '=', $currentDate);
            $drug_history = reccomandedOpdDrugs::all(['drug', 'dose', 'period', 'terms'])->where('appointmnt_date', '=', $currentDate)->where('patient_id', '=', $id);
            $patients =  Patients::all()->where('id', '=', $id);
            $appId = Appoinment::all()->where('patient_id', '=', $id)->where('date', '=', $currentDate);
            return view('opd_report', ['opdReport' => $drug_history, 'patients' => $patients, 'amount' => $amount, 'appoi' => $appId]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
