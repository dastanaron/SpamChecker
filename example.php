<?php

use dastanaron\spamchecker\SpamChecker;

$checker = new SpamChecker('blacklist.txt', 5);

// Example clean address
var_dump($checker->check("mail.ru"));

// Example spam address
var_dump($checker->check("182.244.194.17"));
