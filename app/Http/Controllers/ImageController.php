<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Image $image
     * @return Image
     */
    public static function store($image, $pathPrefix, $auction_id)
    {
        // stores an image in the format "ID.EXTENSION"
        $stored_image = new Image();

        $stored_image->id = Image::max('id') + 1;

        $destinationPath = $pathPrefix;
        $filename = $stored_image->id . '.' . $image->extension();
        $image->move($destinationPath, $filename);

        $stored_image->path = $destinationPath . $filename;

        $stored_image->auction_id = $auction_id;
        $stored_image->save();

        return $stored_image->id;
    }

    /**
     * Deletes an individual item.
     *
     * @param int $id
     * @return Response
     * @throws AuthorizationException
     */
    public function delete($id)
    {
        $image = Image::find($id);
        $this->authorize('delete', $image);
        $image->delete();
        return $image;
    }

    public static function deleteUserImage($imageID){
        $image = Image::find($imageID);
        if (!str_contains($image->path, 'default')){
            File::delete($image->path);
            $image->delete();
        }
    }
}
