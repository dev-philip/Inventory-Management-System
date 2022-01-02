<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Image;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = DB::table('products')
                        ->join('categories','products.category_id','categories.id')
                        ->join('suppliers','products.supplier_id','suppliers.id')
                        ->select('categories.category_name','suppliers.name','products.*')
                        ->orderBy('products.id','DESC')
                        ->get();
        return response()->json($product);
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
            'product_name' => 'required|max:255',
            'product_code' => 'required|unique:products|max:255',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'buying_date' => 'required',
            'product_quantity' => 'required',
            'image' => 'required',
        ]);

        
        $position = strpos($request->image, ';');
        $sub = substr($request->image, 0, $position);
        $ext = explode('/', $sub)[1];

        $name = time().".".$ext;
        //using image intervention
        $img = Image::make($request->image)->resize(240,200);
        $upload_path = 'backend/product/';
        $image_url = $upload_path.$name;
        
        $img->save($image_url);
        $product = new Product;
        $product->category_id = $request->category_id;
        $product->product_name = $request->product_name;
        $product->product_code = $request->product_code;
        $product->root = $request->root;
        $product->buying_price = $request->buying_price;
        $product->selling_price = $request->selling_price;
        $product->supplier_id = $request->supplier_id;
        $product->buying_date = $request->buying_date;
        $product->product_quantity = $request->product_quantity;
        $product->image = '/'.env('APP_BASE_URL').$image_url;
        $product->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = DB::table('products')->where('id',$id)->first();
        return response()->json($product);
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
        $validateData = $request->validate([
            'product_name' => 'required|max:255',
            'product_code' => 'required|max:255',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'buying_date' => 'required',
            'product_quantity' => 'required',
            'image' => 'required',
        ]);

        $img = DB::table('products')->where('id',$id)->first();
        $oldphoto = $img->image;

        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_code'] = $request->product_code;
        $data['root'] = $request->root;
        $data['buying_price'] = $request->buying_price;
        $data['selling_price'] = $request->selling_price;
        $data['supplier_id'] = $request->supplier_id;
        $data['buying_date'] = $request->buying_date;
        $data['product_quantity'] = $request->product_quantity;
        
        if($oldphoto == $request->image ){ //no need to update and delete picture
            $data['image'] = $oldphoto;
            $user = DB::table('products')->where('id',$id)->update($data);
            
        }else{
            $newImage = $request->image;
            $position = strpos($newImage, ';');
            $sub = substr($newImage, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().".".$ext;
            //using image intervention
            $img = Image::make($newImage)->resize(240,200);
            $upload_path = 'backend/product/';
            $image_url = $upload_path.$name;
            
            $success = $img->save($image_url);

            if($success){
                $data['image'] = '/'.env('APP_BASE_URL').$image_url;
                $oldPhotoUnlinkUrl = ltrim($oldphoto, '/');
                $done = unlink($oldPhotoUnlinkUrl); //remove old photo from directory
                $user = DB::table('products')->where('id',$id)->update($data); //update all data in database
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
        $product = DB::table('products')->where('id',$id)->first();
        $photo = ltrim($product->image, '/');
        
        if($photo){
            unlink($photo);
            DB::table('products')->where('id', $id)->delete();
        }else{
            DB::table('products')->where('id', $id)->delete();
        }
    }

    public function StockUpdate(Request $request, $id){
        $validateData = $request->validate([
            'product_quantity' => 'required|integer|min:0',
        ]);


        $data = array();
        $data['product_quantity'] = $request->product_quantity;
        DB::table('products')->where('id',$id)->update($data);

    }
}
