<?php
namespace WebzzMaster\WFirmaSdk\Components;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

/**
 * Description of ConfigParser
 *
 * @author jmail <jarek@webzzmaster.com>
 */
class ConfigParser
{

    private $validator;
    protected $apiUrl;
    protected $username;
    protected $password;
    protected $authentication;
    protected $consumerKey;
    protected $consumerSecret;

    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }

    private function generateViolationsMessage($violations)
    {
        $message = '';
        foreach ($violations as $violation) {
            $message .= $violation->getMessage() . '; ';
        }
    }
    
    protected function extractApiUrl(array $config)
    {
        if (!isset($config['webzzmaster']['wfirmasdk']['url'])) {
            throw new Exception(
                "wFirmaSDK is not properly configured: missing configurations key: url"
            );
        }
        $this->setApiUrl($config['webzzmaster']['wfirmasdk']['url']);
    }
    
    protected function extractAuthentication(array $config)
    {
        if (!isset($config['webzzmaster']['wfirmasdk']['authentication'])) {
            throw new Exception(
                "wFirmaSDK is not properly configured: missing configurations key: authentication"
            );
        }
        $this->setAuthentication($config['webzzmaster']['wfirmasdk']['authentication']);
    }
    
    protected function extractConsumerKey(array $config)
    {
        if (!isset($config['webzzmaster']['wfirmasdk']['consumer_key'])) {
            throw new Exception(
                "wFirmaSDK is not properly configured: missing configurations key: consumer_key"
            );
        }
        $this->setConsumerKey($config['webzzmaster']['wfirmasdk']['consumer_key']);
    }
    
    protected function extractConsumerSecret(array $config)
    {
        if (!isset($config['webzzmaster']['wfirmasdk']['consumer_secret'])) {
            throw new Exception(
                "wFirmaSDK is not properly configured: missing configurations key: consumer_secret"
            );
        }
        $this->setConsumerSecret($config['webzzmaster']['wfirmasdk']['consumer_secret']);
    }
    
    protected function extractPassword(array $config)
    {
        if (!isset($config['webzzmaster']['wfirmasdk']['password'])) {
            throw new Exception(
                "wFirmaSDK is not properly configured: missing configurations key: password"
            );
        }
        $this->setPassword($config['webzzmaster']['wfirmasdk']['password']);
    }
    
    protected function extractUsername(array $config)
    {
        if (!isset($config['webzzmaster']['wfirmasdk']['login'])) {
            throw new Exception(
                "wFirmaSDK is not properly configured: missing configurations key: login"
            );
        }
        $this->setUsername($config['webzzmaster']['wfirmasdk']['login']);
    }
    
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    public function getAuthentication()
    {
        return $this->authentication;
    }
    
    public function getConsumerKey()
    {
        return $this->consumerKey;
    }

    public function getConsumerSecret()
    {
        return $this->consumerSecret;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function parse(array $config)
    {
        if (!isset($config['webzzmaster']['wfirmasdk'])) {
            throw new Exception(
                "wFirmaSDK is not properly configured: missing configurations keys"
            );
        }
        
        $this->extractApiUrl($config);        
        $this->extractAuthentication($config);
        
        if($config['webzzmaster']['wfirmasdk']['authentication'] === 'basic'){
            $this->extractUsername($config);
            $this->extractPassword($config);
        }
        
        if($config['webzzmaster']['wfirmasdk']['authentication'] === 'oauth'){
            
        }
        
    }
    
    public function setApiUrl(string $url)
    {
        $violations = $this->validator->validate(
            $url,
            [
                new Url(),
                new NotBlank(),
            ]
        );

        if (0 !== count($violations)) {
            throw new Exception(
                "wFirmaSDK is not properly configured - ".$this->generateViolationsMessage($violations)
            );
        }
    }

    public function setAuthentication(string $authentication)
    {
        $violations = $this->validator->validate(
            $authentication,
            [
                new Choice(['basic', 'oauth']),
                new NotBlank(),
            ]
        );

        if (0 !== count($violations)) {
            throw new Exception(
                "wFirmaSDK is not properly configured - ".$this->generateViolationsMessage($violations)
            );
        }
        
        if($authentication === 'oauth'){
            throw new Exception(
                "wFirmaSDK: oAuth method will be available in future version"
            );
        }
    }

    public function setConsumerKey(string $consumerKey)
    {
        $violations = $this->validator->validate(
            $consumerKey,
            [
                new NotBlank(),
            ]
        );

        if (0 !== count($violations)) {
            throw new Exception(
                "wFirmaSDK is not properly configured - ".$this->generateViolationsMessage($violations)
            );
        }
    }
    
    public function setConsumerSecret(string $consumerSecret)
    {
        $violations = $this->validator->validate(
            $consumerSecret,
            [
                new NotBlank(),
            ]
        );

        if (0 !== count($violations)) {
            throw new Exception(
                "wFirmaSDK is not properly configured - ".$this->generateViolationsMessage($violations)
            );
        }
    }
    
    public function setPassword(string $password)
    {
        $violations = $this->validator->validate(
            $password,
            [
                new NotBlank(),
            ]
        );

        if (0 !== count($violations)) {
            throw new Exception(
                "wFirmaSDK is not properly configured - ".$this->generateViolationsMessage($violations)
            );
        }
    }
    
    public function setUsername(string $username)
    {
        $violations = $this->validator->validate(
            $username,
            [
                new NotBlank(),
            ]
        );

        if (0 !== count($violations)) {
            throw new Exception(
                "wFirmaSDK is not properly configured - ".$this->generateViolationsMessage($violations)
            );
        }
    }
}
