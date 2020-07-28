<?php
namespace DMCard;


class Environment implements EnvironmentInterface
{

    private $api;

    /**
     * Environment constructor.
     *
     * @param $api
     */
    private function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * @return Environment
     */
    public static function sandbox()
    {
        $api = 'https://gateway.dmcardapi.com.br/dmcardprocessam/Siscred/DMCardEcommerce/v1';

        return new Environment($api);
    }

    /**
     * @return Environment
     */
    public static function production()
    {
        $api = 'https://gateway.dmcardapi.com.br/dmcardprocessam/Siscred/DMCardEcommerce/v1';

        return new Environment($api);
    }

    /**
     * Gets the environment's Api URL
     *
     * @return string the Api URL
     */
    public function getApiUrl()
    {
        return $this->api;
    }
}
