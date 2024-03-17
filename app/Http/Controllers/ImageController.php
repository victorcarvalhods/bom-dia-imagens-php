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

    public function getImages(Request $request)
    {

        $images = Image::all();

        return response()->json($images, 200, [], JSON_UNESCAPED_SLASHES);// used the flag to prevent \/ in the url response
    }

    public function getImagesByUserId(Request $request, $userId){
        $images = Image::where('user_id', $userId)->get();

        return response()->json($images, 200, [], JSON_UNESCAPED_SLASHES);// used the flag to prevent \/ in the url response
    }

    public function getImageById(Request $request, $imageId){
        $image = Image::find($imageId);

        return response()->json($image, 200, [], JSON_UNESCAPED_SLASHES);// used the flag to prevent \/ in the url response
    }

    public function deleteImage(Request $request, $imageId)
    {
        $userId = Auth::id();
        $image = Image::where('id', $imageId)->where('user_id', $userId)->first();
        if ($image) {
            $image->delete();

            return response()->json(null, 204);
        } else {
            if (Image::where('id', $imageId)->exists()) {
                return response()->json(['error' => 'U can only delete ur own images'], 401);
            } else {
                return response()->json(['error' => 'Image not found'], 404);
            }
        }
    }

    private function uploadImage($image)
    {

        $resultURL = AwsS3Service::uploadImage($image);
        $decodedURL = urldecode($resultURL);

        return $decodedURL;
    }
}
