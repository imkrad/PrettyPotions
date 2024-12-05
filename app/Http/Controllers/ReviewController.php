<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\ServiceRate;
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
       
        $rate = AppointmentService::where('id',$request->id)->first();
        $rate->rating = $request->rating;
        $rate->comment = $request->comment;
        $rate->save();
        $rate = AppointmentService::with('service','status')->where('id',$request->id)->first();
            return back()->with([
            'data' => $rate,
            'message' => 'Appointment rated successfully.',
            'info' => '-',
            'status' => true,
        ]);
        // if($count > 0){
           
        //     return back()->with([
        //         'data' => $data,
        //         'message' => 'Appointment rated successfully.',
        //         'info' => '-',
        //         'status' => true,
        //     ]);
        // }else{
        //     return back()->with([
        //         'data' => $data,
        //         'message' => 'Appointment already rated.',
        //         'info' => '-',
        //         'status' => true,
        //     ]);
        // }
    }
}
