<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Validator;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;


//use Illiminate\Support\Facades\Auth;
use Auth;
class UserController extends Controller
{


    public $successStatus = 200;

    public function check(){
            
}

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
        if($filename != ""){
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
        }else{
            return response()->json(['message'=>'No profile picture'], 404);
        }
        

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


    public function history(){
        //$userId = Auth::guard('api')->user()->id;
        if(Auth::guard('api')->check()){
            $userId = Auth::guard('api')->user()->id;
            $historyByDate = DB::table('history')
            ->select('year')
            ->distinct()
            ->where('userId', $userId)
            ->latest('date')->get();
           
            $historyJson = [];
            foreach($historyByDate as $hist){
                $history = DB::table('history')->where('year', $hist->year)->where('userId', $userId)->get();

                array_push($historyJson, [
                                            'year' => $hist->year,
                                            'history' => $history
                                        ]);


            }
            $historyJson = (array) $historyJson;

            return response()->json(json_decode(json_encode($historyJson)), 200);
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function deleteHistory($id){
        //$userId = Auth::guard('api')->user()->id;
        if(Auth::guard('api')->check()){
            $userId = Auth::guard('api')->user()->id;
            $history = DB::table('history')
            ->where('userId', $userId)
            ->where('historyId', $id)
            ->delete();

            return response()->json(['message' => 'Done'], 200);
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function generateNewId($table, $column, $length){
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $id = "";
        for($i = 0; $i < $length; $i++){
            $id .= $characters[rand(0, (strlen($characters)) - 1)];
        }

        $history = DB::table($table)->where($column, $id)->get();
        if(count($history) == 0){
            return $id;
        }else{
            return $this->generateNewId($table, $column, $length);
        }
        
    }


    public function addHistory(Request $request){
        $title = $request->title;
        $bodyPart = $request->bodyPart;
        $duration = $request->duration;
        $description = $request->description;
        $severity = $request->severity;
        $additionalInfo = $request->additionalInfo;
        $date = date('Y-m-d');
        $year = date('Y');
        $historyId = $this->generateNewId('history', 'historyId', 10);

        if(Auth::guard('api')->check()){
            $userId = Auth::guard('api')->user()->id;
            DB::table('history')->insert([
                                            'userId' => $userId,
                                            'historyId' =>$historyId,
                                            'title' => $title,
                                            'bodyParts' => $bodyPart,
                                            'duration' => $duration,
                                            'description' => $description,
                                            'severity' => $severity,
                                            'year' => $year,
                                            'date' => $date,
                                            'additionalInfo' => $additionalInfo,

            ]);      

            return response()->json(['message' => 'Done'], 200);

        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function deleteMultipleHistory($id){
        //$userId = Auth::guard('api')->user()->id;
        if(Auth::guard('api')->check()){
            $userId = Auth::guard('api')->user()->id;
            $id = explode(",", $id);
            for($i = 0; $i < sizeof($id); $i++){
                $history = DB::table('history')
                ->where('userId', $userId)
                ->where('historyId', $id[$i])
                ->delete();
            }
            

            return response()->json(['message' => 'Done'], 200);
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    public function getHistory($id){
        //$userId = Auth::guard('api')->user()->id;
        if(Auth::guard('api')->check()){
            $userId = Auth::guard('api')->user()->id;
            $history = DB::table('history')
            ->where('userId', $userId)
            ->where('historyId', $id)
            ->get();

            return response()->json(json_decode(json_encode($history)), 200);
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function doctorVisit(){
        if(Auth::guard('api')->check()){
            $userId = Auth::guard('api')->user()->id;
            $historyByDate = DB::table('history')
            ->select('year')
            ->distinct()
            ->where('userId', $userId)
            ->latest('date')->get();
           
            $historyJson = [];
            if(count($historyByDate) > 0){
            foreach($historyByDate as $hist){
                //$history = DB::table('history')->where('year', $hist->year)->where('userId', $userId)->get();

                if($hist->year == date('Y')){
                    array_push($historyJson, 'This year');
                }else{
                    array_push($historyJson, $hist->year);
  
                }
                

            }
            }else{
                array_push($historyJson, 'This year'); 
            }
            $historyJson = (array) $historyJson;

            return response()->json(json_decode(json_encode($historyJson)), 200);

        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function doctorVisitData($id){
        if(Auth::guard('api')->check()){
            $userId = Auth::guard('api')->user()->id;
            /*$historyByDate = DB::table('history')
            ->where('userId', $userId)
            ->where('year', $id == 'This year' ? date('Y') : $id)
            ->get();
            return date('M', strtotime('2020-09-20'));*/

            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $monthInFig = ['01','02','03','04','05','06','07','08','09','10','11','12'];
            $historyJson = [];
            for($i = 0; $i < sizeof($months); $i++){
                $dataCount = DB::table('history')
                ->where('userId', $userId)
                ->where('year', $id == 'This year' ? date('Y') : $id)
                ->whereMonth('date', '=', $monthInFig[$i])
                ->count();
                array_push($historyJson, [
                    $months[$i],
                    $dataCount 

                ]);                            

            }
            $historyJson = (array) $historyJson;

            return response()->json(json_decode(json_encode($historyJson)), 200);
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function changePassword(Request $request){
        
        $validator = Validator::make($request->all(), ['email' => 'required', 'code' => 'required', 'password'=>'required', 'password_confirmation' => 'required'

        ]);

        $check = DB::table('password_resets')
        ->where('email', $request->email)
        ->where('verificationCode', $request->code)
        ->first();

        if(!empty($check)){
            if(time() > strtotime($check->expires_at)){
                return response()->json(['message' => 'Token Expired'], 498);
            }else{

                DB::table('users')
                ->where('email', $request->email)
                ->update(['password' => bcrypt($request->password)]);

                DB::table('password_resets')->where('email', $request->email)->delete();

                return response()->json(['message' => 'Successfully updated'], 200);
            }
            
        }else{
            return response()->json(['message' => 'wrong code'], 401);
        }



           
        return 'Email was sent';
    }

    public function verifyCode(Request $request){
        $check = DB::table('password_resets')
        ->where('email', $request->email)
        ->where('verificationCode', $request->code)
        ->first();

        if(!empty($check)){
            if(time() > strtotime($check->expires_at)){
                return response()->json(['message' => 'Token Expired'], 498);
            }else{
                return response()->json(['message' => 'verification successful'], 200);
            }
            
        }else{
            return response()->json(['message' => 'wrong code'], 401);
        }


    }



    public function forgotPassword($id){
        $user = DB::table('users')->where('email', $id)->first();
        if(!empty($user)){
            $email = $id;
            $name = $user->firstname;
            $code = rand(10000, 999999);
            $date = date('Y-m-d H:i:s');

            //$datePlusFive = new DateTime($date);
            $datePlusFive = strtotime($date.' + 5 minute');
            $datePlusFive = date('Y-m-d H:i:s', $datePlusFive);

            $checkIfExists = DB::table('password_resets')
            ->where('email', $id)
            ->first();

            if(!empty($checkIfExists)){
                DB::table('password_resets')
                ->where('email', $id)
                ->update([
                    'verificationCode' => $code,
                    'created_at' => $date,
                    'expires_at' => $datePlusFive
                ]);
            }else{
                DB::table('password_resets')
                ->insert([
                    'userId' => $user->id,
                    'email' => $email,
                    'verificationCode' => $code,
                    'created_at' => $date,
                    'expires_at' => $datePlusFive
                ]);
            }

            
            
            Mail::to($email)->send(new SendMailable($name, $email, $code));
            return response()->json(['message' => 'verification successful'], 200);
        }else{
            return response()->json(['message' => 'Email does not exist'], 401);
        }
    }

}
