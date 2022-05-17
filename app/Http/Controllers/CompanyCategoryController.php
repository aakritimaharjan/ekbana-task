<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyCategory;

class CompanyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->keyword) {
            $categories = CompanyCategory::where('title', 'LIKE', '%'. request()->keyword. '%')->get();
        } else{
            $categories = CompanyCategory::all();
        }
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'title' => 'required',
        ]);
        $companyCategory = CompanyCategory::create($request->only(['title']));
        return response()->json($companyCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $companyCategory = CompanyCategory::findOrFail($id);
        return response()->json($companyCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
          'title' => 'required',
        ]);

        $companyCategory = CompanyCategory::findOrFail($id);

        $companyCategory->update($request->only('title'));

        return response()->json($companyCategory->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $companyCategory = CompanyCategory::findOrFail($id);
        $companyCategory->delete();
        return response()->json($companyCategory::all());
    }
}
