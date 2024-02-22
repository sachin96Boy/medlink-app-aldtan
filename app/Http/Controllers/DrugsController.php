<?php

namespace App\Http\Controllers;

use App\Models\reccomandOutsideDrugs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Drugs;
use App\Models\Patients;
use App\Models\reccomandedOpdDrugs;
use Exception;
use Illuminate\Support\Facades\Validator;

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
        return view('drugsAdd');
    }

    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'drug_name' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'something error');
            }
            $drugName = $request->input('drug_name');
            // check if there's an existing drug name record available
            $drugId = Drugs::where('drug_name', $drugName)->count();
            if ($drugId > 0) {
                return redirect()->back()->with('error', 'This Drug Name already available');
            }
            $data = [
                'drug_name' => strtoupper($drugName),
            ];
            Drugs::create($data);

            session()->flash('message', 'Successfully Added Drug !');
            return redirect()->back()->with('success', 'Successfully Added Drug !');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function  drugs_list()
    {
        try {
            $drugs_list =  Drugs::all()->where('status', '=', '0')->sortBy('drug_name');
            $drugs_list_deleted =  Drugs::all()->where('status', '=', '1')->sortBy('drug_name');
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

            // code on server returns 'drug_list' view for both the scnes 
            // chheck if this already works
            // or we need to modify this
            // update: no  need! this already works

            $drug = drugs::find($request->id);
            $drug->status = '1';
            $drug->save();
            session()->flash('message', 'Successfully Deleted Drug !');
            return redirect()->back()->with('success', 'Successfully Deleted Drug !');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function drug_search(Request $request)
    {
        // update drug search to use models insted of db query builder alone
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
            $drugs =  Drugs::all()->where('id', '=', $id);
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
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function drughistory($id)
    {
        try {
            $drug_history = reccomandedOpdDrugs::all('drug', 'dose', 'period', 'appoinment_date')->where('patient_id', '=', $id);
            $drug_out = reccomandOutsideDrugs::all('drug', 'dose', 'period', 'appoinment_date')->where('patient_id', '=', $id);
            $patients =  Patients::all()->where('id', '=', $id);
            return view('drug_history', ['drug_history' => $drug_history, 'drug_out' => $drug_out, 'patients' => $patients]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
