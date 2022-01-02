<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Image;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();
        return response()->json($employee);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:employees|max:255',
            'email' => 'required|unique:employees',
            'phone' => 'required|unique:employees',
            'photo' => 'required',
        ]);

            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().".".$ext;
            //using image intervention
            $img = Image::make($request->photo)->resize(240,200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path.$name;
            
            $img->save($image_url);
            $employee = new Employee;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->salary = $request->salary;
            $employee->address = $request->address;
            $employee->nid = $request->nid;
            $employee->joining_date = $request->joining_date;
            $employee->photo = '/'.env('APP_BASE_URL').$image_url;
            $employee->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = DB::table('employees')->where('id',$id)->first();
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        $img = DB::table('employees')->where('id',$id)->first();
        $oldphoto = $img->photo;

        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['salary'] = $request->salary;
        $data['address'] = $request->address;
        $data['nid'] = $request->nid;
        $data['joining_date'] = $request->joining_date;
        
        if($oldphoto == $request->photo ){ //no need to update and delete picture
            $data['photo'] = $oldphoto;
            $user = DB::table('employees')->where('id',$id)->update($data);
            
        }else{
            $newImage = $request->photo;
            $position = strpos($newImage, ';');
            $sub = substr($newImage, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().".".$ext;
            //using image intervention
            $img = Image::make($newImage)->resize(240,200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path.$name;
            
            $success = $img->save($image_url);

            if($success){
                $data['photo'] = '/'.env('APP_BASE_URL').$image_url;
                $oldPhotoUnlinkUrl = ltrim($oldphoto, '/');
                $done = unlink($oldPhotoUnlinkUrl); //remove old photo from directory
                $user = DB::table('employees')->where('id',$id)->update($data); //update all data in database
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = DB::table('employees')->where('id',$id)->first();
        $photo = ltrim($employee->photo, '/');
        
        if($photo){
            unlink($photo);
            DB::table('employees')->where('id', $id)->delete();
        }else{
            DB::table('employees')->where('id', $id)->delete();
        }
        
    }
}
