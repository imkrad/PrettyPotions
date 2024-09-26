<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Dropdown;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\DropdownResource;
use App\Http\Resources\ServiceResource;

class ServiceController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            default: 
                return inertia('Modules/Services/Index',[
                    'categories' => DropdownResource::collection(Dropdown::where('classification','Category')->get())
                ]);
        }
    }
    
    public function store(Request $request){
        $data = Service::create(array_merge($request->all(), ['is_active' => 1]));

        return back()->with([
            'data' => $data,
            'message' => 'Service added successfully.',
            'info' => '-',
            'status' => true,
        ]);
    }

    public function lists($request){
        $data = ServiceResource::collection(
            Service::query()
            ->with('category')
            ->when($request->category, function ($query, $category) {
                $query->where('category_id',$category);
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('service', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at','desc')
            ->paginate($request->counts)
        );
        return $data;
    }

    public function update(Request $request){
        $data = Service::findOrFail($request->id);
        $data->update($request->except('editable'));

        return back()->with([
            'data' => $data,
            'message' => 'Service updated successfully.',
            'info' => '-',
            'status' => true,
        ]);
    }
}
