<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    // get images
    public function get_images(Request $request)
    {
        $images = Image::select('id', 'user_id', 'path')->where('user_id', $request->user_id)->get();

        if(!empty($images)){
            return response()->json([
                'success' => true,
                'data' => $images
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data' => []
        ], 204);  
    }

    // upload image
    public function upload_image(Request $request)
    {
        $data = $request->all();

        //validate
        $validator = Validator::make($data, [
            'user_id' => 'required',
            'path' => 'required'
        ]);

        // send validate message
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 422);
        }

        try {
            $file_name = null;
            if ($request->path) {
                $url = $request->path;
                $info = pathinfo($url);
                $file_name = Str::random(5).'_'.$info['basename'];
                $contents = file_get_contents($url);
                Storage::disk('public')->put($file_name, $contents);
            }

            $image= Image::create([
                'user_id' => $request->user_id,
                'path' => $file_name,
            ]);

            if($image){
                return response()->json([
                    'success' => true,
                ], 201);
            }else{
                return response()->json([
                    'success' => false,
                ], 422);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
            ], 422);
        }
  
    }
}