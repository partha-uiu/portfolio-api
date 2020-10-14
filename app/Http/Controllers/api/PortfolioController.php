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
        $imagePath = $request->images->storeAs('images',  "image-".time().$file->getClientOriginalName());
      
        $imageForThumnbnail = Image::make($file);   
        $imageForThumnbnail->resize(250,125);
        $fileName = md5($imagePath . microtime());
        $extension = '.' . explode("/", $imageForThumnbnail->mime())[1];
        $thumbnailPath = Storage::put('public/thumbnails/' . $fileName . $extension,  $imageForThumnbnail->encode());

        $portfolio->thumbnail = $thumbnailPath;
        $portfolio->images = $imagePath;
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
        $portfolio = Portfolio::find($id);

        if(!$portfolio) {
            return response()->json([
                'message' => 'Portfolio not found !'
            ]);
        }

        $portfolio->title = $request->title;
        $portfolio->category = $request->category;
        $portfolio->description = $request->description;
        // image and thumbnail upload
        $file =  $request->file('images');
        $imageForThumnbnail = Image::make( $file);   
        $imageForThumnbnail->resize(250,125);

        $thumbnailPath = $imageForThumnbnail->storeAs('thumbnails',  "tumbnail-".time().$request->images->getClientOriginalName());
        $imagePath = $request->images->storeAs('images',  "image-".time().$request->image->getClientOriginalName());
        $portfolio->thumbnail = $thumbnailPath;
        $portfolio->images = $imagePath;
        $portfolio->save();

        return response()->json([
            'message' => 'Portfolio has been updated successfully !'
        ]);
    }

    public function destroy(Portfolio $portfolio)
    {
        Portfolio::find($id)->delete();
        
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
