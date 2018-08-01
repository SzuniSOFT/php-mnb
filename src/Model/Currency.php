<?php


namespace SzuniSoft\Mnb\Model;


class Currency {

    /**
     * @var string
     */
    protected $code;

    /**
     * @var int
     */
    protected $unit;

    /**
     * @var float
     */
    protected $amount;

    /**
     * Currency constructor.
     * @param string $code
     * @param int $unit
     * @param float $amount
     */
    public function __construct($code, $unit, $amount)
    {
        $this->code = (string)$code;
        $this->unit = (int)$unit;
        $this->amount = (float)$amount;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return int
     */
    public function getUnit(): int
    {
        return $this->unit;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

}