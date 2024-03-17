<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image; // Import the AwsS3Service
use Illuminate\Support\Facades\Auth;
use App\Services\AwsS3Service; // Import the AwsS3Service

class ImageController extends Controller
{
    public function postImage(Request $request)
    {
        $userId = Auth::id();

        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'No image sent'], 400);
        }
        $rules = [
            'image' => 'required|image'
        ];
        $request->validate($rules);

        $image = $request->file('image');

        $imageUploadURLResult = $this->uploadImage($image);

        $createdIMG = Image::create([
            'url' => $imageUploadURLResult,
            'user_id' => $userId
        ]);

        return response()->json($createdIMG, 201, [], JSON_UNESCAPED_SLASHES);// used the flag to prevent \/ in the url response
    }

    private function uploadImage($image)
    {

        $resultURL = AwsS3Service::uploadImage($image);
        $decodedURL = urldecode($resultURL);

        return $decodedURL;
    }
}
