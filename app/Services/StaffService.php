<?php

namespace App\Services;

use App\Models\Log;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\SchoolCampus;
use Illuminate\Http\UploadedFile;
use App\Http\Resources\LogsResource;
use App\Http\Resources\Staff\IndexResource;

class StaffService
{
    public static function lists($request){
        $data = IndexResource::collection(
            User::query()
            ->with('profile.agency.region')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('profile',function ($query) use ($keyword) {
                    $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', "%{$keyword}%")
                    ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', "%{$keyword}%");
                })->orWhere(function ($query) use ($keyword) {
                    $query->where('username', 'LIKE', "%{$keyword}%")->whereNotIn('role',['Scholar','Administrator']);
                });
            })
            ->whereNotIn('role',['Scholar','Administrator'])
            ->paginate($request->counts)
        );
        return $data;
    }

    public function saveStaff($request){
        $password = rand(1000000000,9999999999);
        $data = User::create(array_merge($request->all(), ['password' => bcrypt($password), 'temp_password' => $password]));
        $data->profile()->create($request->all());
        $imagePath = $this->updateAvatar($request,$data->id);

        return new IndexResource($data);
    }

    public function editStaff($request){
        $data = User::findOrFail($request->id);
        $data->update($request->except('img','editable'));
        $profile = UserProfile::where('user_id',$request->id)->first();
        $profile->update($request->except('email','role','is_active','img','editable'));
        $imagePath = $this->updateAvatar($request,$data->id);
        $data = User::with('profile')->where('id',$request->id)->first();
        
       return new IndexResource($data);
    }

    public function verification($request){
        $data = User::findOrFail($request->id);
        $data->verify();
        return new IndexResource($data);
    }

    public static function token($request){
        $user = User::findOrFail($request->id);
        $user->tokens()->delete();
        $token = $user->createToken('kradworkz')->plainTextToken;
        return $token;
    }

    public static function revoke($request){
        $user = User::findOrFail($request->id);
        $user->tokens()->delete();
        return [
            'data' => '',
            'message' => 'User API Key revoked. Thanks',
            'type' => 'bx-mail-send'
        ];
    }

    public function logs($request){
        $data = Log::lists();
        return LogsResource::collection($data);
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
