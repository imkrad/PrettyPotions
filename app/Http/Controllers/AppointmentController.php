<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\AppointmentReason;
use App\Models\AestheticianService;
use App\Models\Dropdown;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\DropdownResource;
use App\Http\Resources\CalendarResource;
use GuzzleHttp\Client;
use App\Services\TwilioService;

class AppointmentController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            case 'reports':
                return $this->reports($request);
            break;
            case 'report':
                return $this->report($request);
            break;
            case 'ids':
                return $this->ids($request);
            break;
            case 'aestheticians':
                return $this->aestheticians($request);
            break;
            case 'calendar': 
                return $this->calendar($request);
            break;
            default: 
                return inertia('Modules/Appointments/Index',[
                    'categories' => DropdownResource::collection(Dropdown::with('services')->where('classification','Category')->get()),
                ]);
        }
    }
    public function notify($request){
        dd('wew');
    }

    public function lists($request){
        $data = DefaultResource::collection(
            Appointment::query()
            ->with('user.profile','status','lists.service','lists.status','lists.aesthetician.user.profile','review')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('code', 'LIKE', "%{$keyword}%");
                $query->orWhereHas('user',function ($query) use ($keyword) {
                    $query->whereHas('profile',function ($query) use ($keyword) {
                        $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', "%{$keyword}%")
                        ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', "%{$keyword}%");
                    });
                });
            })
            ->paginate($request->counts)
        );
        return $data;
    }

    public function store(Request $request){
        
        if($request->option == 'service'){
            $service = new AppointmentService;
            $service->price = $request->service['price'];
            $service->service_id =  $request->service['id'];
            ($request->aesthetician) ? $service->aesthetician_id = $request->aesthetician['value'] : '';
            $service->status_id = 19;
            $service->appointment_id = $request->appointment_id;
            if($service->save()){
                $data = Appointment::query()
                ->with('user.profile','status','lists.service','lists.status','lists.aesthetician.specialist','lists.aesthetician.user.profile','review')
                ->where('id',$request->appointment_id)
                ->first();

                $data->total = $data->total+$request->service['price'];
                $data->save();
                $message = 'Service added successfully';
                $status = true;
            }
        }else if($request->option == 'more'){
            $date = $request->date;
            $time = date('H:i:s', strtotime($request->time));
            $date = $date.' '.$time;
            $data = new AppointmentService;
            $data->service_id = $request->service_id;
            $data->appointment_id = $request->appointment_id;
            $data->status_id = 19;
            $data->aesthetician_id = $request->aesthetician_id;
            $data->date =  $date;
            $data->price = $request->price;
            $data->save();
            $data = Appointment::with('lists.service','lists.status','lists.aesthetician.specialist','lists.aesthetician.user.profile','user.profile','status')->where('id',$request->appointment_id)->first();
            $message = 'Service added successfully';
            $status = true;

        }else if($request->option == 'remove'){
            $del = AppointmentService::where('id',$request->service['id'])->delete();
            if($del){
                $data = Appointment::query()
                ->with('user.profile','status','lists.service','lists.status','lists.aesthetician.specialist','lists.aesthetician.user.profile','review')
                ->where('id',$request->appointment_id)
                ->first();

                $data->total = $data->total-$request->service['price'];
                $data->save();

                $message = 'Service remove successfully';
                $status = false;
            }
        }else if($request->option == 'aesthetician'){
            $app = AppointmentService::where('id',$request->id)->first();
            $app->aesthetician_id = $request->aesthetician_id;
            if($app->save()){
                $data = Appointment::query()
                ->with('user.profile','status','lists.service','lists.status','lists.aesthetician.specialist','lists.aesthetician.user.profile','review')
                ->where('id',$request->appointment_id)
                ->first();

                $message = 'Aesthetician added successfully';
                $status = true;
            }
        }else if($request->option == 'checking'){
            $date = $request->date;
            $time = date('H:i:s', strtotime($request->time));
            $date = $date.' '.$time;
            $check = AppointmentService::where('aesthetician_id', $request->aesthetician_id)
            ->where('date',$date)
            ->exists();

            if($check > 0){
                $message = 'Date and time is already booked.';
                $data = [];
                $status = false;
            }else{
                $message = 'wew.';
                $data = [];
                $status = true;
            }
        }else if($request->option == 'walkin'){
            $user_id = ($request->user_id) ? $request->user_id : \Auth::user()->id;
            $count = Appointment::count();
            $code = 'PP-'.date('Y').'-'.str_pad(($count+1), 5, '0', STR_PAD_LEFT);  
            $data = Appointment::create(array_merge($request->all(), ['code' => $code, 'user_id' => $user_id,'status_id' => 19, 'is_wlakin' => 1]));
            $carts = $request->cart;
            foreach($carts as $cart){
                    
                $date = $cart['date'];
                $time = date('H:i:s', strtotime($cart['time']));
                $datetime = $date.' '.$time;
                $service = new AppointmentService;
                $service->price = $cart['price'];
                $service->service_id = $cart['id'];
                $service->date = $datetime;
                $service->status_id = 19;
                ($cart['aesthetician'] != '' || $cart['aesthetician'] != NULL) ? $service->aesthetician_id = $cart['aesthetician']['value'] : '';
                $service->appointment_id = $data->id;
                $service->save();
            }
            
            $message = 'Appointment saved successfully';
            $status = true;
        }else{
            $request->validate([
                'user_id' => 'required_if:role,==,Receptionist'
            ]);

            $user_id = ($request->user_id) ? $request->user_id : \Auth::user()->id;
            $count = Appointment::count();
            $code = 'PP-'.date('Y').'-'.str_pad(($count+1), 5, '0', STR_PAD_LEFT);  
            $data = Appointment::create(array_merge($request->all(), ['code' => $code, 'user_id' => $user_id,'status_id' => 19]));
            $carts = $request->cart;
            foreach($carts as $cart){
                $service = new AppointmentService;
                $service->price = $cart['service']['price'];
                $service->service_id = $cart['service']['id'];
                $service->date = Carbon::createFromFormat('M d, Y g:i a', $cart['date'])->format('Y-m-d H:i:s');;
                $service->status_id = 19;
                ($cart['aesthetician'] != '' || $cart['aesthetician'] != NULL) ? $service->aesthetician_id = $cart['aesthetician']['id'] : '';
                $service->appointment_id = $data->id;
                $service->save();
            }

            Booking::where('user_id',\Auth::user()->id)->delete();
            
            $message = 'Appointment added successfully';
            $status = true;
            
        }

        return back()->with([
            'data' => $data,
            'message' => $message,
            'info' => '-',
            'status' => $status,
        ]);
    }

    public function update(Request $request){
        if($request->option == 'notify'){
            $list = $request->list;
           
            $name = $list['user']['profile']['firstname'].' '.$list['user']['profile']['lastname'];
            $mobile = $list['user']['profile']['mobile'];
            // $mobile = '09171531652';
            $date = $list['date'];
            $content = 'Appointment Reminder: Hello '.$name.' from Pretty Potions! Your appointment is scheduled on '.$date.'. Please be there. See you soon!';
            
            $this->twilio->sendSms($mobile, $content);
            return back()->with([
                'data' => $response,
                'message' => 'Message sent successfully.',
                'info' => '-',
                'status' => true,
            ]);
        }else if($request->option == 'Cancel'){
            $a = Appointment::with('lists.service')->where('id',$request->id)->first();
            $a->status_id = $request->status_id;
            $a->save();

            foreach($a->lists as $list){
                $serviceMessages[] = "{$list->service->service} ({$list->date})";
            }
            if($a){
                $content = 'Booking Cancellation Notice, We\'re sorry to inform you that your booking for '.implode(', ', $serviceMessages).' Pretty Potions has been cancelled due to '.$request->reason.'. If you have any questions or would like to reschedule, please contact us at 0995-513-6602. We apologize for any inconvenience this may have caused and appreciate your understanding.';
                $this->twilio->sendSms($a->user->profile->mobile, $content);

                return back()->with([
                    'data' => '',
                    'message' => 'Appointment cancelled successfully.',
                    'info' => '-',
                    'status' => true,
                ]);
            }
        }else if($request->option == 'Confirm'){
            $a = Appointment::with('lists.service','user.profile')->where('id',$request->id)->first();
            $a->status_id = $request->status_id;
            $a->save();
            foreach($a->lists as $list){
                $serviceMessages[] = "{$list->service->service} ({$list->date})";
            }
            if($a){
                $content = 'Thank you for choosing Pretty Potions. Your reservation for '.implode(', ', $serviceMessages).' has been successfully confirmed. If you have any questions or need to make changes, please contact us at 0995-513-6602. We look forward to serving you!';
                $this->twilio->sendSms($a->user->profile->mobile, $content);

                return back()->with([
                    'data' => '',
                    'message' => 'Appointment confirmed successfully.',
                    'info' => '-',
                    'status' => true,
                ]);
               
            }
        }else if($request->option == 'service'){
            $data = AppointmentService::findOrFail($request->id);
            $data->update($request->except('editable'));

            return back()->with([
                'data' => $data,
                'message' => 'Service updated successfully.',
                'info' => '-',
                'status' => true,
            ]);
        }else if($request->option == 'completed'){
            $data = AppointmentService::findOrFail($request->id);
            $data->status_id = 20;
            $data->save();

            $data = Appointment::with('lists.service','lists.status','lists.aesthetician.specialist','lists.aesthetician.user.profile','user.profile','status')->where('id',$request->selected)->first();

            return back()->with([
                'data' => $data,
                'message' => 'Service updated successfully.',
                'info' => '-',
                'status' => true,
            ]);
        }else{
            // $validatedData = $request->validate([
            //     'date' => 'required',
            //     'time' => 'required',
            //     'cart' => 'required',
            // ]);

            
            $data = Appointment::findOrFail($request->id);
            $data->update($request->except('editable'));
            $data = Appointment::with('lists.service','lists.status','lists.aesthetician.specialist','lists.aesthetician.user.profile','user.profile','status')->where('id',$request->id)->first();
            
            if($request->status_id == 22){
                $mobile = $data->user->profile->mobile;
                $content = 'Thank you for choosing Pretty Potions. Your reservation at prettypotion has been successfully confirmed. If you have any questions or need to make changes, please contact us at 0995-513-6602. We look forward to serving you!';
                $this->twilio->sendSms($mobile, $content);
            }
            return back()->with([
                'data' => $data,
                'message' => 'Appointment updated successfully.',
                'info' => '-',
                'status' => true,
            ]);
        }
    }

    public function reports($request) {
        $current_year = $request->year;
        $months = [];
        $laboratory = $request->laboratory;
    
        // Generate month labels (e.g., "Jan", "Feb", etc.)
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
        }
    
        $programs = [
            ['name' => 'Completed Appointments', 'value' => 20],
            ['name' => 'Cancelled Appointments', 'value' => 21],
        ];
    
        $arr = [];
    
        foreach ($programs as $program) {
            $data = [];
            $status_id = $program['value'];
    
            // Iterate through each month in the current year
            for ($month = 1; $month <= 12; $month++) {
                $count = Appointment::where('status_id', $status_id)
                    ->whereYear('created_at', $current_year)
                    ->whereMonth('created_at', $month)
                    ->count();
                $data[] = $count;
            }
    
            $arr[] = [
                'name' => $program['name'],
                'data' => $data
            ];
        }
    
        return [
            'categories' => $months,
            'lists' => $arr
        ];
    }

    public function ids($request){
        $lists = $request->lists;
        $ids = [];
        foreach ($lists as $item) {
            $ids[] = $item['id'];
        }

        $services = Service::with('category.aestheticians.aesthetician.user.profile')->whereNotIn('id',$ids)->get()->map(function ($item) {
            $aestheticians = [];
            if(count($item->category->aestheticians) > 0){
                foreach($item->category->aestheticians as $i){
                    $aestheticians[] = [
                        'value' => $i->aesthetician->id,
                        'name' => $i->aesthetician->user->profile->firstname.' '.$i->aesthetician->user->profile->lastname
                    ];
                }
            }
            return [
                'id' => $item->id,
                'value' => $item->id,
                'name' => $item->service.' - '.$item->price,
                'service' => $item->service,
                'price' => $item->price,
                'aestheticians' => $aestheticians
            ];
        });
        return $services;
    }

    public function aestheticians($request){
        $a = AestheticianService::with('aesthetician.user.profile')->where('category_id',$request->category_id)->get()->map(function ($item) {
            return [
                'value' => $item->aesthetician->id,
                'name' => $item->aesthetician->user->profile->firstname.' '.$item->aesthetician->user->profile->lastname,
            ];
        });
        return $a;
    }

    public function calendar($request){
        $data = CalendarResource::collection(
            AppointmentService::query()
            ->with('appointment.user.profile','status','service','aesthetician.user.profile')
            ->whereIn('status_id',[19,22,23])
            ->get()
        );

        return $data;
    }

    public function report($request){ 
        $year = ($request->year) ? $request->year : date('Y');
        $category = $request->category;
        $target = $request->target;

        $query = AppointmentService::query();
        $query->with('appointment','appointment.user.profile','service','status','aesthetician.user.profile')
        ->whereYear('created_at',$year);
        if($category == 'Daily'){
            $query->whereDate('created_at',$target);
        }else if($category == 'Monthly'){
            $query->whereMonth('created_at',date('n', strtotime($target)));
        }else{
            $query->whereYear('created_at',$year);
        }
        $lists = $query->get();
        $array = [
            'title' => 'List of Appointment',
            'lists' => $lists,
            'year' => $year
        ];
        $pdf = \PDF::loadView('reports',$array)->setPaper([0, 0, 500, 900], 'landscape');
        return $pdf->stream('reports.pdf');
    }
    
}
