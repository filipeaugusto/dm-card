<?php


namespace DMCard\Request;

use DMCard\Environment;
use DMCard\SaleCapture;
use DMCard\Merchant;
use Psr\Log\LoggerInterface;

class UpdateSaleRequest extends AbstractRequest
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
