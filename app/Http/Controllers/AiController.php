<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
	
class AiController extends Controller
{	
    public $userId = "";
    public $cough = false;
    public $headache = false;
    public $soreThroat = false;
    public $ruq = false;
    public $luq = false;
    public $snoring = false;
    public $nasal = false;
	
	public function checkCough(){
        $data = DB::select('SELECT  distinct MONTH(`date`) as months from history where title like "%cough%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');

            if(count($data) >= 4){
                $cough = true;
            }
            //return response()->json(['message' => count($data)]);

		
    	$this->checkNasalCongestion();
    }

    public function checkNasalCongestion(){
//         Parameter = Nasal congestion
// 2. Nasal congestion 2-3 x / year
// R/o allergic rhinitis

        $data = DB::select('SELECT  * from history where title like "%nasal congestion%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');
           
            if(count($data) >= 3){
                $nasal = true;
            }
            //

    	$this->checkHeadache();
    }

    public function checkHeadache(){

//         Parameter =Headache
// 4. Headache 3 x / year
// R/o migraines, sinus headache, tumor


    	$data = DB::select('SELECT  * from history where title like "%headache%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');
           
            if(count($data) >= 3){
                $headache = true;
            }

    	$this->checkSoreThroat();

    }

    public function checkSoreThroat(){
//         Parameter = Sore throat 
// 3. Sore throat 2-3 x / year. R/o chronic tonsillitis 


        $data = DB::select('SELECT  * from history where title like "%sore throat%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');
           
            if(count($data) >= 3){
                $soreThroat = true;
            }


    	$this->checkRightUpperQuadrant();
    }

    public function checkRightUpperQuadrant(){
//         Parameter =Right Upper Quadrant pain
// 5. Right Upper Quadrant pain/ nausea 2x / year
// R/o Gallstones

        $data = DB::select('SELECT  * from history where title like "%right upper quadrant%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');
           
            if(count($data) >= 2){
                $ruq = true;
            }

    	$this->checkLeftUpperQuadrant();
    }

    public function checkLeftUpperQuadrant(){
//         Parameter=Left Upper Quadrant  pain/nausea
// 6. Left Upper Quadrant  pain/nausea >4x / year
// R/o Gastritis


        $data = DB::select('SELECT  * from history where title like "%left upper quadrant%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');
           
            if(count($data) >= 4){
                $luq = true;
            }

    	$this->checkSnoring();
    }

    public function checkSnoring(){
//         Parameter =Snoring
// 7. Snoring/ always 
// Sleep apnea 



        $data = DB::select('SELECT  * from history where title like "%snoring%" and userId = "'. $this->userId . '" and year = "' . date("Y") . '" ');
           
            if(count($data) >= 4){
                $snoring = true;
            }

    	$this->provideResults();
    }

    public function aiCheck(){
    	$this->checkCough();
    }

    public function provideResults(){
            $this->aiCheck();
            return response()->json([
                    'cough' => $cough,
                    'snoring' => $snoring,
                    'sore-throat' => $soreThroat,
                    'Left-upper-quadrant' => $luq,
                    'Right-upper-quadrant' => $ruq,
                    'nasal' => $nasal,
                    'headache' => $headache
            ]);
    }

    public function returnUserId(){
    	return Auth::guard('api')->user()->id;
    }

    public function returnTable(){
    	return 'history';
    }

    public function returnColumn(){
    	return 'title';
    }

}
