<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Image $image
     * @return Image
     */
    public function store($image, $pathPrefix, $auction_id)
    {
        $stored_image = new Image();

        $stored_image->id = Image::max('id') + 1;

        $destinationPath = $pathPrefix;
        $filename = $stored_image->id . '.' . $image->extension();
        $image->move($destinationPath, $filename);

        $stored_image->path = $destinationPath . $filename;

        $stored_image->auction_id = $auction_id;
        $stored_image->save();

        return $image;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
