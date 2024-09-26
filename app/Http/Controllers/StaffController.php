<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\DropdownResource;
use App\Http\Requests\StaffRequest;

class StaffController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            default: 
                return inertia('Modules/Staffs/Index');
        }
    }

    public function lists($request){
        $data = DefaultResource::collection(
            User::query()
            ->with('profile')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('profile',function ($query) use ($keyword) {
                    $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', "%{$keyword}%")
                    ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', "%{$keyword}%");
                })->orWhere(function ($query) use ($keyword) {
                    $query->where('username', 'LIKE', "%{$keyword}%")->whereNotIn('role',['Administrator']);
                });
            })
            ->when($request->role, function ($query, $role) {
                $query->where('role',$role);
            })
            ->whereIn('role',['Staff','Owner','Receptionist'])
            ->paginate($request->counts)
        );
        return $data;
    }

    public function store(StaffRequest $request){

        
        $password = $request->password;
        $data = User::create(array_merge($request->all(), ['password' => bcrypt($password),'is_active' => 1]));
        $data->profile()->create($request->all());
        $imagePath = $this->updateAvatar($request,$data->id);

        return back()->with([
            'data' => $data,
            'message' => 'Staff added successfully.',
            'info' => '-',
            'status' => true,
        ]);
    }

    public function update(Request $request){
        $data = User::findOrFail($request->id);
        $data->update($request->except('img','editable'));
        $profile = UserProfile::where('user_id',$request->id)->first();
        $profile->update($request->except('email','role','is_active','img','editable'));
        $imagePath = $this->updateAvatar($request,$data->id);
        $data = User::with('profile')->where('id',$request->id)->first();
        
        return back()->with([
            'data' => $data,
            'message' => 'Staff updated successfully.',
            'info' => '-',
            'status' => true,
        ]);
    }

    public function updateAvatar($request, $id)
    {
        if($request->img != ''){
            $data = $request->img;
            $img = explode(',', $data);
            $ini =substr($img[0], 11);
            $type = explode(';', $ini);
            if($type[0] == 'png'){
                $image = str_replace('data:image/png;base64,', '', $data);
            }else{
                $image = str_replace('data:image/jpeg;base64,', '', $data);
            }
            $image = str_replace(' ', '+', $image);
            $imageName = $request->username.'.'.$type[0];
            
            if(\File::put(public_path('imagess/avatars'). '/' . $imageName, base64_decode($image))){
                $data = User::findOrFail($id);
                $data->avatar = $imageName;
                $data->save();
            }
        }
    }
}
