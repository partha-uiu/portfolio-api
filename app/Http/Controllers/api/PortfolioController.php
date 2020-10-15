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
    
    public function index()
    { 
        $portfolios = Portfolio::all();
        
        $data = ['portfolios' => $portfolios];

        return response()->json($data, 200);
    }

    
    public function store(StorePortfolioRequest $request)
    {
        $file =  $request->file('images');

        $portfolio = new Portfolio;
        $portfolio->title = $request->title;
        $portfolio->category = $request->category;
        $portfolio->description = $request->description;
        //  general image upload
        $imageSaveAsName = "image-".time().$file->getClientOriginalName();
        $imagePath = $request->images->storeAs('images', $imageSaveAsName);
        // thumbnail image upload , using Intervention  
        $imageThumnbnail = Image::make($file);   
        $imageThumnbnail->resize(250,125);
        $imageThumnbnailSaveAsName = "thumbnail-".time().$file->getClientOriginalName();
        $extension = '.' . explode("/", $imageThumnbnail->mime())[1];
        $thumbnailPath = Storage::put('thumbnails/' . $imageThumnbnailSaveAsName , (string)  $imageThumnbnail->encode());
        // end upload
        $portfolio->images = "portfolios/". $imageSaveAsName;
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
        $file =  $request->file('images');
        $portfolio = Portfolio::find($id);

        if(!$portfolio) {
            return response()->json([
                'message' => 'Portfolio not found !'
            ]);
        }

        $portfolio->title = $request->title;
        $portfolio->category = $request->category;
        $portfolio->description = $request->description;
        //  general image upload
        $imageSaveAsName = "image-".time().$file->getClientOriginalName();
        $imagePath = $request->images->storeAs('images', $imageSaveAsName);
        // thumbnail image upload , using Intervention  
        $imageThumnbnail = Image::make($file);   
        $imageThumnbnail->resize(250,125);
        $imageThumnbnailSaveAsName = "thumbnail-".time().$file->getClientOriginalName();
        $extension = '.' . explode("/", $imageThumnbnail->mime())[1];
        $thumbnailPath = Storage::put('thumbnails/' . $imageThumnbnailSaveAsName , (string)  $imageThumnbnail->encode());
        // end upload
        $portfolio->images = "portfolios/". $imageSaveAsName;
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
