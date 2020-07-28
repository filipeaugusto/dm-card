<?php

namespace DMCard;

/**
 * Class Custormer
 * @package DMCard
 */
class Custormer implements \JsonSerializable
{
    private $identityCPF;
//    private $birthdate;

    /**
     * Custormer constructor.
     * @param $identityCPF
     */
    public function __construct($identityCPF)
    {
        $this->identityCPF = $identityCPF;
    }

    /**
     * @return mixed
     */
    public function getIdentityCPF()
    {
        return $this->identityCPF;
    }

    /**
     * @param mixed $identityCPF
     * @return Custormer
     */
    public function setIdentityCPF($identityCPF)
    {
        $this->identityCPF = $identityCPF;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     * @return Custormer
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
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
