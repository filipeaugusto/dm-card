<?php
namespace DMCard;

/**
 * Class Merchant
 * @package DMCard
 */
class Merchant
{
    /**
     * @var
     */
    private $merchant_id;
    /**
     * @var
     */
    private $consumer_key;
    /**
     * @var
     */
    private $consumer_secret;
    /**
     * @var
     */
    private $consumer_token;

    /**
     * Merchant constructor.
     * @param $consumer_key
     * @param $consumer_secret
     */
    public function __construct($consumer_key, $consumer_secret)
    {
        $this->consumer_key = $consumer_key;
        $this->consumer_secret = $consumer_secret;

        $this->generateAccessToken();
    }

    /**
     * @return mixed
     */
    public function getConsumerKey()
    {
        return $this->consumer_key;
    }

    /**
     * @param mixed $consumer_key
     */
    public function setConsumerKey($consumer_key)
    {
        $this->consumer_key = $consumer_key;
    }

    /**
     * @return mixed
     */
    public function getConsumerSecret()
    {
        return $this->consumer_secret;
    }

    /**
     * @param mixed $consumer_secret
     */
    public function setConsumerSecret($consumer_secret)
    {
        $this->consumer_secret = $consumer_secret;
    }

    /**
     * @return mixed
     */
    public function getConsumerToken()
    {
        return $this->consumer_token;
    }

    /**
     * @param mixed $consumer_token
     * @return Merchant
     */
    public function setConsumerToken($consumer_token)
    {
        $this->consumer_token = $consumer_token;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     * @param mixed $merchant_id
     * @return Merchant
     */
    public function setMerchantId($merchant_id)
    {
        $this->merchant_id = $merchant_id;
        return $this;
    }

    protected function generateAccessToken()
    {
        $curl = curl_init();

        $base64 = base64_encode($this->getConsumerKey().':'.$this->getConsumerSecret());

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://gateway.dmcardapi.com.br/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic {$base64}",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "postman-token: 9f99aaa1-d9d3-df8d-4f0d-23048c22792e"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result = json_decode($response);
            $this->setConsumerToken($result->access_token);
            return $result;
        }
    }
}
