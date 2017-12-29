<?php

namespace dastanaron\spamchecker;

class SpamChecker {

    private $blacklist = [];

    public function __construct($path_to_list, $limit = 0) {

        $this->blacklist = file($path_to_list, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

        if ($limit > 0) {
            $this->blacklist = array_slice($this->blacklist, 0, $limit);
        }        

    }

    public function check($host) {

        $result = [
            "host" => $host,
            "blacklists" => [],
        ];

        $host_revert = join(".", array_reverse(explode(".", $host)));

        foreach ($this->blacklist as $dns) {

            $response = @dns_get_record($host_revert . '.' . $dns, DNS_TXT);

            if (!empty($response)) {

                $result["blacklists"][$dns] = $response;

            }

        }
        
        return $result;

    }
    
}
