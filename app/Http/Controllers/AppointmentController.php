<?php

namespace App\Http\Controllers;

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

class AppointmentController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            case 'reports':
                return $this->reports($request);
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
            ->with('user.profile','status','lists.service','lists.status','lists.aesthetician','review')
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
        }else{
            $request->validate([
                'time' => 'required_if:role,==,book',
                'date' => 'required_if:role,==,book',
                'user_id' => 'required_if:role,==,Receptionist'
            ]);
            if($request->type == 'book'){
                $date = $request->date;
                $time = date('H:i:s', strtotime($request->time));
                $date = $date.' '.$time;
            }else{
                $date = now();
            }

            $check = Appointment::where('date',$date)->count();
            if($check > 0){
                $message = 'Date and time is already booked.';
                $data = [];
                $status = false;
            }else{
                $user_id = ($request->user_id) ? $request->user_id : \Auth::user()->id;
                $count = Appointment::count();
                $code = 'PP-'.date('Y').'-'.str_pad(($count+1), 5, '0', STR_PAD_LEFT);  
                $data = Appointment::create(array_merge($request->all(), ['code' => $code, 'user_id' => $user_id,'status_id' => 19, 'date' => $date]));
                $carts = $request->cart;
                foreach($carts as $cart){
                    $service = new AppointmentService;
                    $service->price = $cart['price'];
                    $service->service_id = $cart['id'];
                    $service->status_id = 19;
                    $service->appointment_id = $data->id;
                    $service->save();
                }
                
                $message = 'Appointment added successfully';
                $status = true;
            }
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
            
            $client = new Client();
            $result = $client->request('GET', 'http://gateway.onewaysms.ph:10001/api.aspx', [
                'query' => [
                    'apiusername' => 'APIJLHNMMIQBJ',
                    'apipassword' => 'APIJLHNMMIQBJJLHNM',
                    'senderid' => 'TEST',
                    'mobileno' => $mobile,
                    'message' => $content,
                    'languagetype' => 1
                ]
            ]);
            $response = json_decode($result->getBody()->getContents());
                // dd($response);
            return back()->with([
                'data' => $response,
                'message' => 'Message sent successfully.',
                'info' => '-',
                'status' => true,
            ]);
        }else if($request->option == 'Cancel'){
            $a = Appointment::findOrFail($request->id);
            $a->status_id = $request->status_id;
            $a->save();

            if($a){
                $data = AppointmentReason::create([
                    'appointment_id' => $request->id,
                    'reason' => $request->reason,
                    'user_id' => \Auth::user()->id
                ]);

                if($data){
                    $client = new Client();
                    $result = $client->request('GET', 'http://gateway.onewaysms.ph:10001/api.aspx', [
                        'query' => [
                            'apiusername' => 'APIJLHNMMIQBJ',
                            'apipassword' => 'APIJLHNMMIQBJJLHNM',
                            'senderid' => 'TEST',
                            'mobileno' => \Auth::user()->profile->mobile,
                            'message' => $request->reason,
                            'languagetype' => 1
                        ]
                    ]);
                    $response = json_decode($result->getBody()->getContents());

                    return back()->with([
                        'data' => '',
                        'message' => 'Appointment cancelled successfully.',
                        'info' => '-',
                        'status' => true,
                    ]);
                }
            }
        }else if($request->option == 'Confirm'){
            $a = Appointment::findOrFail($request->id);
            $a->status_id = $request->status_id;
            $a->save();

            if($a){
            
            $client = new Client();
            $result = $client->request('GET', 'http://gateway.onewaysms.ph:10001/api.aspx', [
                'query' => [
                    'apiusername' => 'APIJLHNMMIQBJ',
                    'apipassword' => 'APIJLHNMMIQBJJLHNM',
                    'senderid' => 'TEST',
                    'mobileno' => \Auth::user()->profile->mobile,
                    'message' => $request->reason,
                    'languagetype' => 1
                ]
            ]);
            $response = json_decode($result->getBody()->getContents());

            return back()->with([
                'data' => '',
                'message' => 'Appointment cancelled successfully.',
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
            $validatedData = $request->validate([
                'date' => 'required',
                'time' => 'required',
                'cart' => 'required',
            ]);

            
            $data = Appointment::findOrFail($request->id);
            $data->update($request->except('editable'));
            $data = Appointment::with('lists.service','lists.status','lists.aesthetician.specialist','lists.aesthetician.user.profile','user.profile','status')->where('id',$request->id)->first();
            
            return back()->with([
                'data' => $data,
                'message' => 'Appointment updated successfully.',
                'info' => '-',
                'status' => true,
            ]);
        }
    }

    public function reports($request){
        $current_year = $request->year; $years = []; 
        $laboratory = $request->laboratory;

        $programs = [
            ['name' => 'Completed Appointments', 'value' => 20],
            ['name' => 'Cancelled Appointments', 'value' => 21],
        ];
        $prog = []; 
        foreach($programs as $program){
            $data = []; $year = $current_year - 20;
            for($year; $year <= $current_year; $year++){
                $years[] = $year; $p = $program['value'];
                $data[] = Appointment::where('status_id',$p)->whereYear('created_at',$year)->count();
            }
            $arr[] = [
                'name' => $program['name'],
                'data' => $data  
            ];
            
        }

        return $y =[
            'categories' => $years,
            'lists' => $arr
        ];
    }

    public function ids($request){
        $lists = $request->lists;
        $ids = [];
        foreach ($lists as $item) {
            $ids[] = $item['id'];
        }

        $services = Service::whereNotIn('id',$ids)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'value' => $item->id,
                'name' => $item->service.' - '.$item->price,
                'service' => $item->service,
                'price' => $item->price
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
            Appointment::query()
            ->with('user.profile','status','lists.service','lists.status','lists.aesthetician.specialist','lists.aesthetician.user.profile','review')
            ->whereIn('status_id',[19,22,23])
            ->get()
        );

        return $data;
    }
    
}
