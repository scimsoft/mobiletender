<?php

namespace App\Http\Controllers;

use App\Models\ProductAdOn;
use App\Traits\ProductTrait;
use App\UnicentaModels\Product;
use App\UnicentaModels\Products_Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function view;

class ProductController extends Controller
{
    use ProductTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category=null)
    {
        //
        if(empty($category)) {
            $products = Product::paginate(50);
        }else{
            $products= $this->getCategoryProducts($category);
    }

        return view('admin.products.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        //
        return view('products.show',compact('product'));
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
        $product=Product::findOrFail($id);
        if (!empty($product->image)) {
            $product->image = base64_encode($product->image);
        }
        $product_addons = ProductAdOn::find($id)->get();
        return view('admin.products.edit',compact('product','product_addons'));
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
        //
        $product=Product::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product=Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success','Product deleted successfully');
    }

    public function editImage($id)
    {

        $product = Product::find($id);
        if (!empty($product->image)) {
            $product->image = base64_encode($product->image);
        }

        return view('admin.products.crop_image', compact('product'));
    }

    public function imageCrop(Request $request)
    {
        $image_file = $request->image;
        $product = Product::find($request->productID);
        list($type, $image_file) = explode(';', $image_file);
        list(, $image_file) = explode(',', $image_file);
        $image_file = base64_decode($image_file);
        $product->image = $image_file;
        $product->save();
        return response()->json(['status' => true]);
    }
    public function toggleCatalog(Request $request){
        Log::debug('product_id:'.$request->product_id);
        $productcat = Products_Cat::find($request->product_id);

        if (empty($productcat)) {
            $cat = new Products_Cat();
            $cat->product = $request->product_id;
            $cat->save();
        } else {
            $productcat->delete();
        }

        return "SUCCES";

    }
}
