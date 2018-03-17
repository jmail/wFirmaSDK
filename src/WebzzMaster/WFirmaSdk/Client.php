<?php
namespace WebzzMaster\WFirmaSdk;

use Symfony\Component\Yaml\Yaml;
use WebzzMaster\WFirmaSdk\Components\ConfigParser;
use WebzzMaster\WFirmaSDK\Services\{
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
class Client
{
    /**
     * @var ConfigParser
     */
    private $configParser;

    public function __construct(string $configFile = __DIR__ . '/../../../config/config.yml')
    {
        if(!file_exists($configFile)){
            throw new Exception("wFirmaSDK is not properly configured - missing configuration file");
        }
        
        $this->configParser = new ConfigParser();
        $this->configParser->parse(Yaml::parseFile($configFile));
        
        if (!isset($parsedYamlConfig['webzzmaster']['wfirmasdk'])) {
            throw new Exception("wFirmaSDK is not properly configured - missing WebzzMaster\WFirmaSdk config path");
        }

        $this->service = new $parsedYamlConfig['microservices'][$microservice]['class']($parsedYamlConfig, $authToken);
    }

    private function setConfig($parsedYamlConfig)
    {
        if (!isset($parsedYamlConfig['webzzmaster']['wfirmasdk'])) {
            throw new Exception("wFirmaSDK is not properly configured - missing WebzzMaster\WFirmaSdk config path");
        }
    }
}
