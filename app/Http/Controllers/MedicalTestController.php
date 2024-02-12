<?php

namespace App\Http\Controllers;

use App\Models\medicalTests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MedicalTest;
use Exception;

class MedicalTestController extends Controller
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
        return view('medicalTestAdd');
    }


    public function add(Request $request)
    {

        try {
            $data = [
                'test_name' => $request->test_name
            ];
            MedicalTest::create($data);

            session()->flash('message', 'Successfully Added Medical Test !');
            return redirect()->back()->with('success', 'Successfully Added Medical Test !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function  medical_test_list()
    {
        try {
            $medical_test_list =  MedicalTest::all()->where('status', '=', '0');

            $medical_test_list_deleted =  MedicalTest::all()->where('status', '=', '1');

            return view('medicalTestList', ['medical_test_list' => $medical_test_list, 'medical_test_list_deleted' => $medical_test_list_deleted]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {

        try {
            $medical_test = medicaltest::find($request->id);
            $medical_test->status = '1';

            $medical_test->save();
            session()->flash('message', 'Successfully Deleted Medical Test  !');
            return redirect()->back()->with('success', 'Successfully Deleted Medical Test !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function active(Request $request)
    {

        try {
            $medical_test = medicaltest::find($request->id);
            $medical_test->status = '0';

            $medical_test->save();
            session()->flash('message', 'Successfully Actived Medical Test  !');
            return redirect()->back()->with('success', 'Successfully Actived Medical Test !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function medical_test_search(Request $request)
    {
        try {

            if (isset($request->test_name)) {
                $test_name = $request->test_name;
                $medical_test_list = MedicalTest::all()->where("test_name", 'LIKE', '%' . $test_name . '%');
            }
            $medical_test_list = $medical_test_list->where("status", "=", "0")
                ->sortBy('test_name')
                ->where('status', '=', "0");
                


            $medical_test_list_deleted =  MedicalTest::all()
                ->sortBy('test_name', 'asc')
                ->where('status', '=', "1");

            return view('medicalTestList', ['medical_test_list' => $medical_test_list, 'medical_test_list_deleted' => $medical_test_list_deleted]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {

            $medical_tests = medicalTests::all()->where('id', '=', $id);


            return view('medicalTestEdit', ['medical_tests' => $medical_tests]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)

    {

        try {
            $medical_tests = medicaltest::find($request->id);
            $medical_tests->update([
                'test_name' => $request->test_name,
            ]);

            session()->flash('message', 'Successfully Actived Medical Test  !');
            return redirect()->back()->with('success', 'Successfully Updated Medical Test !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
