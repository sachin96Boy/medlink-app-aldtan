<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DiagnosticCategory;
use Exception;

class DiagnosticCategoriesController extends Controller
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


        return view('diagnosticCategoriesAddView');
    }

    public function add(Request $request)
    {

        try {
            $data = [
                'category_name' => $request->category_name
            ];
            DiagnosticCategory::create($data);

            session()->flash('message', 'Successfully Added Diagnostic Categorie ..!');
            return redirect()->back()->with('success', 'Successfully Added Diagnostic Categorie!');
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function  diagnosticCategories_list()
    {
        try {

            $diagnosticcategories_list =  DiagnosticCategory::all()->where('status', '=', '0')->sortBy('category_name');

            $diagnosticcategories_deleted_list =  DiagnosticCategory::all()->where('status', '=', '1')->sortBy('category_name');


            return view('diagnosticCategoriesListView', ['diagnosticcategories_list' => $diagnosticcategories_list, 'diagnosticcategories_deleted_list' => $diagnosticcategories_deleted_list]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function delete(Request $request)
    {

        try {
            $diagnosticCategory = diagnosticCategory::find($request->id);
            $diagnosticCategory->status = '1';

            $diagnosticCategory->save();
            session()->flash('message', 'Successfully Deleted diagnostic Category !');
            return redirect()->back()->with('success', 'Successfully Deleted diagnostic Category !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function active(Request $request)
    {
        try {
            $diagnosticCategory = diagnosticCategory::find($request->id);
            $diagnosticCategory->status = '0';


            $diagnosticCategory->save();
            session()->flash('message', 'Successfully Actived diagnostic Category !');
            return redirect()->back()->with('success', 'Successfully Actived diagnostic Category !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function diagnostic_categorie_search(Request $request)
    {

        try {

            $validate = $request->validate([
                'cat_name' => 'required',
            ]);

            $diagnosticcategories_list = DB::table('diagnostic_categories');

            if (isset($request->cat_name)) {
                $cat_name = $request->cat_name;
                $diagnosticcategories_list = $diagnosticcategories_list->where("diagnostic_categories.category_name", 'LIKE', '%' . $cat_name . '%');
            }
            $diagnosticcategories_list = $diagnosticcategories_list->where("diagnostic_categories.status", "=", "0")
                ->select('diagnostic_categories.*')
                ->orderBy('diagnostic_categories.category_name', 'asc')
                ->where('diagnostic_categories.status', '=', "0")
                ->get();

            $diagnosticcategories_deleted_list =  DB::table('diagnostic_categories')
                ->select('diagnostic_categories.*')
                ->orderBy('diagnostic_categories.category_name', 'asc')
                ->where('diagnostic_categories.status', '=', "1")
                ->get();
            return view('diagnosticCategoriesListView', ['diagnosticcategories_list' => $diagnosticcategories_list, 'diagnosticcategories_deleted_list' => $diagnosticcategories_deleted_list]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function edit($id)
    {
        try {
            $diagnostic_categories =  DiagnosticCategory::all()->where('id', '=', $id);

            return view('diagnosticCategoriesEditView', ['diagnostic_categories' => $diagnostic_categories]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request)

    {

        try {
            $diagnostic_categories = diagnosticCategory::find($request->id);
            $diagnostic_categories
                ->category_name = $request->category_name;

            $diagnostic_categories->save();


            session()->flash('message', 'Successfully Updated diagnostic Category !');
            return redirect()->back()->with('success', ' Successfully Updated diagnostic Category !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
