<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class MenuController extends Controller
{
    public function AllMenu(){
        $menu = Menu::latest()->get();
        return view('vendor.backend.menu.all_menu', compact('menu'));
    }

    public function AddMenu(){
        return view('vendor.backend.menu.add_menu');
    }

    public function StoreMenu(Request $request){
        if($request->file('image')){
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/'.$name_generate));
            $save_url = 'upload/menu/'.$name_generate;

            Menu::create([
                'menu_name' => $request->menu_name,
                'image' => $save_url,
            ]);
        }
        $notification = array(
            'message' => 'Menu Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.menu')->with($notification);
    }

    public function EditMenu($id){
        $menu = Menu::find($id);
        return view('vendor.backend.menu.edit_menu', compact('menu'));
    }

    public function UpdateMenu(Request $request){
        $menu_id = $request->id;

        if($request->file('image')){
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/'.$name_generate));
            $save_url = 'upload/menu/'.$name_generate;

            Menu::find($menu_id)->update([
                'menu_name' => $request->menu_name,
                'image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.menu')->with($notification);

        }else{
            Menu::find($menu_id)->update([
                'menu_name' => $request->menu_name,
            ]);

            $notification = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.menu')->with($notification);

        }
    }

    public function DeleteMenu($id){
        $item = Menu::find($id);
        $img = $item->image;
        unlink($img);

        Menu::find($id)->delete();

        $notification = array(
            'message' => 'Menu Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
