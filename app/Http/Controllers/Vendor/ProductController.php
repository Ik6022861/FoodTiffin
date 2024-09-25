<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\City;
use App\Models\Category;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function AllProduct(){
        $product = Product::latest()->get();
        return view('vendor.backend.product.all_product', compact('product'));
    }

    public function AddProduct(){
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::latest()->get();
        return view('vendor.backend.product.add_product', compact('category', 'city', 'menu'));
    }

    public function StoreProduct(Request $request){

        $pcode = IdGenerator::generate(['table' => 'products', 'field' => 'code', 'length' => 5, 'prefix' => 'pc']);

        if($request->file('image')){
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/'.$name_generate));
            $save_url = 'upload/product/'.$name_generate;

            Product::create([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'code' => $pcode,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'vendor_id' => Auth::guard('vendor')->id(),
                'most_popular' => $request->most_popular,
                'best_seller' => $request->best_seller,
                'created_at' => Carbon::now(),
                'status' => '1',
                'image' => $save_url,
            ]);
        }
        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.product')->with($notification);
    }

    public function EditProduct($id){
        $product = Product::find($id);
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::latest()->get();
        return view('vendor.backend.product.edit_product', compact('product', 'category', 'city', 'menu'));
    }


    public function UpdateProduct(Request $request){
        $pro_id = $request->id;
        $product = Product::find($pro_id);

        if($request->file('image')){

            // Delete the old image if it exists
            if ($product->image) {
                $oldImagePath = public_path($product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/'.$name_generate));
            $save_url = 'upload/product/'.$name_generate;


            Product::find($pro_id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'most_popular' => $request->most_popular,
                'best_seller' => $request->best_seller,
                'updated_at' => Carbon::now(),
                'image' => $save_url,
            ]);


            $notification = array(
                'message' => 'Product Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.product')->with($notification);

        }else{
            Product::find($pro_id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'most_popular' => $request->most_popular,
                'best_seller' => $request->best_seller,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Product Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.product')->with($notification);
        }
    }

    public function DeleteProduct($id){
        $item = Product::find($id);
        $img = $item->image;
        unlink($img);

        Product::find($id)->delete();

        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function changeStatus(Request $request){
        $product = Product::find($request->product_id);
        $product->status = $request->status;
        $product->save();
        return response()->json(['success' => 'Status Changed Successfully']);
    }
}
