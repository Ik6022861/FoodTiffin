<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GalleryController extends Controller
{
    public function allGallery(){
        $gallery = Gallery::latest()->get();
        return view('vendor.backend.gallery.all_gallery', compact('gallery'));
    }

    public function addGallery(){
        $vendor = Vendor::latest()->get();
        return view('vendor.backend.gallery.add_gallery', compact('vendor'));
    }

    public function galleryStore(Request $request){
        $images = $request->file('gallery_img');
        foreach ($images as $image) {
            $manager = new ImageManager(new Driver());
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(500, 500)->save(public_path('upload/gallery/'.$name_generate));
            $save_url = 'upload/gallery/'.$name_generate;

            Gallery::insert([
                'vendor_id' => Auth::guard('vendor')->id(),
                'gallery_img' => $save_url
            ]);
        }

        $notification = array(
            'message' => 'Gallery Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.gallery')->with($notification);
    }

    public function EditGallery($id){
        $gallery = Gallery::find($id);
        return view('vendor.backend.gallery.edit_gallery', compact('gallery'));
    }

    public function UpdateGallery(Request $request){
        $gallery_id = $request->id;

        if($request->hasFile('gallery_img')){
            $image = $request->file('gallery_img');
            $manager = new ImageManager(new Driver());
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(500, 500)->save(public_path('upload/gallery/'.$name_generate));
            $save_url = 'upload/gallery/'.$name_generate;

            $gallery = Gallery::find($gallery_id);
            if($gallery->gallery_img){
                $img = $gallery->gallery_img;
                unlink($img);
            }

            $gallery->update([
                'gallery_img' => $save_url
            ]);

            $notification = array(
                'message' => 'Gallery Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.gallery')->with($notification);

        }else{
            $notification = array(
                'message' => 'No Image Selected for Update.',
                'alert-type' => 'warning'
            );

            return redirect()->back()->with($notification);
        }
    }

    public function DeleteGallery($id){
        $gallery = Gallery::find($id);
        $image = $gallery->gallery_img;
        unlink($image);

        $gallery->delete();

        $notification = array(
            'message' => 'Gallery Deleted Successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
