<?php


namespace DMCard\Request;


use App\Controller\Component\EcommerceLogger\EcommerceLogger;
use DMCard\Environment;
use DMCard\Sale;
use DMCard\Merchant;
use Cake\Utility\Inflector;

class CreateSaleRequest extends AbstractRequest
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

        parent::__construct($merchant, new EcommerceLogger('dmcard_' . Inflector::underscore(end($name)) . '.log'));

        $this->environment = $environment;
    }

    public function execute($sale)
    {
        $url = $this->environment->getApiUrl() . '/Transactions';

        return $this->sendRequest('POST', $url, $sale);
    }

    protected function unserialize($json)
    {
        return Sale::fromJson($json);
    }
}
