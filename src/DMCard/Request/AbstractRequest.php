<?php


namespace DMCard\Request;

use DMCard\Sale;
use DMCard\Merchant;
use Exception;
use Psr\Log\LoggerInterface;

abstract class AbstractRequest
{
    private $merchant;
    private $logger;

    /**
     * AbstractRequest constructor.
     * @param $merchant
     * @param $logger
     */
    public function __construct(Merchant $merchant, LoggerInterface $logger = null)
    {
        $this->merchant = $merchant;
        $this->logger = $logger;
    }

    /**
     * @param $method
     * @param $url
     * @param \JsonSerializable|null $content
     * @return mixed
     * @throws \Exception
     */
    protected function sendRequest($method, $url, \JsonSerializable $content = null)
    {
        $headers = [
            'Accept: application/json',
            'Authorization: Bearer ' . $this->merchant->getConsumerToken(),
        ];

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        switch ($method) {
            case 'GET':
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                break;
            default:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        }

        if ($content !== null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($content));
            $headers[] = 'Content-Type: application/json';
        } else {
            $headers[] = 'Content-Length: 0';
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response   = curl_exec($curl);

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

//        debug($statusCode);
//        debug($url);
//        debug($method);
//        debug($content);
//        debug($headers);
//        debug(curl_errno($curl));
//        dd($response);

        $logger_content = clone $content;
        try {
            if ($logger_content instanceof Sale) {
                $logger_content->card();
            }
        } catch(Exception $e) {}
        
        $logger = [
            'url' => $url,
            'method' => $method,
            'headers' => $headers,
            'statusCode' => $statusCode,
            'content' => json_encode($logger_content)
        ];

        if ($this->logger !== null) {
            $this->logger->info('Logger: ' . json_encode($logger));
            $this->logger->info('Content: ' . json_encode($logger_content));
        }

        if (curl_errno($curl)) {
            throw new \RuntimeException('Curl error: ' . curl_error($curl));
        }

        curl_close($curl);

        return $this->readResponse($statusCode, $response);
    }

    /**
     * @param $statusCode
     * @param $responseBody
     *
     * @return mixed
     *
     */
    protected function readResponse($statusCode, $responseBody)
    {
        $unserialized = null;

        switch ($statusCode) {
            case 200:
            case 201:
                $unserialized = $this->unserialize($responseBody);
                break;
            default:
                $response  = json_decode($responseBody);
                $exception = new \Exception($response->message, !isset($response->returnCode) ? 500 : $response->returnCode);
                throw $exception;
        }

        return $unserialized;
    }

    /**
     * @param $param
     * @return mixed
     */
    public abstract function execute($param);

    /**
     * @param $json
     * @return mixed
     */
    protected abstract function unserialize($json);
}
