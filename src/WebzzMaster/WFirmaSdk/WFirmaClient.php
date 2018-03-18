<?php
namespace WebzzMaster\WFirmaSdk;

use Exception;
use Symfony\Component\Yaml\Yaml;
use WebzzMaster\WFirmaSdk\Components\ConfigParser;
use WebzzMaster\WFirmaSdk\Services\Companies;
use WebzzMaster\WFirmaSdk\Services\CompanyAccounts;
use WebzzMaster\WFirmaSdk\Services\CompanyPacks;
use WebzzMaster\WFirmaSdk\Services\Contractors;
use WebzzMaster\WFirmaSdk\Services\DeclarationCountries;
use WebzzMaster\WFirmaSdk\Services\Documents;
use WebzzMaster\WFirmaSdk\Services\Expenses;
use WebzzMaster\WFirmaSdk\Services\Goods;
use WebzzMaster\WFirmaSdk\Services\InvoiceDeliveries;
use WebzzMaster\WFirmaSdk\Services\InvoiceDescriptions;
use WebzzMaster\WFirmaSdk\Services\Invoicecontents;
use WebzzMaster\WFirmaSdk\Services\Invoices;
use WebzzMaster\WFirmaSdk\Services\Notes;
use WebzzMaster\WFirmaSdk\Services\PaymentCashboxes;
use WebzzMaster\WFirmaSdk\Services\Payments;
use WebzzMaster\WFirmaSdk\Services\Series;
use WebzzMaster\WFirmaSdk\Services\StaffCalendarWorkAbsences;
use WebzzMaster\WFirmaSdk\Services\StaffEmployees;
use WebzzMaster\WFirmaSdk\Services\Tags;
use WebzzMaster\WFirmaSdk\Services\TermGroups;
use WebzzMaster\WFirmaSdk\Services\Terms;
use WebzzMaster\WFirmaSdk\Services\TranslationLanguages;
use WebzzMaster\WFirmaSdk\Services\UserCompanies;
use WebzzMaster\WFirmaSdk\Services\Users;
use WebzzMaster\WFirmaSdk\Services\VatCodes;
use WebzzMaster\WFirmaSdk\Services\VatContents;
use WebzzMaster\WFirmaSdk\Services\VatMossDetails;
use WebzzMaster\WFirmaSdk\Services\Warehouses;
use WebzzMaster\WFirmaSdk\Services\Webhooks;

/**
 * Description of Client
 *
 * @author jmail <jarek@webzzmaster.com>
 */
class WFirmaClient
{
    /**
     * @var ConfigParser
     */
    private $configParser;

    public function __construct(string $configFile = __DIR__ . '/../../../config/config.yml')
    {
        if (!file_exists($configFile)) {
            throw new Exception("wFirmaSDK is not properly configured - missing configuration file");
        }

        $this->configParser = new ConfigParser();
        $this->configParser->parse(Yaml::parseFile($configFile));
    }
    
    public function __call(string $name, array $arguments)
    {
        $moduleName = 'WebzzMaster\\WFirmaSdk\\Services\\'.str_replace('_', '', ucwords($name, '_'));
        
        if (!class_exists($moduleName)) {
            throw new Exception("wFirmaSDK: Module " . $moduleName . " does not exist");
        }

        if (!property_exists($this, $name)) {
            $this->$name = new $moduleName($this->configParser);
        }
        
        return $this->$name;
    }
}
