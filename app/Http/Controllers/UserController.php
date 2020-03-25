<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Validator;
use App\User;


//use Illiminate\Support\Facades\Auth;
use Auth;
class UserController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            if(Auth::user()->verified == "no"){
                Auth::logout();
                return response()->json(['error' => 'User is not verified.'], 401);
            }else{
                $user = Auth::user();
                $success['user'] = Auth::user()->verified;
                $success['token'] = $user->createToken('kekeapp')->accessToken;
                return response()->json(['success' => $success],$this->successStatus);
            }

        }else{
            return response()->json(['error' => 'Logins Incorrect'], 401);
        }
    }




    public function register(Request $request){
       // $validator = Validator::make($request->all(), ['firstname' => 'required', 'lastname' => 'required', 'phone' => 'required|unique:users', 'email' => 'required|email|unique:users','password'=>'required',
       $validator = Validator::make($request->all(), ['firstname' => 'required', 'lastname' => 'required', 'phone' => 'required', 'email' => 'required|email|unique:users','password'=>'required',

        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 400);
        }

        $input = $request->all();
        $input['verified'] = "yes";
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = ($user->firstname)." ".($user->lastname);
        return response()->json(['success' => $success], $this->successStatus);


    }

    public function showLogin(){
        $failure['message'] = "Login incorrect";
        return response()->json(['error' => $failure], 401);
    }


    public function details(){
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }


    public function knowMore(Request $request){

        if($request->exists('image')){
            $image = base64_decode($request->image);
            $filename = $request->filename;

            $fileNameToStore = time().'_' . $filename;
            file_put_contents('storage/profile/'.$fileNameToStore, $image);



            DB::table('users')->where('email', $request->email)
            ->update(['gender' => $request->gender, 'race' => $request->race, 'dob' => $request->dob, 'city' => $request->city, 'state' => $request->state, 'country' => $request->country, 'profilePic' => $fileNameToStore]);

            return response()->json(['succes' => "done"],200);
        }else{
            DB::table('users')->where('email', $request->email)
            ->update(['gender' => $request->gender, 'race' => $request->race, 'dob' => $request->dob, 'city' => $request->city, 'state' => $request->state, 'country' => $request->country]);
            return response()->json(['succes' =>"done"],200);
        }

    }

    public function getUser(){
        return response()->json(['details' => Auth::user()], 200);
    }

    public function update(Request $request){
        $email = Auth::guard('api')->user()->email;

        if($request->exists('image')){
            $image = base64_decode($request->image);
            $filename = $request->filename;

            $fileNameToStore = time().'_' . $filename;
            file_put_contents('storage/profile/'.$fileNameToStore, $image);



            DB::table('users')->where('email', $email)
            ->update(['race' => $request->race, 'firstname' => $request->firstname, 'dob' => $request->dob, 'city' => $request->city, 'state' => $request->state, 'country' => $request->country, 'profilePic' => $fileNameToStore]);

            return response()->json(['succes' => "done"],200);
        }else{
            DB::table('users')->where('email', $email)
            ->update([ 'race' => $request->race, 'dob' => $request->dob, 'firstname' => $request->firstname, 'city' => $request->city, 'state' => $request->state, 'country' => $request->country]);
            return response()->json(['succes' =>"done"],200);
        }

    }

    public function getProfilePic(){
        if(Auth::guard('api')->check()){
        $filename = Auth::guard('api')->user()->profilePic;
        //$filename = auth('api')->user()->profilePic;
       // $filename = Auth::user()->profilePic;
        $musicFile = Storage::disk('local')->get('public/profile/' . $filename);
        $fileSize = Storage::disk('local')->size('public/profile/' . $filename);
        $start = 0;
        $end = $fileSize - 1;

        //return "yes";
        //return $fileSize;
        return response($musicFile)->withHeaders([
            'Accept-Ranges' => "bytes",
            'Accept-Encoding' => "gzip, deflate",
            'Pragma' => "public",
            'Expires' => '0',
            'Cache-Control' => 'must-revalidate',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition' => 'inline; filename=' . $filename,
            'Content-Length' => $fileSize,
            'Content-Type' => "image/jpeg",
            //'Content-Type' => "video/x-matroska",
            'Connection' => "Keep-Alive",
            'Content-Range' => 'bytes 0-' . $end ."/" . $fileSize,
            'X-Pad' => 'avoid browser bug',
            'Etag' => $filename
        ]);

       }
    }

    public function generateId(){
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $id = "";
        for($i = 0; $i < 10; $i++){
            $id .= $characters[rand(0, (strlen($characters)) - 1)];
        }

        return response()->json(['meter_code' => $id]);
    }
    public function placeholder(){

        //$filename = auth('api')->user()->profilePic;
       // $filename = Auth::user()->profilePic;
        $musicFile = Storage::disk('local')->get('public/profile/' . 'placeholder.jpg');
        $fileSize = Storage::disk('local')->size('public/profile/' . 'placeholder.jpg');
        $start = 0;
        $end = $fileSize - 1;

        //return "yes";
        //return $fileSize;
        return response($musicFile)->withHeaders([
            'Accept-Ranges' => "bytes",
            'Accept-Encoding' => "gzip, deflate",
            'Pragma' => "public",
            'Expires' => '0',
            'Cache-Control' => 'must-revalidate',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition' => 'inline; filename=' . 'placeholder.jpg',
            'Content-Length' => $fileSize,
            'Content-Type' => "image/jpeg",
            //'Content-Type' => "video/x-matroska",
            'Connection' => "Keep-Alive",
            'Content-Range' => 'bytes 0-' . $end ."/" . $fileSize,
            'X-Pad' => 'avoid browser bug',
            'Etag' => 'placeholder.jpg'
        ]);


    }

}
