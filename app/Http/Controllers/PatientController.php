<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Title;
use App\Models\Patients;
use PDF;
use Carbon\Carbon;

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

        $titles =  DB::table('titles')
        ->select('titles.*')
        ->get();

        $familyNames =  DB::table('patients')
        ->select('patients.family_name')
        ->groupBy('patients.family_name')
        ->get();


            return view('patientAdd',['titles' => $titles],['familyNames' => $familyNames]);


    }

    public function add(Request $request)
    {
		$data=[
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
                Patients::create($data);
                
                    session()->flash('message', 'success', 'Successfully Added Patient !');

                try {
                    return redirect()->back()->with('success', 'Successfully Added Patient !');

                } catch (Exception $e) {

                    return redirect()->back()->with('error', 'Patient Inserting Error ..!');
                }
}

 public function patient_list_search_by_family_name(Request $request)
    {


        $patient_list = DB::table('patients')
            ->join('titles', 'titles.id', '=', 'patients.title');

        if (isset($request->family_name)) {
            $family_name = $request->family_name;
            $patient_list =$patient_list->where("patients.family_name", $family_name );
        }
        $patient_list = $patient_list->where("patients.status", "=", "0")
            ->select('patients.*','titles.title as title')
            ->get();


        return view('patisentpopup',[ 'patient_list' => $patient_list , 'currentPatientId' => $request->currentPatientId]);

    }

public function genReport(Request $request)
    {
        $selectedValues = $request->input('selectedRows');
        $id = $request->input('id');
        $patients =  DB::table('patients')
        ->select('patients.*', DB::raw('titles.id as title'))
        ->leftjoin('titles','patients.title','=','titles.id')
        ->where('patients.id' , '=', $id)
        ->get();
        

        $pageName = $request->input('pageName');

$pdf= Pdf::loadView('test',['pageName' => $pageName,'selectedValues' => $selectedValues,'patients' =>$patients]);
         return $pdf-> stream();
    }
        public function drugReport(Request $request)
    {
        $id = $request->input('id');
        $patients =  DB::table('patients')
            ->select('patients.*', DB::raw('titles.id as title'))
            ->leftjoin('titles','patients.title','=','titles.id')
            ->where('patients.id' , '=', $id)
            ->get();
        
        $selectedRows = $request->input('selectedRows');
        $pageName = $request->input('pageName');
    
        $pdf = Pdf::loadView('drugreport', ['selectedRows' => $selectedRows, 'pageName' => $pageName, 'patients' => $patients]);
        return $pdf->stream();
    }
    
    
    
public function patient_list_view()
    {
        $current = Carbon::today();

         $famname =  DB::table('patients')
        ->select('patients.family_name')
        ->groupBy('patients.family_name')
        ->get();
        
        $apoinment_list = DB::table('appoinments')
            ->select('appoinments.*')
            ->where('appoinments.date', '=', $current)
            ->where('appoinments.active', '=', '0')
            ->get();


        $patient_list = DB::table('patients')
            ->join('titles', 'titles.id', '=', 'patients.title')
            ->where("patients.status", "=", "0")
            ->select('patients.*','titles.title as title')
            ->get();

        return view('patientListView',['famname' => $famname,'patient_list' => $patient_list,'appoinment_list' => $apoinment_list]);

    }
    
    public function patient_list_search(Request $request)
    {
        
        $validate = $request->validate([
            'keyword' => 'required',
        ]);

        $famname =  DB::table('patients')
        ->select('patients.family_name')
        ->groupBy('patients.family_name')
        ->get();

        $patient_list = DB::table('patients')
            ->join('titles', 'titles.id', '=', 'patients.title');

        if (isset($request->keyword)) {
            $keyword = $request->keyword;
            $patient_list =$patient_list->orwhere("patients.nic", 'LIKE', '%' . $keyword . '%');
            $patient_list =$patient_list->orwhere("patients.family_name", 'LIKE', '%' . $keyword . '%');
            $patient_list =$patient_list->orwhere("patients.name", 'LIKE', '%' . $keyword . '%');
            $patient_list =$patient_list->orwhere("patients.mobile", 'LIKE', '%' . $keyword . '%');
            $patient_list =$patient_list->orwhere("patients.address", 'LIKE', '%' . $keyword . '%');
        }

        $patient_list = $patient_list->where("patients.status", "=", "0")
            ->select('patients.*','titles.title as title')
            ->get();

        return view('patientListView',['famname' => $famname , 'patient_list' => $patient_list]);

    }

    public function edit_view($id)
    {

        $titles =  DB::table('titles')
        ->select('titles.*')
        ->get();



        $patients =  DB::table('patients')
        ->select('patients.*', DB::raw('titles.id as title'))
        ->leftjoin('titles','patients.title','=','titles.id')
        ->where('patients.id' , '=', $id)
        ->get();

         $famname =  DB::table('patients')
        ->select('patients.family_name')
        ->groupBy('patients.family_name')
        ->get();

        return view('patientEditView',['titles' => $titles ,'patients' => $patients, 'famname' => $famname]);
    }

    public function edit_viewtable($id)
    {

        $titles =  DB::table('titles')
        ->select('titles.*')
        ->get();

        $famname =  DB::table('patients')
        ->select('patients.family_name')
        ->groupBy('patients.family_name')
        ->get();

        $patients =  DB::table('patients')
        ->select('patients.*', DB::raw('titles.id as title'))
        ->join('titles','patients.title','=','titles.id')
        ->where('patients.id' , '=', $id)
        ->get();

        return view('patientEditViewTable', ['titles' => $titles, 'patients' => $patients, 'famname' => $famname]);
    }

    public function update(Request $request)

    {
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
    
     session()->flash('message', 'success', 'Successfully Updated Patient !');

    try {
        return redirect()->back()->with('success', 'Successfully Updated Patient !');

    } catch (Exception $e) {

        return redirect()->back()->with('error', 'Patient Updated Error ..!');
    }
}

public function delete(Request $request){
    $Patients = Patients::find($request->id);
    $Patients->status='1';
    
     session()->flash('message', 'success', 'Successfully Deleted Patient !');

    try {
        $Patients->save();
        return redirect()->back()->with('success', ' Successfully Deleted Patient !');

    } catch (Exception $e) {

        return redirect()->back()->with('error', 'Patient Deleted Error ..!');
    }
}

public function medicalhistory($id)
    {

        $patients =  DB::table('patients')
        ->select('patients.*')
        ->where('patients.id' , $id)
        ->get();

        $medicaltest = DB::table('medical_test')
            ->select('medical_test.*')
            ->where('medical_test.patient_id' , '=', $id)
            ->get();

        return view('medicalHistory',['medical_history' => $medicaltest,'patients' => $patients]);

  
    }
    
      public function investigationhistory($id)
    {
        $investigation_history = DB::table('investigation_history')
            ->select('investigation_history.*',)
            ->where('patient_id', $id)
            ->get();

            $patients =  DB::table('patients')
            ->select('patients.*')
            ->where('patients.id' , $id)
            ->get();
            $investigation_details = DB::table('investigation_details')
            ->select('investigation_details.*',)
        ->where('patient_id', $id)
        ->get();
        return view('investigationHistory',['investigation_history' => $investigation_history,'patients' => $patients,'investigation_details' => $investigation_details]);

    }



public function investigation_history($id)
    {
      
        $patients =  DB::table('patients')
        ->select('patients.*')
        ->where('patients.id' , $id)
        ->get();
        $investigation_details = DB::table('investigation_details')
            ->select('investigation_details.*',)
        ->where('patient_id', $id)
        ->get();
      return view('investigation_history',['investigation_details' => $investigation_details,'patients' => $patients]);

    }


}


 



