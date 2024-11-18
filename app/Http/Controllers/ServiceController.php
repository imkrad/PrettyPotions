<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Dropdown;
use App\Models\Aesthetician;
use App\Models\AestheticianService;
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
            case 'services':
                return $this->services($request);
            break;
            case 'checking':
                return $this->checking($request);
            break;
            default: 
                return inertia('Modules/Services/Index',[
                    'categories' => DropdownResource::collection(Dropdown::where('classification','Category')->get())
                ]);
        }
    }

    public function checking($request){
        $date = $request->date;
        $time = date('H:i:s', strtotime($request->time));
        $datetime = $date.' '.$time;
        $serviceId = $request->service;
        $category = $request->category;
        $available2Aestheticians = Aesthetician::with('user.profile')
        ->whereHas('lists',function ($query) use ($category) {
            $query->whereHas('category',function ($query) use ($category) {
                $query->where('id',$category);
            });
        })
        ->whereNotIn('id', function($query) use ($datetime, $serviceId) {
            $query->select('aesthetician_id')
                  ->from('appointment_services')
                  ->where('date', $datetime);
        })
        ->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->user->profile->firstname.' '.$item->user->profile->lastname,
            ];
        });

        $availableAestheticians = Aesthetician::with('user.profile')
        ->whereHas('lists',function ($query) use ($category) {
            $query->whereHas('category',function ($query) use ($category) {
                $query->where('id',$category);
            });
        })
        ->whereNotIn('id', function($query) use ($datetime, $serviceId) {
            $query->select('aesthetician_id')
                  ->from('bookings')
                  ->where('date', $datetime);
        })
        ->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->user->profile->firstname.' '.$item->user->profile->lastname,
            ];
        });

        $commonAestheticians = $availableAestheticians->filter(function ($item) use ($available2Aestheticians) {
            return $available2Aestheticians->contains(function ($innerItem) use ($item) {
                return $innerItem['value'] === $item['value'] && $innerItem['name'] === $item['name'];
            });
        })->values();
        
        // Return the common array for UI
        $arr = $commonAestheticians->toArray();
        return $arr;
       
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

    public function services($request){
        $data = ServiceResource::collection(
            Service::query()
            ->with('category.aestheticians.aesthetician.user.profile','ratings')
            ->when($request->category, function ($query, $category) {
                $query->where('category_id',$category);
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('service', 'LIKE', "%{$keyword}%");
            })
            ->where('is_active',1)
            ->orderBy('category_id','asc')
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
