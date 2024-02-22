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
use App\Models\Period;
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
        // go deeply through this view to make sure
        // ui functions correctly
        try {
            $currentDate = Carbon::today();
            $diagnostic_categories =  DiagnosticCategory::all()->where('status', '=', '0');
            $patientDtl =  Patients::select('patients.*', 'titles.title as title')->leftJoin('titles', 'patients.title', '=', 'titles.id')->where('patients.id', '=', $id)->get();
            $investigationDel =  InvestigationDetails::all()->where('patient_id', '=', $id)->where('channel_date', '=', $currentDate);

            $rinvestigationDel_show = collect([$investigationDel->last()]);

            $drugs =  Drugs::all()->where('status', '=', '0');
            $medical_tests =  medicalTests::all()->where('status', '=', '0');
            $names = Patients::all()->where('status', '=', '0')->pluck('name', 'id');
            $investigation_history =  investigationHistory::all()->where('patient_id', '=', $id)->where('appointment_date', '=', $currentDate);

            $investigation_history_show = collect([$investigation_history->last()]);

            $reccomanded_opd_drugs =  reccomandedOpdDrugs::all()->where('patient_id', '=', $id)->where('appoinment_date', '=', $currentDate);
            $reccomanded_outside_drugs =  reccomandOutsideDrugs::all()->where('patient_id', '=', $id)->where('appoinment_date', '=', $currentDate);
            $reccomanded_medical_test =  medicalTests::all()->where('patient_id', '=', $id)->where('appoinment_date', '=', $currentDate);

            $reccomanded_medical_test_show = collect([$reccomanded_medical_test->last()]);

            $terms = terms::all();
            $period = Period::all();

            return view('newPatientDashBoardv1', ['diagnostic_categories' => $diagnostic_categories, 'patientDtl' => $patientDtl, 'drugs' => $drugs, 'names' => $names, 'medical_tests' => $medical_tests, 'investigationDel' => $investigationDel, 'investigation_history' => $investigation_history, 'reccomanded_opd_drugs' => $reccomanded_opd_drugs, 'reccomanded_outside_drugs' => $reccomanded_outside_drugs, 'reccomanded_medical_test' => $reccomanded_medical_test, 'terms' => $terms, 'reccomanded_medical_test_show' => $reccomanded_medical_test_show, 'investigation_history_show' => $investigation_history_show, 'rinvestigationDel_show' => $rinvestigationDel_show, 'period' => $period]);
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

            $rinvestigationDel_show = $investigationDel;

            $drugs =  Drugs::all()->where('status', '=', '0');
            $medical_tests =  medicalTests::all()->where('status', '=', '0');
            $names = Patients::all()->where('status', '=', '0')->pluck('name', 'id');
            $investigation_history =  investigationHistory::all()->where('patient_id', '=', $patient_id)->where('appoinment_date', '=', $channel_date);

            $investigation_history_show = $investigation_history;

            $reccomanded_opd_drugs =  reccomandedOpdDrugs::all()->where('patient_id', '=', $patient_id)->where('appoinment_date', '=', $channel_date);
            $reccomanded_outside_drugs =  reccomandOutsideDrugs::all()->where('patient_id', '=', $patient_id)->where('appoinment_date', '=', $channel_date);
            $reccomanded_medical_test =  medicalTests::all()->where('patient_id', '=', $patient_id)->where('appoinment_date', '=', $channel_date);

            $reccomanded_medical_test_show = $reccomanded_medical_test;

            $terms = terms::all();
            $period = Period::all();

            return view('newPatientDashBoardv1', ['diagnostic_categories' => $diagnostic_categories, 'patientDtl' => $patientDtl, 'drugs' => $drugs, 'names' => $names, 'medical_tests' => $medical_tests, 'investigationDel' => $investigationDel, 'investigation_history' => $investigation_history, 'reccomanded_opd_drugs' => $reccomanded_opd_drugs, 'reccomanded_outside_drugs' => $reccomanded_outside_drugs, 'reccomanded_medical_test' => $reccomanded_medical_test, 'terms' => $terms, 'reccomanded_medical_test_show' => $reccomanded_medical_test_show, 'investigation_history_show' => $investigation_history_show, 'rinvestigationDel_show' => $rinvestigationDel_show, 'period' => $period]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function appointment_search(Request $request)
    {
        // try to complete the appoinments search part using models 
        // insted of query builder in db
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
        // make sure to migrate a fresh updated copy of usermodel 
        try {
            $request->validate([
                'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 2048 kilobytes = 2 megabytes
            ]);
            $userAuth = Auth::user();

            $user = User::find($userAuth->id);
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

    public function updateFingerprints(Request $request)
    {
        try {
            $newUserId = $request->input('newUserId');
            $oldUserId = $request->input('oldUserId');

            $newPatient = Patients::find($newUserId);

            if (!$newPatient) {
                return "No matching record found for user $newUserId";
            }

            $fingerprintData = $newPatient->fingerprint_id;

            $oldPatient = Patients::find($oldUserId);

            if (!$oldPatient) {
                return "No matching record found for user $oldUserId";
            }

            $fingers = ['finger2', 'finger3', 'finger4', 'finger5'];

            foreach ($fingers as $finger) {
                if ($oldPatient->$finger === null) {
                    $oldPatient->$finger = $fingerprintData;
                    $oldPatient->save();
                }
            }
            $newPatient->fingerprint_id = '';
            $newPatient->status = '1';
            $newPatient->save();

            // Record updated successfully for user $newUserId

            Appoinment::where('patient_id', $newUserId)
                ->update(['patient_id' => $oldUserId]);

            InvestigationDetails::where('patient_id', $newUserId)
                ->update(['patient_id' => $oldUserId]);

            // make sure below data models follow capital begin letter

            DB::table('reccomanded_outside_drugs')
                ->where('patient_id', $newUserId)
                ->update(['patient_id' => $oldUserId]);

            DB::table('reccomanded_opd_drugs')
                ->where('patient_id', $newUserId)
                ->update(['patient_id' => $oldUserId]);

            DB::table('investigation_history')
                ->where('patient_id', $newUserId)
                ->update(['patient_id' => $oldUserId]);

            DB::table('medical_test')
                ->where('patient_id', $newUserId)
                ->update(['patient_id' => $oldUserId]);

            // All columns are filled
            $currentDate = Carbon::today();

            $appoinments =  Appoinment::with('patient')
                ->select('appoinments.*', 'patients.name as patientname', 'patients.id as patientid')
                ->leftjoin('patients', 'appoinments.patient_id', '=', 'patients.id')
                ->where('appoinments.status', '=', '0')
                ->where('appoinments.date', '=', $currentDate)
                ->where('patients.status', '=', '0')
                ->where('appoinments.active', '=', '0')
                ->get();

            session()->flash('message', 'Assign user Successfully ..!');
            return view('newDoctorScreen', ['appoinments' => $appoinments]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function reports()
    {

        try {

            $currentDate = Carbon::today();
            $finishedList = Appoinment::select('appoinments.*', 'patients.name as patientname', 'investigation_details.amount')
                ->leftJoin('patients', 'appoinments.patient_id', '=', 'patients.id')
                ->leftJoin('investigation_details', function ($join) {
                    $join->on('appoinments.patient_id', '=', 'investigation_details.patient_id')
                        ->where('investigation_details.channel_date', '=', now()->toDateString());
                })
                ->where('appoinments.date', now()->toDateString())
                ->where('appoinments.status', '1')
                ->get();

            $monthlyReports = [];

            for ($i = 0; $i < 12; $i++) {
                $currentMonth = $currentDate->copy()->subMonths($i);
                $monthData = InvestigationDetails::whereMonth('channel_date', $currentMonth->month)
                    ->whereYear('channel_date', $currentMonth->year)
                    ->get();

                $monthlyReports[] = [
                    'month' => $currentMonth->format('F Y'),
                    'numberOfPatients' => $monthData->count(),
                    'totalAmount' => $monthData->sum('amount'),
                ];
            }


            $yearlyReports = [];

            for ($i = 0; $i < 12; $i++) {
                $currentYear = $currentDate->copy()->subYears($i)->year;

                if ($currentYear > 2022) {
                    $yearData = InvestigationDetails::whereYear('channel_date', $currentYear)
                        ->get();

                    $yearlyReports[] = [
                        'year' => $currentYear,
                        'numberOfPatients' => $yearData->count(),
                        'totalAmount' => $yearData->sum('amount'),
                    ];
                }
            }


            return view('reports', ['finishedList' => $finishedList, 'monthlyReports' => $monthlyReports, 'yearlyReports' => $yearlyReports]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
