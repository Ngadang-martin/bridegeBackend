<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //
    public function getAll() {
        $product  = Product::all();
        $response = [
            'products' => $product,
            'message' => "success",
        ];
        return response($response,200);
    }

    public function storeProduct(Request $request) {

        $validator = Validator::make($request->all(), [
            'name'=>'required|string',
            'description'=>'required',
            'price'=> ['required','numeric','regex:/^\d+(\.\d{1,2})?$/'],
            'slug'=>'required|string',
            'image'=>'required'
        ]);

        // if ($validator->errors()) {
        //     return response($validator->errors(),422);
        // }

        if($request->hasFile('image')){
            // Get filename with the extension
            $image = $request->file('image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
              $image->move(public_path('images'), $new_name);
         }



        $product =  Product::create( [
            'name'=> $request['name'],
            'description'=> $request['description'],
            'price'=> $request['price'],
            'slug'=>$request['slug'],
            'image'=>  $new_name
        ]);

        $response = [
            'product' => $product,
            'message' => "success",
        ];

        return response($response,200);
    }

    public function updateProduct(Request $request,$id)  {

        $validator = Validator::make($request->all(), [
            'name'=>'string',
            'description'=>'string',
            'price'=> ['required','numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'slug'=>'required|string',
            'image'=>'string'
        ]);

        $product=Product::find($id);
        $product->update($request->all());
        $response = [
            'product' => $product,
            'message' => "success",
        ];

        return response($response,200);
    }

    public function getSingleProduct(Product $product, $id) {
        $product=Product::find($id);
        $response = [
            'product' => $product,
            'message' => "success",
        ];

        return response($response,200);
    }

    public function deleteProduct($id) {
        Product::destroy($id);
        $response = [
            'message' => "success",
        ];
        return response($response,200);
    }
}


