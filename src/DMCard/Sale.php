<?php

namespace DMCard;


class Sale implements \JsonSerializable
{
    private $terminalTransactionId;
    private $merchantId;

    private $customer;
    private $payment;
    private $card;

    public $status;
    public $message;
    public $authorization;

    /**
     * Sale constructor.
     * @param $terminalTransactionId
     * @param $merchantId
     */
    public function __construct($terminalTransactionId, $merchantId)
    {
        $this->terminalTransactionId = $terminalTransactionId;
        $this->merchantId = $merchantId;
    }


    public function customer($cpf)
    {
        $customer = new Custormer($cpf);

        $this->setCustomer($customer);

        return $customer;
    }

    public function payment($amount, $installments = 1)
    {
        $payment = new Payment($amount, $installments);

        $this->setPayment($payment);

        return $payment;
    }

    public function card()
    {
        $card = new Card();

        $this->setCard($card);

        return $card;
    }

    /**
     * @param mixed $customer
     * @return Sale
     */
    public function setCustomer(Custormer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @param mixed $payment
     * @return Sale
     */
    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * @param mixed $card
     * @return Sale
     */
    public function setCard(Card $card)
    {
        $this->card = $card;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTerminalTransactionId()
    {
        return $this->terminalTransactionId;
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @param $json
     *
     * @return Sale
     */
    public static function fromJson($json)
    {
        $object = json_decode($json);
        $terminalTransactionId = !isset($object->terminalTransactionId) ? substr(time(), -6) : $object->terminalTransactionId;
        $merchantId = !isset($object->merchantId) ? null : $object->merchantId;

        $sale = new Sale($terminalTransactionId, $merchantId);
        $sale->populate($object);

        return $sale;
    }

    /**
     * @param \stdClass $data
     */
    public function populate(\stdClass $data)
    {
        $dataProps = get_object_vars($data);

        if (isset($dataProps['payment'])) {
            $this->payment($data->payment->amount, $data->payment->installments);
        }
        if (isset($dataProps['customer'])) {
            $this->customer($data->customer->identityCPF);
        }

        $this->status = $data->returnCode;
        $this->message = $data->returnMessage;
        $this->authorization = $data->authorizationCode;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
