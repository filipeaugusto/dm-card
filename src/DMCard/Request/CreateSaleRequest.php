<?php


namespace DMCard\Request;

use DMCard\Environment;
use DMCard\Sale;
use DMCard\Merchant;

class CreateSaleRequest extends AbstractRequest
{
    private $environment;

    /**
     * CreateSaleRequest constructor.
     * @param Merchant $merchant
     * @param Environment $environment
     */
    public function __construct(Merchant $merchant, Environment $environment, LoggerInterface $logger = null)
    {
 
        parent::__construct($merchant, $logger);

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
