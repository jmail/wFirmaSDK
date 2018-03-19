<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use WebzzMaster\WFirmaSdk\WFirmaClient;

class ConfigFileTest extends TestCase
{
    private $client;
    
    public function testNotExistingFile()
    {
        $this->expectExceptionMessage("wFirmaSDK is not properly configured - missing configuration file");
        $this->client = new WFirmaClient('some_npt_existing_file');
    }
    
    public function testNotExistingWFirmaKeyInFile()
    {
        $this->expectExceptionMessage("wFirmaSDK is not properly configured: missing configurations keys");
        $this->client = new WFirmaClient(__DIR__.'/../config/config_missing_key.yml');
    }
    
    public function testNotExistingUrlKeyInFile()
    {
        $this->expectExceptionMessage("wFirmaSDK is not properly configured: missing configurations key: url");
        $this->client = new WFirmaClient(__DIR__.'/../config/config_missing_key_1.yml');
    }
    
    public function testNotExistingAuthneticationKeyInFile()
    {
        $this->expectExceptionMessage(
            "wFirmaSDK is not properly configured: missing configurations key: authentication"
        );
        $this->client = new WFirmaClient(__DIR__.'/../config/config_missing_key_2.yml');
    }
    
    public function testNotExistingLoginKeyInFile()
    {
        $this->expectExceptionMessage("wFirmaSDK is not properly configured: missing configurations key: login");
        $this->client = new WFirmaClient(__DIR__.'/../config/config_missing_key_3.yml');
    }
    
    public function testNotExistingPasswordKeyInFile()
    {
        $this->expectExceptionMessage("wFirmaSDK is not properly configured: missing configurations key: password");
        $this->client = new WFirmaClient(__DIR__.'/../config/config_missing_key_4.yml');
    }
    
    public function testCorrectFile()
    {
        $this->client = new WFirmaClient(__DIR__.'/../config/config.yml');
        $this->assertTrue(true);
    }

    public function tearDown()
    {
        unset($this->client);
    }
}
