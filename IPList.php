<?php

namespace dastanaron\spamipcheck;

class IPList {
    
    public $blacklist = array();
        
    
    public function __construct()
    {
        $list = file_get_contents( __DIR__.'/blacklist.txt');
        $this->blacklist($list);
    }
    
    public static function getInstance()
    {
        return new IPList();
    }
    
    
    private function blacklist($list)
    {
        if($this->BuildArrayList($list)) {
            return true; 
        }
        else {
            return false;
        }
    }
    
    private function BuildArrayList($list)
    {
        $this->blacklist = explode(PHP_EOL, $list);
        
        $this->blacklist = $this->strip_space($this->blacklist);
        
        if(is_array($this->array_list)) {
            return true;
        }
        else {
            return false;
        }
        
    }
    
    private function strip_space($data)
    {
        
        if(is_array($data)) {
            $new_array = [];
            foreach ($data as $elem) {
                if(!empty($elem)) {
                    $new_array[] = trim($elem);
                }
            }
            return $new_array;
        }
        
        return trim($new_array);
        
    }
    
}
