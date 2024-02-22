<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Patients;
use App\Models\Appoinment;
use App\Models\Patient;
use App\Models\InvestigationDetails;
use App\Models\investigationHistory;
use App\Models\MedicalTest;
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
        $patients =  Patients::with('title')
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

            // TODO: logic added to return to 'patientListView' after creating the appoinment
            //  I'm not sure it should be a part of the
            // controller process but let's update it in future 

            session()->flash('message', 'Appointment Successfully Saved ..!');
            return redirect()->back()->with('success', 'Appointment Successfully Saved ..!');
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
            return back();
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
        // fire this function when clicked on 
        // finish button on view_patients_details view
        try {
            $currentDate = Carbon::today();
            $nextVisitDate = date('Y-m-d', strtotime($request->next_visit_date));
            $date =  Appoinment::all()
                ->where('appoinments.patient_id', '=', $request->patient_id)
                ->where('appoinments.date', '=', $currentDate)->first();
            $channel_date = $date->date;

            // Check if an entry already exists for the patient and channel_date
            $existingEntry = InvestigationDetails::where('patient_id', $request->patient_id)
                ->where('channel_date', $channel_date)
                // Add other relevant criteria here
                ->first();
            if (!$existingEntry) {
                // If the entry does not exist, create and save a new instance
                $data = [
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
            // get term from input
            $terms = $request->input('termsOPD');

            // Loop through the data and save to the database using the Query Builder
            if (!is_null($opdDrugs) && (is_array($opdDrugs) || is_object($opdDrugs))) {
                foreach ($opdDrugs as $key => $opdDrug) {
                    // ? we can use model to insert the data
                    // but the name of the model is defined as a 
                    // word in camelCase? go check if this is correct

                    // chck if the entry exists
                    $existingEntry = reccomandedOpdDrugs::where('patient_id', $request->patient_id)->where('appointment_date', $currentDate)->where('drug', $opdDrug)->first();

                    if (!$existingEntry) {

                        DB::table('reccomanded_opd_drugs')->insert([
                            'appointment_date' => $currentDate,
                            'patient_id' => $request->patient_id,
                            'drug' => $opdDrug,
                            'dose' => $doses[$key],
                            'period' => $periods[$key],
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
                    // ? we can use model to insert the data
                    // but the name of the model is defined as a 
                    // word in camelCase? (might need to make sure model bname start with an capital letter)
                    //  go check if this is correct

                    // check if the entry already existsfor same patient and date
                    $existingEntry = reccomandedOpdDrugs::where('patient_id', $request->patient_id)->where('appointment_date', $currentDate)->where('drug', $opdDrug)->first();

                    if (!$existingEntry) {

                        DB::table('reccomanded_outside_drugs')->insert([
                            'appointment_date' => $currentDate,
                            'patient_id' => $request->patient_id,
                            'drug' => $outDrug,
                            'dose' => $outsidedose[$key],
                            'period' => $outsideperiod[$key],
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
                    // check if the investigaton entry already exists for same patient and date
                    $existingEntry = investigationHistory::where('patient_id', $request->patient_id)->where('appointment_date', $currentDate)->where('investtigation', $inves)->first();

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

                    // check if medical test entry already exists for same patient an date
                    $existingEntry = MedicalTest::where('patient_id', $request->patient_id)->where('appointment_date', $currentDate)->where('medical_test', $medtest)->first();

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
                ->leftjoin('patients', 'appoinments.patient_id', '=', 'patients.id')
                ->where('appoinments.status', '=', '0')
                ->where('appoinments.date', '=', $currentDate)
                ->get();

            $id = $request->input('patient_id');

            // reccomanded opd drug need to be migrated again
            // new fields terms have been added
            $drug_history = reccomandedOpdDrugs::all()->where('appointment_date', $currentDate)->where('patient_id', $id);
            $patients =  Patients::all()
                ->where('patients.id', $id);
            $amount = $request->amount;
            $appId = Appoinment::where('patient_id', $request->patient_id)
                ->where('date', $currentDate)
                ->get();

            session()->flash('message', 'Appointment Finished Successfully Updated ..!');

            return view('opd_report', ['opdReport' => $drug_history, 'patients' => $patients, 'amount' => $amount, 'appoi' => $appId])
                ->with('success', 'Appointment Finished Successfully Updated ..!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
