<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Str;
use File;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with('categoryDetail')->get();
        return response()->json($companies);
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

        $data = $request->only('category_id','title','description');

        if($file = $request->file('image')){
            $image_name = Str::random(5).time(). '.' . $file->getClientOriginalExtension();
            $file->move(public_path('company_image'), $image_name);
            $data['image'] = 'company_image/'.$image_name;
        }

        $company = Company::create($data);

        return response()->json($company);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::with('categoryDetail')->findOrFail($id);
        return response()->json($company);
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

        $company = Company::findOrFail($id);

        $fromdata = [
            'category_id'   => $request->category_id,
            'title'         => $request->title,
            'description'   => $request->description,
        ];

        if($request->file('image')){
            if(File::exists(public_path($company->image))){
                $image_path = public_path($company->image);
                unlink($image_path);
            }
            $image_name = Str::random(5).time(). '.' . $file->getClientOriginalExtension();
            $file->move(public_path('company_image'), $image_name);
            $fromdata['image'] = "company_image/".$image_name;
        }

        $company->update($fromdata);

        return response()->json($company->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        if(File::exists(public_path($company->image))) {
            $image_path = public_path($company->image);
            unlink($image_path);
        }
        $company->delete();

        return response()->json($company::all());
    }

}
