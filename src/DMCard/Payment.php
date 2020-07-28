<?php

namespace DMCard;


/**
 * Class Payment
 * @package DMCard
 */
class Payment implements \JsonSerializable
{
    const PLAN_A_VISTA = '0';
    const PLAN_PARCELADO_LOJA = '1';
    const PLAN_PARCELADO_EMISSOR = '3';

    private $amount;
    private $installments;
    private $plan;

    /**
     * Payment constructor.
     * @param $amount
     * @param int $installments
     */
    public function __construct($amount, $installments = 1)
    {
        $this->amount = $amount;
        $this->installments = str_pad('0', 2, $installments, STR_PAD_RIGHT);
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
     * @return Payment
     */
    public function setAmount($amount)
    {
        $this->amount = preg_replace('/[^0-9]/', '', $amount);
        return $this;
    }

    /**
     * @return int
     */
    public function getInstallments(): int
    {
        return $this->installments;
    }

    /**
     * @param int $installments
     * @return Payment
     */
    public function setInstallments(int $installments): Payment
    {
        $this->installments = $installments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @param mixed $plan
     * @return Payment
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
        return $this;
    }

    /**
     * @return mixed|void
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
