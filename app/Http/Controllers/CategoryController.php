<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dropdown;
use App\Http\Resources\DefaultResource;

class CategoryController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            default: 
                return inertia('Modules/Categories/Index');
        }
    }

    public function lists($request){
        $data = DefaultResource::collection(
            Dropdown::query()
            ->where('classification','Category')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
            ->paginate($request->counts)
        );
        return $data;
    }

    public function store(Request $request){
        $request->validate([
            'image' => 'required|image|max:2048' // Assuming maximum file size is 2MB
        ]);
        
        $data = Dropdown::where('id',$request->id)->first();
        $imagePath = $request->file('image')->store('categories-images', 'public');
        $data->others = $imagePath;
        $data->save();

        return back()->with([
            'data' => $data,
            'message' => 'Image updated successfully.',
            'info' => '-',
            'status' => true,
        ]);
    }
}
