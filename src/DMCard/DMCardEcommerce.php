<?php


namespace DMCard;


use DMCard\Request\CreateSaleRequest;
use DMCard\Request\UpdateSaleRequest;
use DMCard\Merchant;

class DMCardEcommerce
{
    private $merchant;
    private $environment;

    /**
     * DMCardEcommerce constructor.
     * @param $merchant
     * @param $environment
     */
    public function __construct(Merchant $merchant, Environment $environment = null)
    {
        if ($environment == null) {
            $environment = Environment::production();
        }

        $this->merchant = $merchant;
        $this->environment = $environment;
    }

    public function createSale(Sale $sale)
    {
        $createSaleRequest = new CreateSaleRequest($this->merchant, $this->environment);

        return $createSaleRequest->execute($sale);
    }

    public function captureSale(SaleCapture $saleCapture)
    {
        $createSaleRequest = new UpdateSaleRequest($this->merchant, $this->environment);

        return $createSaleRequest->execute($saleCapture);
    }
}
