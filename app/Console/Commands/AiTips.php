<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class AiTips extends Command
{
    public $userId = "";
    public $cough = false;
    public $headache = false;
    public $soreThroat = false;
    public $ruq = false;
    public $luq = false;
    public $snoring = false;
    public $nasal = false;

    // $this->checkCough();
    //     $this->checkNasalCongestion();
    //     $this->checkHeadache();
    //     $this->checkSoreThroat();
    //     $this->checkRightUpperQuadrant();
    //     $this->checkLeftUpperQuadrant();

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aitips:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will check patient details';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->provideResults();
    }

    public function generateId($table, $column, $length){
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $id = "";
        for($i = 0; $i < $length; $i++){
            $id .= $characters[rand(0, (strlen($characters)) - 1)];
        }

        $data = DB::table($table)->where($column, $id)->get();

        if(count($data) > 0){
            $this->generateId($table, $column, $length);
        }else{
             return $id;
        }
       
    }


    public function checkCough(){
        $data = DB::select('SELECT  distinct MONTH(`date`) as months from history where title like "%cough%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');

            if(count($data) >= 1){
                $this->cough = true;
            }
            //return response()->json(['message' => count($data)]);

        
        $this->checkNasalCongestion();
    }

    public function checkNasalCongestion(){
//         Parameter = Nasal congestion
// 2. Nasal congestion 2-3 x / year
// R/o allergic rhinitis

        $data = DB::select('SELECT  * from history where title like "%nasal congestion%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');
           
            if(count($data) >= 1){
                $this->nasal = true;
            }
            //

        $this->checkHeadache();
    }

    public function checkHeadache(){

//         Parameter =Headache
// 4. Headache 3 x / year
// R/o migraines, sinus headache, tumor


        $data = DB::select('SELECT  * from history where title like "%headache%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');
           
            if(count($data) >= 1){
                $this->headache = true;
            }

        $this->checkSoreThroat();

    }

    public function checkSoreThroat(){
//         Parameter = Sore throat 
// 3. Sore throat 2-3 x / year. R/o chronic tonsillitis 


        $data = DB::select('SELECT  * from history where title like "%sore throat%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');
           
            if(count($data) >= 1){
                $this->soreThroat = true;
            }


        $this->checkRightUpperQuadrant();
    }

    public function checkRightUpperQuadrant(){
//         Parameter =Right Upper Quadrant pain
// 5. Right Upper Quadrant pain/ nausea 2x / year
// R/o Gallstones

        $data = DB::select('SELECT  * from history where title like "%right upper quadrant%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');
           
            if(count($data) >= 1){
                $this->ruq = true;
            }

        $this->checkLeftUpperQuadrant();
    }

    public function checkLeftUpperQuadrant(){
//         Parameter=Left Upper Quadrant  pain/nausea
// 6. Left Upper Quadrant  pain/nausea >4x / year
// R/o Gastritis


        $data = DB::select('SELECT  * from history where title like "%left upper quadrant%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');
           
            if(count($data) >= 1){
                $this->luq = true;
            }

        $this->checkSnoring();
    }

    public function checkSnoring(){
//         Parameter =Snoring
// 7. Snoring/ always 
// Sleep apnea 



        $data = DB::select('SELECT  * from history where title like "%snoring%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');
           
            if(count($data) >= 1){
                $this->snoring = true;
            }

       // $this->provideResults();
    }

    public function aiCheck(){
        $this->checkCough();
    }

    public function insertMessage($type, $title, $parameter, $frequency, $possibleDisorder){
        if($this->checkType($type) == 0){
                DB::table('messages')->insert([
                        'type' => $type,
                        'messageId' => $this->generateId('messages', 'messageId', 10) . time(),
                        'userId' => $this->userId,
                        'title' => $title,
                        'message' => 'MyHPI AI KEMi has noticed you had '.$parameter.' ' . $frequency .' and recommends you visit the doctor to be evaluated for '. $possibleDisorder . '',
                        'seen' => '0',
                        'date' => date('Y-m-d')
                ]);
            }
    }
         
    

    public function checkType($type){
        $messages = DB::table('messages')
        ->where('type', $type)
        ->where('userId', $this->userId)
        ->whereYear('date', '=', date('Y'))
        ->get();

        if(count($messages) > 0){
            return 1; 
        }else{
            return 0;
        }
    }



    public function provideResults(){
            

            $users = DB::table('users')->get();

            foreach($users as $user){
                $this->userId = $user->id;
                $this->aiCheck();

                if($this->cough == true){
                   $this->insertMessage(1, 'Persistent cough', 'cough', '4 or more times in 12 months', 'allergies, GERD, asthma');
                }

                if($this->nasal == true){
                   $this->insertMessage(2, 'Nasal congestion', 'nasal Congestion', '2-3 times this year', 'allergic rhinitis');
                }

                if($this->soreThroat == true){
                   $this->insertMessage(3, 'Sore Throat', 'sore throat', '2-3 times this year', 'chronic tonsillitis');
                }

                if($this->headache == true){
                   $this->insertMessage(4, 'Headache', 'headache', '3 times this year', 'sinus headache, tumor');
                }

                if($this->ruq == true){
                   $this->insertMessage(5, 'Right Upper Quadrant pain', 'right upper quadrant pain', '2 times this year', 'Gallstones');
                }

                if($this->luq == true){
                   $this->insertMessage(6, 'Left Upper Quadrant pain', 'left upper quadrant pain', '4 times this year', 'Gastritis');
                }

                if($this->snoring == true){
                   $this->insertMessage(7, 'Frequent Snoring', 'reported snoring', 'many times', 'Sleep apnea');
                }

                $this->cough = false;
                $this->headache = false;
                $this->soreThroat = false;
                $this->ruq = false;
                $this->luq = false;
                $this->snoring = false;
                $this->nasal = false;

                echo "Done";

            }
           
    }

    

}
