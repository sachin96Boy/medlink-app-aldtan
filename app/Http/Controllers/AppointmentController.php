<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Patients;
use App\Models\Appoinment;
use App\Models\Patient;
use App\Models\InvestigationDetails;
use App\Models\reccomandedOpdDrugs;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;

class AppointmentController extends Controller
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

            $patients =  Patients::all()->where('status', '=', '0');

            return view('appointmentAddView', ['patients' => $patients]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function handleAjaxRequest(Request $request)
    {

        $comment = $request->input('comment');
        $investigation = $request->input('investigation');
        $treatment = $request->input('treatment');
        $tableData = json_decode($request->input('tableData'), true);
        $tableoutData = json_decode($request->input('tableOutData'), true);
        $tableMedical = json_decode($request->input('tableMedical'), true);
        $tableInvesti = json_decode($request->input('tableInvesti'), true);

        $id = $request->input('uid');
        $patients =  Patients::with('titles')
            ->select('patients.*', 'titles.id as title')
            ->leftJoin('titles', 'patients.title', '=', 'titles.id')
            ->where('patients.id', '=', $id)
            ->get();

        $pdf = Pdf::loadView('test2', [
            'treatment' => $treatment, 'comment' => $comment, 'investigation' => $investigation,
            'patients' => $patients, 'tableData' => $tableData, 'tableoutData' => $tableoutData, 'tableMedical' => $tableMedical, 'tableInvesti' => $tableInvesti
        ]);
        return $pdf->stream();
    }
    public function history($id)
    {
        try {

            return view('his', ['id' => $id]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function  appointment_list()
    {
        try {

            $currentDate = Carbon::today();

            $appointment_list = Appoinment::with('patients')->select('appoinments.*', 'patients.name as patientname')->leftJoin('patients', 'appoinments.patient_id', '=', 'patients.id')->where('appoinments.date', '=', $currentDate)
                ->where('patients.status', '=', '0')
                ->where('appoinments.active', '=', '0')->get();
            return view('appointmentListView', ['appointment_list' => $appointment_list]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function add($id)
    {
        try {
            $currentDate = Carbon::today();
            $currentTime = Carbon::now();

            $app_no = Appoinment::all()->where('date', '=', $currentDate)->last();
            $patient = Patients::find($id);

            if ($app_no !== null) {
                $appointment_no = $app_no->appointment_no + 1;
            } else {
                $appointment_no = 1;
            }

            $data = [
                'appointment_no' => $appointment_no,
                'patient_id' => $id,
                'patient_name' => $patient->name, // Extracting name from the patient object
                'date' => $currentDate,
                'appdate_time' => $currentTime,
                'status' => '0',
            ];

            Appoinment::create($data);
            session()->flash('message', 'Appointment Successfully Saved ..!');

            // return back with family data

            $famname = Patients::all('family_name')->groupBy('family_name');

            $appoinment_list = Appoinment::all()->where('date', '=', $currentDate);

            $patient_list = Patients::with('title')->join('titles', 'titles.id', '=', 'patients.title')->select('patients.*', 'titles.title as title')->where('patients.status', '=', '0')->get();

            return view('patientListView', ['famname' => $famname, 'patient_list' => $patient_list, 'appoinment_list' => $appoinment_list]) > with('success', 'Appointment Successfully Saved ..!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function  waitingList()
    {

        try {

            $currentDate = Carbon::today();

            $waiting_list =  Appoinment::with('patients')->select('appoinments.*', 'patients.name as patientname')->leftjoin('patients', 'appoinments.patient_id', '=', 'patients.id')
                ->where('appoinments.status', '=', "0")
                ->where('appoinments.date', '=', $currentDate)
                ->where('patients.status', '=', '0')
                ->where('appoinments.active', '=', '0')->get();


            return view('appointmentWaitingList', ['waiting_list' => $waiting_list]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancel($id)
    {
        try {
            $currentDate = Carbon::today();
            $appoinment = Appoinment::all()->where('date', '=', $currentDate)->where('appointmnt_no', '=', $id)->first();

            $appoinment->active = '1';
            $appoinment->save();


            // Redirect back to the previous page
            return redirect()->back()->with('success', 'appoinment canceled successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function  finishedList()
    {

        try {

            $currentDate = Carbon::today();

            $finished_list =  Appoinment::with('patients')
                ->select('appoinments.*', 'patients.name as patientname')
                ->leftJoin('patients', 'appoinments.patient_id', '=', 'patients.id')
                ->where('appoinments.status', '=', "1")
                ->where('appoinments.date', '=', $currentDate)
                ->where('patients.status', '=', '0')
                ->where('appoinments.active', '=', '0')
                ->get();


            return view('appointmentFinishedList', ['finished_list' => $finished_list]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function finished(Request $request)

    {


        try {
            $currentDate = Carbon::today();

            $nextVisitDate = date('Y-m-d', strtotime($request->next_visit_date));


            $date =  Appoinment::all()
                ->where('patient_id', '=', $request->patient_id)
                ->where('date', '=', $currentDate)->first();
            $channel_date = $date->date;

            // check if entry is already there
            $existingEntry = InvestigationDetails::all()->where('patient_id', '=', $request->patient_id)->where('channel_date', '=', $channel_date)->first();

            if (!$existingEntry) {

                $data = [
                    // need to know where to get investigation_id?
                    'patient_id' => $request->patient_id,
                    'treatment' => $request->treatment,
                    'next_visit_date' => $nextVisitDate,
                    'amount' => $request->amount,
                    'comment' => $request->comment,
                    'investigation_details' => $request->investigation_details,
                    'channel_date' => $channel_date,
                ];

                InvestigationDetails::create($data);
            }


            $opdDrugs = $request->input('opdid');
            $doses = $request->input('opddose');
            $periods = $request->input('opdperiod');
            $terms = $request->input('termsOPD');

            // Loop through the data and save to the database using the Query Builder
            if (!is_null($opdDrugs) && (is_array($opdDrugs) || is_object($opdDrugs))) {
                foreach ($opdDrugs as $key => $opdDrug) {
                    // Check if the drug entry already exists for the same patient and date
                    $existingEntry = DB::table('reccomanded_opd_drugs')
                        ->where('patient_id', $request->patient_id)
                        ->where('appointment_date', $currentDate)
                        ->where('drug', $opdDrug)
                        ->first();

                    if (!$existingEntry) {

                        DB::table('reccomanded_opd_drugs')->insert([
                            'appointment_date' => $currentDate,
                            'patient_id' => $request->patient_id,
                            'drug' => $opdDrug,
                            'dose' => $doses[$key],
                            'period' => $periods[$key],
                            'terms' => $terms[$key]
                            // Add other fields as needed
                        ]);
                    }
                }
            }


            $outsideDrugs = $request->input('outsideid');
            $outsidedose = $request->input('outsidedose');
            $outsideperiod = $request->input('outsideperiod');
            $outterms = $request->input('outterms');

            // Loop through the data and save to the database using the Query Builder

            if (!is_null($outsideDrugs) && (is_array($outsideDrugs) || is_object($outsideDrugs))) {
                foreach ($outsideDrugs as $key => $outDrug) {
                    // Check if the drug entry already exists for the same patient and date
                    $existingEntry = DB::table('reccomanded_outside_drugs')
                        ->where('patient_id', $request->patient_id)
                        ->where('appointment_date', $currentDate)
                        ->where('drug', $outDrug)
                        ->first();
                    if (!$existingEntry) {

                        DB::table('reccomanded_outside_drugs')->insert([
                            'appointment_date' => $currentDate,
                            'patient_id' => $request->patient_id,
                            'drug' => $outDrug,
                            'dose' => $outsidedose[$key],
                            'period' => $outsideperiod[$key],
                            'terms' => $outterms[$key],
                            // Add other fields as needed
                        ]);
                    }
                }
            }


            // Get the data from the request
            $investi = $request->input('invid');

            // Loop through the data and save to the database using the Query Builder
            if (!is_null($investi) && (is_array($investi) || is_object($investi))) {
                // Loop through the data and save to the database using the Query Builder
                foreach ($investi as $key => $inves) {
                    // Check if the investigation entry already exists for the same patient and date
                    $existingEntry = DB::table('investigation_history')
                        ->where('patient_id', $request->patient_id)
                        ->where('appointment_date', $currentDate)
                        ->where('investtigation', $inves)
                        ->first();
                    if (!$existingEntry) {

                        DB::table('investigation_history')->insert([
                            'investtigation' => $inves,
                            'patient_id' => $request->patient_id,
                            'appointment_date' => $currentDate,
                        ]);
                    }
                }
            }

            $meditest = $request->input('medid');

            if (!is_null($meditest) && (is_array($meditest) || is_object($meditest))) {
                // Loop through the data and save to the database using the Query Builder
                foreach ($meditest as $key => $medtest) {
                    // Check if the medical test entry already exists for the same patient and date
                    $existingEntry = DB::table('medical_test')
                        ->where('patient_id', $request->patient_id)
                        ->where('appointment_date', $currentDate)
                        ->where('medical_test', $medtest)
                        ->first();
                    if (!$existingEntry) {

                        DB::table('medical_test')->insert([
                            'medical_test' => $medtest,
                            'patient_id' => $request->patient_id,
                            'appointment_date' => $currentDate,
                            // Add other fields as needed
                        ]);
                    }
                }
            }




            $appoinmentRecord = Appoinment::all()
                ->where('patient_id', $request->patient_id)
                ->where('date', $currentDate)->first();

            $appoinmentRecord->status = '1';
            $appoinmentRecord->save();


            $appoinments =  Appoinment::with('patients')
                ->select('appoinments.*', 'patients.name as patientname', 'patients.id as patientid')
                ->leftJoin('patients', 'appoinments.patient_id', '=', 'patients.id')
                ->where('appoinments.status', '=', '0')
                ->where('appoinments.date', '=', $currentDate)
                ->get();

            $id = $request->input('patient_id');

            $drug_history = reccomandedOpdDrugs::all(['drug', 'dose', 'period', 'terms'])->where('appoinment_date', '=', $currentDate)->where('patient_id', '=', $id);

            $patients = Patients::all()->where('id', '=', $id);

            $amount = $request->amount;

            $appId = Appoinment::all()->where('patient_id', '=', $request->patient_id)->where('date', '=', $currentDate);

            session()->flash('message', 'Appointment Finished Successfully Updated ..!');

            return view('opd_report',  ['opdReport' => $drug_history, 'patients' => $patients, 'amount' => $amount, 'appoi' => $appId])->with('success', 'Appointment Finished Successfully Updated ..!');
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
