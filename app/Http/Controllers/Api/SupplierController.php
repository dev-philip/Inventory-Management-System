<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Image;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::all();
        return response()->json($supplier);
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
            'name' => 'required|unique:suppliers|max:255',
            'email' => 'required|unique:suppliers',
            'phone' => 'required|unique:suppliers',
            'shopname' => 'required|unique:suppliers',
            'photo' => 'required',
        ]);

            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().".".$ext;
            //using image intervention
            $img = Image::make($request->photo)->resize(240,200);
            $upload_path = 'backend/supplier/';
            $image_url = $upload_path.$name;
            
            $img->save($image_url);
            $supplier = new Supplier;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->shopname = $request->shopname;
            $supplier->photo = '/'.env('APP_BASE_URL').$image_url;
            $supplier->save();

        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = DB::table('suppliers')->where('id',$id)->first();
        return response()->json($supplier);
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

        $img = DB::table('suppliers')->where('id',$id)->first();
        $oldphoto = $img->photo;

        //get all posted data send from the form and save it in an array
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['shopname'] = $request->shopname;
        $data['address'] = $request->address;

        if($oldphoto == $request->photo ){ //no need to update and delete picture
            $data['photo'] = $oldphoto;
            $user = DB::table('suppliers')->where('id',$id)->update($data);

        }else{ //There is a new picture that we have to update and delete the old one
            
                $newImage = $request->photo;
                $position = strpos($newImage, ';');
                $sub = substr($newImage, 0, $position);
                $ext = explode('/', $sub)[1];
    
                $name = time().".".$ext;
                //using image intervention
                $img = Image::make($newImage)->resize(240,200);
                $upload_path = 'backend/supplier/'; //file directory where the file would be saved
                $image_url = $upload_path.$name;
                
                $success = $img->save($image_url); //save file in directory
    
                if($success){
                    $data['photo'] = '/'.env('APP_BASE_URL').$image_url;
                    $oldPhotoUnlinkUrl = ltrim($oldphoto, '/');
                    $done = unlink($oldPhotoUnlinkUrl); //remove old photo from directory
                    $user = DB::table('suppliers')->where('id',$id)->update($data); //update all data in database
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
        $supplier = DB::table('suppliers')->where('id',$id)->first();
        $photo = ltrim($supplier->photo, '/');
        if($photo){
            unlink($photo);
            DB::table('suppliers')->where('id', $id)->delete();
        }else{
            DB::table('suppliers')->where('id', $id)->delete();
        }
    }
}
