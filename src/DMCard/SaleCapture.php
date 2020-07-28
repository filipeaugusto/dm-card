<?php


namespace DMCard;


class SaleCapture implements \JsonSerializable
{

    private $terminalTransactionId;
    private $merchantId;
    private $amount;
    private $authorizationCode;

    public $status;
    public $message;

    /**
     * SaleCapture constructor.
     * @param $terminalTransactionId
     * @param $merchantId
     */
    public function __construct($terminalTransactionId, $merchantId)
    {
        $this->terminalTransactionId = $terminalTransactionId;
        $this->merchantId = $merchantId;
    }

    public static function fromJson($json)
    {
        $object = json_decode($json);

        $terminalTransactionId = !isset($object->terminalTransactionId) ? substr(time(), -6) : $object->terminalTransactionId;
        $merchantId = !isset($object->merchantId) ? null : $object->merchantId;

        $saleCapture = new SaleCapture($terminalTransactionId, $merchantId);
        $saleCapture
            ->setAmount($object->amount)
            ->setAuthorizationCode($object->authorizationCode);

        $saleCapture->status = $object->returnCode;
        $saleCapture->message = $object->returnMessage;

        return $saleCapture;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     * @return SaleCapture
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param mixed $authorizationCode
     * @return SaleCapture
     */
    public function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return SaleCapture
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return SaleCapture
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
