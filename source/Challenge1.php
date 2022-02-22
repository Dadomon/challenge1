<?php

class Challenge1 
{

    private $resource;
    private $backgroundTask;
    private $foregroundTask; 
    private $fileContent;
    private $fileContentOut;
  
    public function __construct() {
        $this->path = dirname(__FILE__);
        $this->fileIn = "$this->path/storage/fileIn/challenge.in";
        $this->fileOut = "$this->path/storage/fileOut/challenge.out";
        $this->mainProcess();
    }

    public function mainProcess(){

        $this->readFile();
        $this->setData();
        $this->optimalConfiguration();
        $this->saveFile();
        
    }

    private function setData(){

        $this->resource = $this->fileContent[0];
        $this->foregroundTask = $this->fileContent[1];
        $this->backgroundTask = $this->fileContent[2];

    }

    private function readFile(){

        $text = file($this->fileIn);
        $this->fileContent = $text;

    }

    public function optimalConfiguration(){

        $resoure = $this->resource;

        $strFore = $this->foregroundTask;
        $strFore = str_replace(" ", "", $strFore);

        $arFore = str_split($strFore, 6);
        $processFore = count($arFore);

        $strBack = $this->backgroundTask;
        $strBack = str_replace(" ", "", $strBack);
        $arBack = str_split($strBack, 6);
        $processBack = count($arBack);

        $optimalOut = array();
        $max = 0;

        foreach($arBack as $data) {
            foreach($arFore as $data2) {
            
            $dataFore = self::string_between_two_string($data2, "(", ")");
            $dataBack = self::string_between_two_string($data, "(", ")");
            
             $op = substr($dataBack, 2) + substr($dataFore, 2);
             if ($op == $resoure) {
                  $max = $op;
                  $optimalOut = array_merge($optimalOut,  ["(" .substr($dataFore, 0,1) ."," . substr($dataBack, 0,1) . ")"] );
  
              }elseif($op < $resoure) {
              
                  if($max < $op  ){
                 
                      $max = $op;
                         $optimalOut = [];
                  $optimalOut = array_merge($optimalOut,  ["(" .substr($dataFore, 0,1) ."," . substr($dataBack, 0,1) . ")"] );
                                         
  
                  }elseif($max == $op) {
                  
                  $optimalOut = array_merge($optimalOut,  ["(" .substr($dataFore, 0,1) ."," . substr($dataBack, 0,1) . ")"] );
                  }
  
              }     	

            }
        }
            $this->fileContentOut = $optimalOut;
    }

    public function saveFile (){

        if (file_exists($this->fileOut)) {
            unlink($this->fileOut);
        }

        touch($this->fileOut);

        foreach ($this->fileContentOut as $key => $value) {
            
            file_put_contents($this->fileOut, $value, FILE_APPEND | LOCK_EX);

        }
    }

    public static function  string_between_two_string($str, $starting_word, $ending_word){
        $arr = explode($starting_word, $str);
        if (isset($arr[1])){
            $arr = explode($ending_word, $arr[1]);
            return $arr[0];
        }
    }

}

new Challenge1;

