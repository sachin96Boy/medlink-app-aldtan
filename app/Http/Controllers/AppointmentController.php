<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Patients;
use App\Models\Appoinment;
use App\Models\Patient;
use App\Models\InvestigationDetails;
use PDF;
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
        $patients =  DB::table('patients')
            ->select('patients.*', DB::raw('titles.id as title'))
            ->leftjoin('titles', 'patients.title', '=', 'titles.id')
            ->where('patients.id', '=', $id)
            ->get();
        $pdf = Pdf::loadView('test2', ['treatment' => $treatment, 'comment' => $comment, 'investigation' => $investigation,
        'patients' => $patients, 'tableData' => $tableData, 'tableoutData' => $tableoutData, 'tableMedical' => $tableMedical, 'tableInvesti' => $tableInvesti]);
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
                //add the get function
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

        $app_no = Appoinment::all()->where('date','=',$currentDate)->last();
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
        return redirect()->back()->with('success', 'Appointment Successfully Saved ..!');
    } catch (Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}

    public function  waitingList()
    {

        try {

            $currentDate = Carbon::today();

            $waiting_list =  Appoinment::with('patients')->select('appoinments.*','patients.name as patientname')->leftjoin('patients', 'appoinments.patient_id', '=', 'patients.id')
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
            DB::table('appoinments')
                ->where('date', $currentDate)
                ->where('appointment_no', $id)
                ->update(['active' => '1']);

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

            $finished_list =  DB::table('appoinments')
                ->select('appoinments.*', DB::raw('patients.name as patientname'))
                ->leftjoin('patients', 'appoinments.patient_id', '=', 'patients.id')
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

            $date =  DB::table('appoinments')
                ->select('appoinments.*')
                ->where('appoinments.patient_id', '=', $request->patient_id)
                ->where('appoinments.date', '=', $currentDate)->first();
            $channel_date = $date->date;
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


            $opdDrugs = $request->input('opdid');
            $doses = $request->input('opddose');
            $periods = $request->input('opdperiod');
            //dd($opdDrugs, $doses, $periods);
            // Loop through the data and save to the database using the Query Builder
            if (!is_null($opdDrugs) && (is_array($opdDrugs) || is_object($opdDrugs))) {
                foreach ($opdDrugs as $key => $opdDrug) {
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


            $outsideDrugs = $request->input('outsideid');
            $outsidedose = $request->input('outsidedose');
            $outsideperiod = $request->input('outsideperiod');
            //dd($outsideDrugs, $doses, $periods);
            // Loop through the data and save to the database using the Query Builder

            if (!is_null($outsideDrugs) && (is_array($outsideDrugs) || is_object($outsideDrugs))) {
                foreach ($outsideDrugs as $key => $outDrug) {
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


            // Get the data from the request
            $investi = $request->input('invid');

            // Loop through the data and save to the database using the Query Builder
            if (!is_null($investi) && (is_array($investi) || is_object($investi))) {
                // Loop through the data and save to the database using the Query Builder
                foreach ($investi as $key => $inves) {
                    DB::table('investigation_history')->insert([
                        'investtigation' => $inves,
                        'patient_id' => $request->patient_id,
                        'appointment_date' => $currentDate,

                    ]);
                }
            }

            $meditest = $request->input('medid');

            if (!is_null($meditest) && (is_array($meditest) || is_object($meditest))) {
                // Loop through the data and save to the database using the Query Builder
                foreach ($meditest as $key => $medtest) {
                    DB::table('medical_test')->insert([
                        'medical_test' => $medtest,
                        'patient_id' => $request->patient_id,
                        'appointment_date' => $currentDate,
                        // Add other fields as needed
                    ]);
                }
            }


            $Appoinment = [
                'status' => 1
            ];

            DB::table('appoinments')
                ->where('patient_id', $request->patient_id)
                ->where('date', $currentDate)
                ->update($Appoinment);



            $appoinments =  DB::table('appoinments')
                ->select('appoinments.*', DB::raw('patients.name as patientname'), DB::raw('patients.id as patientid'))
                ->leftjoin('patients', 'appoinments.patient_id', '=', 'patients.id')
                ->where('appoinments.status', '=', '0')
                ->where('appoinments.date', '=', $currentDate)
                ->get();

            session()->flash('message', 'Appointment Finished Successfully Updated ..!');

            return view('newDoctorScreen', ['appoinments' => $appoinments])
                ->with('success', 'Appointment Finished Successfully Updated ..!');
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
