<?php

namespace dastanaron\spamipcheck;

class CheckIP {
    
    public $ip;
    public $revert_ip;
    public $limit;
    public $blacklist;
    
    public function __construct(IPList $iplist, $ip, $limit = 10) 
    {
        $this->buildObject($iplist, $ip, $limit);
    }
    
    private function buildObject($iplist, $ip, $limit)
    {
        
        $this->blacklist = $iplist->blacklist;
        $this->ip = $ip;
        $this->limit = $limit;
        
        if(!empty($this->limit)) {
             $this->blacklist = $this->LimitList();
        }        
        
        $this->revert_ip = $this->IPRevert($this->ip);
        
    }
    
    
    private function LimitList()
    {
        $array = [];
        for($i=0; $i<$this->limit; $i++) {
            $array[$i] = $this->blacklist[$i];
        }
        
        return $array;
    }
    
    public static function getInstance(IPList $iplist, $ip, $limit = 10)
    {
        return new CheckIP($iplist, $ip, $limit);
    }
    
    public function IPRevert($ip)
    {
        $arr_ip = explode('.', $ip);

        return $arr_ip[3].'.'.$arr_ip[2].'.'.$arr_ip[1].'.'.$arr_ip[0];
    }
    
    public function Request()
    {
        $array = [];
        $answer = array();
        foreach($this->blacklist as $dns) {
             $answer = dns_get_record($this->revert_ip.'.'.$dns, DNS_TXT);
             if(!empty($answer)) {
                 $array['ip'] = $this->ip;
                 $array['blacklist'][] = $dns;
                 $array['answer'][] = $answer;
             }
        }
        
        return $array;
    }
    
}
