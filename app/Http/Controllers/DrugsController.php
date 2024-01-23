<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Drugs;
use Exception;

class DrugsController extends Controller
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

            return view('drugsAdd');
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
                'drug_name' => $request->drug_name
            ];
            Drugs::create($data);

            session()->flash('message', 'Successfully Added Drug !');
            return redirect()->back()->with('success', 'Successfully Added Drug !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'Drug Inserting Error ..!');
        }
    }
    public function  drugs_list()
    {
        try {

            $drugs_list =  DB::table('drugs')
                ->select('drugs.*')
                ->where('drugs.status', '=', "0")
                ->orderBy('drugs.drug_name', 'asc')
                ->get();

            $drugs_list_deleted =  DB::table('drugs')
                ->select('drugs.*')
                ->where('drugs.status', '=', "1")
                ->orderBy('drugs.drug_name', 'asc')
                ->get();

            return view('drugsList', ['drugs_list' => $drugs_list, 'drugs_list_deleted' => $drugs_list_deleted]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function delete(Request $request)
    {

        try {
            $drug = drugs::find($request->id);
            $drug->status = '1';

            $drug->save();
            session()->flash('message', 'Successfully Deleted Drug !');
            return redirect()->back()->with('success', 'Successfully Deleted Drug !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'drug Deleted Error ..!');
        }
    }

    public function active(Request $request)
    {

        try {
            $drug = drugs::find($request->id);
            $drug->status = '0';

            $drug->save();
            session()->flash('message', 'Successfully Actived drug..!');
            return redirect()->back()->with('success', 'Successfully Actived drug..!');
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'drug Active Error ..!');
        }
    }

    public function drug_search(Request $request)
    {

        try {

            $validate = $request->validate([
                'drug_name' => 'required',
            ]);

            $drugs_list = DB::table('drugs');

            if (isset($request->drug_name)) {
                $drug_name = $request->drug_name;
                $drugs_list = $drugs_list->where("drugs.drug_name", 'LIKE', '%' . $drug_name . '%');
            }
            $drugs_list = $drugs_list->where("drugs.status", "=", "0")
                ->select('drugs.*')
                ->orderBy('drugs.drug_name', 'asc')
                ->where('drugs.status', '=', "0")
                ->get();


            $drugs_list_deleted =  DB::table('drugs')
                ->select('drugs.*')
                ->orderBy('drugs.drug_name', 'asc')
                ->where('drugs.status', '=', "1")
                ->get();
            return view('drugsList', ['drugs_list' => $drugs_list, 'drugs_list_deleted' => $drugs_list_deleted]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {

        try {

            $drugs =  DB::table('drugs')
                ->select('drugs.*')
                ->where('drugs.id', '=', $id)
                ->get();
            return view('drugsEdit', ['drugs' => $drugs]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)

    {

        try {
            $drugs = drugs::find($request->id);
            $drugs->update([
                'drug_name' => $request->drug_name,
            ]);

            session()->flash('message', 'Successfully Updated Drug !');
            return redirect()->back()->with('success', 'Successfully Updated Drug !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'Drug Updated Error ..!');
        }
    }

    public function drughistory($id)
    {
        try {

            $drug_history = DB::table('reccomanded_opd_drugs')
                ->select('drug', 'dose', 'period', 'appointment_date')
                ->where('patient_id', $id)
                ->get();
            $drug_out = DB::table('reccomanded_outside_drugs')
                ->select('drug', 'dose', 'period', 'appointment_date')
                ->where('patient_id', $id)
                ->get();

            $patients =  DB::table('patients')
                ->select('patients.*')
                ->where('patients.id', $id)
                ->get();
            return view('drug_history', ['drug_history' => $drug_history, 'drug_out' => $drug_out, 'patients' => $patients]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
