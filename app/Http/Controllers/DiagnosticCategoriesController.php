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
        try {

            return view('diagnosticCategoriesAddView');
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),

            ], 400);
        }
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

            return redirect()->back()->with('error', 'Diagnostic Categorie Inserting Error ..!');
        }
    }
    public function  diagnosticCategories_list()
    {
        try {

            $diagnosticcategories_list =  DB::table('diagnostic_categories')
                ->select('diagnostic_categories.*')
                ->where('diagnostic_categories.status', '=', "0")
                ->orderBy('diagnostic_categories.category_name', 'asc')
                ->get();

            $diagnosticcategories_deleted_list =  DB::table('diagnostic_categories')
                ->select('diagnostic_categories.*')
                ->where('diagnostic_categories.status', '=', "1")
                ->orderBy('diagnostic_categories.category_name', 'asc')

                ->get();


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

            session()->flash('message', 'Successfully Deleted diagnostic Category !');
            $diagnosticCategory->save();
            return redirect()->back()->with('success', 'Successfully Deleted diagnostic Category !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'diagnosticCategory Deleted Error ..!');
        }
    }

    public function active(Request $request)
    {
        try {
            $diagnosticCategory = diagnosticCategory::find($request->id);
            $diagnosticCategory->status = '0';


            session()->flash('message', 'Successfully Actived diagnostic Category !');
            $diagnosticCategory->save();
            return redirect()->back()->with('success', 'Successfully Actived diagnostic Category !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'diagnosticCategory Active Error ..!');
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
            $diagnostic_categories =  DB::table('diagnostic_categories')
                ->select('diagnostic_categories.*')
                ->where('diagnostic_categories.id', '=', $id)
                ->get();
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
            $diagnostic_categories->update([
                'category_name' => $request->category_name,

            ]);
            session()->flash('message', 'Successfully Updated diagnostic Category !');
            return redirect()->back()->with('success', ' Successfully Updated diagnostic Category !');
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'Diagnostic Category Updated Error ..!');
        }
    }
}
