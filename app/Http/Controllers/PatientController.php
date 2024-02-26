<?php

namespace App\Http\Controllers;

use App\Models\Appoinment;
use App\Models\InvestigationDetails;
use App\Models\investigationHistory;
use App\Models\MedicalTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Title;
use App\Models\Patients;
//use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;

class PatientController extends Controller
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
    public function view()
    {
        try {
            $titles =  Title::all();
            $familyNames =  Patients::all('family_name')->groupBy('family_name');
            return view('patientAdd', ['titles' => $titles], ['familyNames' => $familyNames]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function add(Request $request)
    {
        try {
            $data = [
                'title' => $request->title,
                'family_name' => $request->family_name,
                'name' => $request->name,
                'birthday' =>  $request->birthday,
                'age' => $request->age,
                'gender' => $request->gender,
                'address' => $request->address,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'height_feets' => $request->height_feets,
                'height_inches' => $request->height_inches,
                'height_cen' => $request->height_cen,
                'weight' => $request->weight,
                'nic' => $request->nic,
                'occupation' => $request->occupation,
            ];
            Patients::with('title')->create($data);
            session()->flash('message', 'Successfully Added Patient !');
            return redirect()->back()->with('success', 'Successfully Added Patient !');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function patient_list_search_by_family_name(Request $request)
    {
        try {
            $patient_list = Patients::with('title')->select('patients.*', 'titles.id as title')->leftJoin('titles', 'patients.title', '=', 'titles.id')->get();
            if (isset($request->family_name)) {
                $family_name = $request->family_name;
                $patient_list = $patient_list->where("patients.family_name", $family_name);
            }
            $patient_list = $patient_list->where("patients.status", "=", "0")
                ->select('patients.*', 'titles.title as title')
                ->get();
            return view('patisentpopup', ['patient_list' => $patient_list, 'currentPatientId' => $request->currentPatientId]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function genReport(Request $request)
    {
        $selectedValues = $request->input('selectedRows');
        $id = $request->input('id');
        $patients =  Patients::with('title')->select('patients.*', 'titles.id as title')->leftJoin('titles', 'patients.title', '=', 'titles.id')->where('id', '=', $id)->get();
        $pageName = $request->input('pageName');
        $pdf = Pdf::loadView('test', ['pageName' => $pageName, 'selectedValues' => $selectedValues, 'patients' => $patients]);
        return $pdf->stream();
    }
    public function drugReport(Request $request)
    {
        $id = $request->input('id');
        $patients =  Patients::with('title')->select('patients.*', 'titles.id as title')->leftJoin('titles', 'patients.title', '=', 'titles.id')->where('id', '=', $id)->get();
        $selectedRows = $request->input('selectedRows');
        $pageName = $request->input('pageName');
        $pdf = Pdf::loadView('drugreport', ['selectedRows' => $selectedRows, 'pageName' => $pageName, 'patients' => $patients]);
        return $pdf->stream();
    }

    public function patient_list_view()
    {
        try {
            $current = Carbon::today();
            $famname =  Patients::all('family_name')->groupBy('family_name');
            $apoinment_list = Appoinment::all()->where('date', '=', $current)->where('active', '=', '0');
            $patient_list = Patients::with('title')->select('patients.*', 'titles.title as title')->join('titles', 'titles.id', '=', 'patients.title')->where('patients.status', '=', '0')->get();
            return view('patientListView', ['famname' => $famname, 'patient_list' => $patient_list, 'appoinment_list' => $apoinment_list]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function patient_list_search(Request $request)
    {
        try {
            $validate = $request->validate([
                'keyword' => 'required',
            ]);

            $current = Carbon::today();

            $apoinment_list = Appoinment::all()
                ->where('date', '=', $current)
                ->where('active', '=', '0');


            $famname =  Patients::all('family_name')
                ->groupBy('family_name');
            $patient_list = Patients::with('title')
                ->join('titles', 'patients.title', '=', 'titles.id')
                ->where('patients.status', '=', '0');
            if (isset($request->keyword)) {
                $keyword = $request->keyword;
                $patient_list->where(function ($query) use ($keyword) {
                    $query->orWhere("patients.nic", 'LIKE', '%' . $keyword . '%')
                        ->orWhere("patients.family_name", 'LIKE', '%' . $keyword . '%')
                        ->orWhere("patients.name", 'LIKE', '%' . $keyword . '%')
                        ->orWhere("patients.mobile", 'LIKE', '%' . $keyword . '%')
                        ->orWhere("patients.address", 'LIKE', '%' . $keyword . '%');
                });
            }

            $patient_list = $patient_list
                ->select('patients.*', 'titles.title as title')
                ->get();
            return view('patientListView', ['famname' => $famname, 'patient_list' => $patient_list, 'appoinment_list' => $apoinment_list]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit_view($id)
    {
        try {
            $titles =  Title::all();
            $patients =  Patients::with('title')->select('patients.*', 'titles.id as title')->leftJoin('titles', 'patients.title', '=', 'titles.id')->where('patients.id', '=', $id)->get();
            $famname =  Patients::all('family_name')->groupBy('family_name');
            return view('patientEditView', ['titles' => $titles, 'patients' => $patients, 'famname' => $famname]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit_viewtable($id)
    {
        try {
            $titles =  Title::all();
            $famname =  Patients::all()->groupBy('family_name');
            $patients =  Patients::with('title')->select('patients.*', 'titles.id as title')->join('titles', 'patients.title', '=', 'titles.id')->where('patients.id', '=', $id)->get();
            return view('patientEditViewTable', ['titles' => $titles, 'patients' => $patients, 'famname' => $famname]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)

    {
        try {
            $Patients = Patients::find($request->id);
            $Patients->update([
                'title' => $request->title,
                'family_name' => $request->family_name,
                'name' => $request->name,
                'birthday' =>  $request->birthday,
                'age' => $request->age,
                'gender' => $request->gender,
                'address' => $request->address,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'height_feets' => $request->height_feets,
                'height_inches' => $request->height_inches,
                'height_cen' => $request->height_cen,
                'weight' => $request->weight,
                'nic' => $request->nic,
                'occupation' => $request->occupation,
            ]);

            session()->flash('message', 'Successfully Updated Patient !');
            return redirect()->back()->with('success', 'Successfully Updated Patient !');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {

        try {
            $Patients = Patients::find($request->id);
            $Patients->status = '1';
            $Patients->save();
            session()->flash('message', 'Successfully Deleted Patient !');
            return redirect()->back()->with('success', ' Successfully Deleted Patient !');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function medicalhistory($id)
    {
        try {
            $patients =  Patients::all()->where('id', '=', $id);
            $medicaltest = MedicalTest::all()->where('patient_id', '=', $id);
            return view('medicalHistory', ['medical_history' => $medicaltest, 'patients' => $patients]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function investigationhistory($id)
    {
        try {
            $investigation_history = investigationHistory::all()
                ->where('patient_id', '=', $id);
            $patients =  Patients::all()
                ->where('patients.id', "=", $id);
            $investigation_details = InvestigationDetails::all()->where('patient_id', '=', $id);
            return view('investigationHistory', ['investigation_history' => $investigation_history, 'patients' => $patients, 'investigation_details' => $investigation_details]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function investigation_history($id)
    {
        try {
            $patients =  Patients::all()->where('patient_id', '=', $id);
            $investigation_details = InvestigationDetails::all()->where('patient_id', '=', $id);
            return view('investigation_history', ['investigation_details' => $investigation_details, 'patients' => $patients]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function medical_certificate($id, $address1, $address2, $address3, $treatmentrep, $amountrep, $date1, $date2)
    {
        try {
            $date1 = Carbon::parse($date1);
            $date2 = Carbon::parse($date2);
            $numberOfDays = $date1->diffInDays($date2);
            $formatteddate1 = $date1->format('Y-m-d');
            $formatteddate2 = $date2->format('Y-m-d');
            $patients =  Patients::all()->where('id', '=', $id);
            $pdf = Pdf::loadView('medical2', ['patients' => $patients, 'address1' => $address1, 'address2' => $address2, 'address3' => $address3, 'treatmentrep' => $treatmentrep, 'amountrep' => $amountrep, 'date1' => $formatteddate1, 'date2' => $formatteddate2, 'numberOfDays' => $numberOfDays]);
            return $pdf->stream();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function medical_certificate2($id, $address1, $address2, $address3, $treatmentrep, $amountrep, $date1, $date2)
    {
        try {
            $date1 = Carbon::parse($date1);
            $date2 = Carbon::parse($date2);
            $numberOfDays = $date1->diffInDays($date2);
            $formatteddate1 = $date1->format('Y-m-d');
            $formatteddate2 = $date2->format('Y-m-d');
            $patients =  Patients::all()->where('id', '=', $id);
            $pdf = Pdf::loadView('medical', ['patients' => $patients, 'address1' => $address1, 'address2' => $address2, 'address3' => $address3, 'treatmentrep' => $treatmentrep, 'amountrep' => $amountrep, 'date1' => $formatteddate1, 'date2' => $formatteddate2, 'numberOfDays' => $numberOfDays]);
            $pdf->setPaper('a5');
            return $pdf->stream();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function medical_test_report(Request $request)
    {
        try {
            $tableMedical = json_decode($request->input('tableMedical'), true);
            $id = $request->input('uid');
            $patients =  Patients::with('titles')->select('patients.*', 'titles.id as title')
                ->leftjoin('titles', 'patients.title', '=', 'titles.id')
                ->where('patients.id', '=', $id)
                ->get();
            $pdf = Pdf::loadView('medical_test_report', ['tableMedical' => $tableMedical, 'patients' => $patients]);
            return $pdf->stream();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function opd_report(Request $request)
    {
        try {
            $id = $request->input('uid');
            $currentDate = Carbon::today();
            $appId = Appoinment::all()
                ->where('patient_id', $id)
                ->where('date', $currentDate);
            $tableData = json_decode($request->input('tableData'), true);
            $amount = json_decode($request->input('amount'), true);
            $patients =  Patients::with('titles')
                ->select('patients.*', 'titles.id as title')
                ->leftjoin('titles', 'patients.title', '=', 'titles.id')
                ->where('patients.id', '=', $id)
                ->get();
            $pdf = Pdf::loadView('opd_report', ['opdReport1' => $tableData, 'patients' => $patients, 'amount' => $amount, 'appoi' => $appId]);
            return $pdf->stream();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function out_report(Request $request)
    {

        $tableoutData = json_decode($request->input('tableOutData'), true);

        $id = $request->input('uid');
        $patients =  Patients::with('titles')
            ->select('patients.*', 'titles.id as title')
            ->leftjoin('titles', 'patients.title', '=', 'titles.id')
            ->where('patients.id', '=', $id)
            ->get();
        $pdf = Pdf::loadView('out_report', ['outReport' => $tableoutData, 'patients' => $patients]);
        return $pdf->stream();
    }

    public function barcode($id)
    {
        $patients =  Patients::all()->where('id', '=', $id);
        return view('barcode', ['patients' => $patients]);
    }
}
