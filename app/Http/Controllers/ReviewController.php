<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class ReviewController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            default: 
                return inertia('Modules/Reviews/Index');
        }
    }

    public function lists($request){
        $data = DefaultResource::collection(
            Review::query()
            ->with('user.profile','appointment')
            ->paginate($request->counts)
        );
        return $data;
    }

    public function store(Request $request){
       
        $count = Appointment::where('id',$request->appointment_id)->where('is_rated',0)->count();
        if($count > 0){
            $wew = Appointment::where('id',$request->appointment_id)->update(['is_rated' => 1]);
            $data = Review::create(array_merge($request->all(), ['user_id' => \Auth::user()->id]));
        
            return back()->with([
                'data' => $data,
                'message' => 'Appointment rated successfully.',
                'info' => '-',
                'status' => true,
            ]);
        }else{
            return back()->with([
                'data' => $data,
                'message' => 'Appointment already rated.',
                'info' => '-',
                'status' => true,
            ]);
        }
    }
}
