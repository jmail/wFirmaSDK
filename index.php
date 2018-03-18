<?php

require_once './vendor/autoload.php';

use WebzzMaster\WFirmaSdk\WFirmaClient;

$wFirmaClient = new WFirmaClient();

$wFirmaClient->companies()->get();
