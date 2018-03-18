<?php
namespace WebzzMaster\WFirmaSdk;

use Exception;
use Symfony\Component\Yaml\Yaml;
use WebzzMaster\WFirmaSdk\Components\ConfigParser;
use WebzzMaster\WFirmaSdk\Services\{
    Companies,
    CompanyAccounts,
    CompanyPacks,
    Contractors,
    DeclarationCountries,
    Documents,
    Expenses,
    Goods,
    InvoiceDeliveries,
    InvoiceDescriptions,
    Invoicecontents,
    Invoices,
    Notes,
    PaymentCashboxes,
    Payments,
    Series,
    StaffCalendarWorkAbsences,
    StaffEmployees,
    Tags,
    TermGroups,
    Terms,
    TranslationLanguages,
    UserCompanies,
    Users,
    VatCodes,
    VatContents,
    VatMossDetails,
    Warehouses,
    Webhooks
};

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
