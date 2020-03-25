<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Encrypter extends Controller
{
    //
    public function convertToBinary($value){
        $whole = "";
        $remainders = [];
        $main = $value;
        while($main > 0){
            array_push($remainders, ($main % 2));
            $main = floor($main / 2);
        }

        $remainders = array_reverse($remainders);
        for($i = 0; $i<sizeof($remainders); $i++){
            $whole .=   $remainders[$i];
        }
        return $whole;

    }

    public function binaryToDec($value){
        $digits = 0;
        $index = 0;
        for($i = (strlen($value)) - 1; $i >= 0; $i--){
            $character = $value[$index];
            //digits = 2^2;
            $digits += ($character * pow(2,$i));
            $index += 1;
        }
        return $digits;
    }

    public function appendZeros($binary){
        if(strlen($binary) == 1){
            $binary = "000000".$binary;
          }else if(strlen($binary) == 2){
            $binary = "00000".$binary;
          }
          else if(strlen($binary) == 3){
            $binary = "0000".$binary;
          }
          else if(strlen($binary) == 4){
            $binary = "000".$binary;
          }
          else if(strlen($binary) == 5){
            $binary = "00".$binary;
          }
          else if(strlen($binary) == 6){
            $binary = "0".$binary;
          }

          return $binary;
    }

    public function generate9000(){

            $the9000 = "";
            for($i = 0; $i < 9000; $i++){
              $the9000 .= (rand(0,1));
            }

            return $the9000;


    }

    public function encode($value){
        $ascii = null;
        $binary = null;
        $binaryWhole = "";

        for($i = 0; $i < strlen($value); $i++){
            $ascii = ord($value[$i]); //gets the ascii value of the character
            $binary = $this->convertToBinary($ascii); //converts the ascii value to binary
            $binary = $this->appendZeros($binary);
            $binaryWhole .= $binary; //concatenates all the binaries together
        }
        //return binaryWhole;
        $binaryWhole = $this->generate9000().$binaryWhole;
        $binaryWhole = $binaryWhole.$this->generate9000();
        return $binaryWhole;
    }

    public function test(){
        return $this->encode("Yes. I am getting what I want.");
      }
      public function decode($value){
          //$value = $this->test();
          $fullString = "";
          $theMain = "";
          for($i = 9000; $i < strlen($value) && $i < (strlen($value) - 9000); $i++){
              $theMain .= $value[$i];
          }

          $firstIndex = 0;
          $secondIndex = 6;
          while($firstIndex < strlen($theMain)){
            $oneLetter = "";
            for($i = $firstIndex; $i <= $secondIndex; $i++){
              $oneLetter .= $theMain[$i];
            }
            //return oneLetter;
            $fullString .= chr($this->binaryToDec($oneLetter));
            $firstIndex += 7;
            $secondIndex += 7;

          }
          //1111001
          //1100101
          //1110011
          return $fullString;
      }


}
