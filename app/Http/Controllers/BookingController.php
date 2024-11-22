<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Aesthetician;
use App\Models\AppointmentService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request){
        if($request->option == 'delete'){
            $booking = Booking::where('id',$request->id)->where('user_id',\Auth::user()->id)->first();
            $booking->delete();
            return back()->with([
                'data' => '',
                'message' => 'Removed service',
                'info' => 'You successfully remove the service',
                'status' => true,
            ]);
        }else{
            $validated = $request->validate([
                'service_id' => 'required',
                'category' => 'required',
                'date' => 'required',
                'time' => 'required',
            ]);

            $aesthetician = $request->aesthetician_id;
            $service = $request->service_id;
            $category = $request->category;
            $date = $request->date.' '.date('H:i:s', strtotime($request->time));
            
            if($aesthetician){
                $checkBooking = Booking::where('aesthetician_id',$aesthetician)->where('date',$date)->count();
                if($checkBooking > 0){
                    $data = [];
                    $message = 'Cannot add to booking';
                    $info = 'Sorry aesthetician on this date was already booked';
                    $status = false;
                }else{
                    $checkBooking2 = AppointmentService::where('aesthetician_id',$aesthetician)->where('date',$date)->count();
                    if($checkBooking2 > 0){
                        $data = [];
                        $message = 'Cannot add to booking';
                        $info = 'Sorry aesthetician on this date was already booked';
                        $status = false;
                    }else{
                        $data = Booking::create(array_merge($request->all(),['date' => $date, 'user_id' => \Auth::user()->id]));
                        if($data){
                            $message = 'Added to booking list';
                            $info = 'Successfully added to booking list';
                            $status = true;
                        }
                    }
                }
            }else{
                $checkBooking = Booking::whereHas('service',function ($query) use ($category) { 
                    $query->where('category_id',$category);
                })
                ->where('date',$date)->where('aesthetician_id',null)->count();
                
                $availableAestheticians = Aesthetician::whereHas('lists',function ($query) use ($category) {
                    $query->whereHas('category',function ($query) use ($category) {
                        $query->where('id',$category);
                    });
                })
                ->whereDoesntHave('bookings', function ($query) use ($date) {
                    $query->where('date', $date);
                })
                ->whereDoesntHave('services', function ($query) use ($date) {
                    $query->where('date', $date);
                })
                ->count();
                $total = $availableAestheticians - $checkBooking;
                if($total > 0){
                    $data = Booking::create(array_merge($request->all(),['date' => $date, 'user_id' => \Auth::user()->id]));
                    if($data){
                        $message = 'Added to booking list';
                        $info = 'Successfully added to booking list';
                        $status = true;
                    }
                }else{
                    $data = [];
                    $message = 'Cannot add to booking';
                    $info = 'Sorry booking for this date is full.';
                    $status = false;
                }

            
            }

            return back()->with([
                'data' => $data,
                'message' => $message,
                'info' => $info,
                'status' => $status,
            ]);
        }
    }
}
