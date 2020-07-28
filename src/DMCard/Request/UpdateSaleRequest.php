<?php


namespace DMCard\Request;

use App\Controller\Component\EcommerceLogger\EcommerceLogger;
use DMCard\Environment;
use DMCard\SaleCapture;
use DMCard\Merchant;
use Cake\Utility\Inflector;

class UpdateSaleRequest extends AbstractRequest
{
    private $environment;

    /**
     * CreateSaleRequest constructor.
     * @param Merchant $merchant
     * @param Environment $environment
     */
    public function __construct(Merchant $merchant, Environment $environment)
    {
        $name = explode('\\', get_class());

        parent::__construct($merchant, new EcommerceLogger('dmcard_'. Inflector::underscore(end($name)) . '.log'));

        $this->environment = $environment;
    }

    public function execute($saleCapture)
    {
        $url = $this->environment->getApiUrl() . '/Transactions/Captures';

        return $this->sendRequest('POST', $url, $saleCapture);
    }

    protected function unserialize($json)
    {
        return SaleCapture::fromJson($json);
    }
}
