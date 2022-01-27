<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //STORAGE
        $path = 'img/auto/';
        $file = $request->file('img');
        // dd($file);
        $new_image_name = date('Ymd').uniqid().'.jpg';
        $file->move(public_path($path), $new_image_name);

        //DB
        $file = new File();
        $file->url = $new_image_name;
        $file->save();

        return redirect()->route('home');
    }

    public function storeUrl(Request $request)
    {
        //STORAGE
        $remoteImage = $request->filename;
        $content = file_get_contents($remoteImage);
        // dd($content);
        $end = Str::afterLast($remoteImage, '.');
        dd($end);
        $uniqueName = uniqid().".".$end;
        Storage::disk('public')->put('img/auto/'.$uniqueName, $content);
        
        //DB
        $file = new File();
        $file->url = $uniqueName;
        $file->save();

        return redirect()->route('home');
    }
    public function destroy(File $file)
    {
        //STORAGE
        $destination = "/img/auto/".$file->url;
        Storage::disk('public')->delete($destination);

        //DB
        $file->delete();
        return redirect()->back();
    }
    public function show(File $file)
    {
        //
    }

    public function edit(File $file)
    {
        //
    }

    public function update(Request $request, File $file)
    {
        if ($request->img != null) {
            Storage::disk('public')->delete("/img/auto/".$file->url);
            $new_image_name = date('Ymd').uniqid().'.jpg';
            $request->file('img')->move(public_path("/img/auto/"), $new_image_name);

            $file->url = $new_image_name;
            $file->save();
            
        }
        return redirect()->route('home');
    }

    public function download(File $file)
    {
        return Storage::disk('public')->download('img/auto/'. $file->url);
    }


}
