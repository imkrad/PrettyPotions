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
       
        $count = Appointment::where('id',$request->appointment_id)->where('is_rated',0)->count();
        if($count > 0){
            $wew = Appointment::where('id',$request->appointment_id)->update(['is_rated' => 1]);
            $data = Review::create(array_merge($request->all(), ['user_id' => \Auth::user()->id]));
            if($data){
                $services = AppointmentService::where('appointment_id',$request->appointment_id)->get();
                foreach($services as $service){
                    $rate = new ServiceRate;
                    $rate->rating = $request->rating;
                    $rate->appointment_id = $request->appointment_id;
                    $rate->service_id = $service['service_id'];
                    $rate->user_id = \Auth::user()->id;
                    $rate->save();
                }
            }
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
