<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
Use Image;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    
    public function index(Request $request)
    { 
        $portfolios = Portfolio::all();

        if($request->filled('q')){
            $q = $request->q;
            $portfolios = Portfolio::where('category', 'like', '%' .$q. '%')->get();
        } 
        $data = ['portfolios' => $portfolios];
        
        return response()->json($data, 200);
    }

    
    public function store(StorePortfolioRequest $request)
    {
        $images  =  $request->file('images');
        $portfolio = new Portfolio;
        $portfolio->title = $request->title;
        $portfolio->category = $request->category;
        $portfolio->description = $request->description;
        
        //  multiple image upload
        $imageUrls = [];
        
        foreach ($images as $image) {
            $imageSaveAsName = "image-".time().rand(0, 100).$image->getClientOriginalName();
            $imagePath = $image->storeAs('public/images', $imageSaveAsName);
            $imageUrls[] = "images/".$imageSaveAsName;
        }
     
        // thumbnail image upload , using Intervention  
        $imageThumnbnail = Image::make($images[0]);   
        $imageThumnbnail->resize(250,125);
        $imageThumnbnailSaveAsName = "thumbnail-".time().$images[0]->getClientOriginalName();
        $thumbnailPath = Storage::put('public/thumbnails/' . $imageThumnbnailSaveAsName , (string)  $imageThumnbnail->encode());
        // end upload
        $portfolio->images = implode(",",$imageUrls);
        $portfolio->thumbnail = "thumbnails/".$imageThumnbnailSaveAsName;
        $portfolio->save(); 

        return response()->json([
            'message' => 'Portfolio has been created successfully !'
        ]);
    }

  
    public function show($id)
    {
        $portfolio = Portfolio::find($id);

        if(!$portfolio) {
            return response()->json([
                'message' => 'Portfolio not found !'
            ]);
        }

        return response()->json($portfolio, 200);
    }

  
    public function update(UpdatePortfolioRequest $request, $id)
    {        
        $images  =  $request->file('images');

        $portfolio = Portfolio::find($id);

        if(!$portfolio) {
            return response()->json([
                'message' => 'Portfolio not found !'
            ]);
        }

        $portfolio->title = $request->title;
        $portfolio->category = $request->category;
        $portfolio->description = $request->description;

        //multiple image update
        $imageUrls = [];
        
        foreach ($images as $image) {
            $imageSaveAsName = "image-".time().rand(0, 100).$image->getClientOriginalName();
            $imagePath = $image->storeAs('public/images', $imageSaveAsName);
            $imageUrls[] = "images/".$imageSaveAsName;
        }
     
        // thumbnail image upload , using Intervention  
        $imageThumnbnail = Image::make($images[0]);   
        $imageThumnbnail->resize(250,125);
        $imageThumnbnailSaveAsName = "thumbnail-".time().$images[0]->getClientOriginalName();
        $thumbnailPath = Storage::put('public/thumbnails/' . $imageThumnbnailSaveAsName , (string)  $imageThumnbnail->encode());
        // end upload
        $portfolio->images = implode(",",$imageUrls);
        $portfolio->thumbnail = "thumbnails/".$imageThumnbnailSaveAsName;
        $portfolio->save(); 


        return response()->json([
            'message' => 'Portfolio has been updated successfully !'
        ]);
    }

    public function destroy($id)
    {
        $portfolio = Portfolio::find($id)->delete();
        
        if(!$portfolio) {
            return response()->json([
                'message' => 'Portfolio not found !'
            ]);
        }
        return response()->json([
            'message' => 'Portfolio has been deleted successfully !'
        ]);
    }
}
