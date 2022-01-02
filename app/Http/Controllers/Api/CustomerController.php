<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Image;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = DB::table('customers')->orderBy('id','DESC')->get();
        return response()->json($customer);
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
            'name' => 'required|max:255',
            'email' => 'required|unique:customers',
            'phone' => 'required|unique:customers',
            'address' => 'required',
            'photo' => 'required',
        ]);

            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().".".$ext;
            //using image intervention
            $img = Image::make($request->photo)->resize(240,200);
            $upload_path = 'backend/customer/';
            $image_url = $upload_path.$name;
            
            $img->save($image_url);
            $customer = new Customer;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->photo = '/'.env('APP_BASE_URL').$image_url;
            $customer->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = DB::table('customers')->where('id',$id)->first();
        return response()->json($customer);
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
        $img = DB::table('customers')->where('id',$id)->first();
        $oldphoto = $img->photo;

        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        
        if($oldphoto == $request->photo ){ //no need to update and delete picture
            $data['photo'] = $oldphoto;
            $user = DB::table('customers')->where('id',$id)->update($data);
            
        }else{
            $newImage = $request->photo;
            $position = strpos($newImage, ';');
            $sub = substr($newImage, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().".".$ext;
            //using image intervention
            $img = Image::make($newImage)->resize(240,200);
            $upload_path = 'backend/customer/';
            $image_url = $upload_path.$name;
            
            $success = $img->save($image_url);

            if($success){
                $data['photo'] = '/'.env('APP_BASE_URL').$image_url;
                $oldPhotoUnlinkUrl = ltrim($oldphoto, '/');
                $done = unlink($oldPhotoUnlinkUrl); //remove old photo from directory
                $user = DB::table('customers')->where('id',$id)->update($data); //update all data in database
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
        $customer = DB::table('customers')->where('id',$id)->first();
        $photo = ltrim($customer->photo, '/');
        
        if($photo){
            unlink($photo);
            DB::table('customers')->where('id', $id)->delete();
        }else{
            DB::table('customers')->where('id', $id)->delete();
        }
    }
}
