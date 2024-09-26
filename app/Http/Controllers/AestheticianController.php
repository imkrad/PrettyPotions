<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Dropdown;
use App\Models\Aesthetician;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\DropdownResource;

class AestheticianController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            default: 
                return inertia('Modules/Aestheticians/Index',[
                    'categories' => DropdownResource::collection(Dropdown::where('classification','Category')->get()),
                    'specialists' => DropdownResource::collection(Dropdown::where('classification','Specialist')->get()),
                    'users' => UserResource::collection(User::whereNotIn('id', function ($query) {
                        $query->select('user_id')->from('aestheticians');
                    })->where('role','Staff')->get())
                ]);
        }
    }

    public function store(Request $request){
        $request->validate([
            'user_id' => 'required',
            'specialist_id' => 'required',
            'categories' => 'required|array|min:1'
        ]);
        $user_id = $request->user_id;
        $count = Aesthetician::where('user_id',$user_id)->count();
        if($count == 0){
            $data = Aesthetician::create($request->except('categories'));
            if($data){
                $categories = $request->categories;
                foreach ($categories as $category) {
                    $category_id = $category['id'];
                    if(!$data->lists->contains('category_id', $category['id'])){
                        $data->lists()->create([
                            'category_id' => $category['id'],
                        ]);
                    }
                    $ids[] = $category['id'];
                }
                $data->lists()->whereNotIn('category_id', $ids)->delete();
            }
        }else{
            $data = [];
        }

        // $services = Service::where('category_id',$category_id)->get();
        // foreach($services as $service){
        //     if(!$data->lists->contains('service_id', $service['id'])){
        //         $data->lists()->create([
        //             'service_id' => $service['id'],
        //         ]);
        //     }
        //     $ids[] = $service['id'];
        // }
        // $data->lists()->whereNotIn('service_id', $ids)->delete();

        return back()->with([
            'data' => $data,
            'message' => 'Aesthetician added successfully.',
            'info' => '-',
            'status' => true,
        ]);
    }

    public function lists($request){
        $data = DefaultResource::collection(
            Aesthetician::query()
            ->with('user.profile','specialist','lists.category.services')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('user.profile',function ($query) use ($keyword) {
                    $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', "%{$keyword}%")
                    ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', "%{$keyword}%");
                });
            })
            ->when($request->specialist, function ($query, $specialist) {
                $query->where('specialist_id',$specialist);
            })
            ->paginate($request->counts)
        );
        return $data;
    }
}
