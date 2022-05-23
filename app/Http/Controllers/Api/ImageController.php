<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use App\Jobs\ImageUploadJob;

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

        // download image using job queue
        dispatch(new ImageUploadJob($data));

    }
}
