<?php
/**
 * Created by PhpStorm.
 * User: koputo
 * Date: 8/10/18
 * Time: 5:49 PM
 */

namespace common\models;

/**
 * Class PayInfo
 * @package common\models
 *
 * @property boolean $deposit признак двухстадийного платежа
 * @property string $description описание товара
 * @property float $cost цена товара
 * @property string $paySystemNumber номер платежа в рамках платёжной системы
 * @property string $invoiceQueryId id заявки на оплату в локальной очереди
 * @property string $target назначение платежа
 * @property string $successUrl Url на который платёжная система отправит пользователя после оплаты в случае успеха
 * @property string $failUrl Url на который платёжная система отправит пользователя после оплаты в случае неуспеха
 * @property string $cancelUrl урл для перехода в случае отмены платежа пользователем
 */
class PayInfo
{
    private $deposit = false;
    private $description = '';
    private $cost = 0.0;
    private $paySystemNumber = '';
    private $invoiceQueryId = '';
    private $target = '';
    private $successUrl = '';
    private $failUrl = '';
    private $cancelUrl = '';

    public function __construct($options = [])
    {
        if (isset($options['deposit'])) {
            $this->deposit = $options['deposit'];
        }

        if (isset($options['description'])) {
            $this->description = $options['description'];
        }

        if (isset($options['cost'])) {
            $this->cost = $options['cost'];
        }

        if (isset($options['paySystemNumber'])) {
            $this->paySystemNumber = $options['paySystemNumber'];
        }

        if (isset($options['invoiceQueryId'])) {
            $this->invoiceQueryId = $options['invoiceQueryId'];
        }

        if (isset($options['target'])) {
            $this->target = $options['target'];
        }

        if (isset($options['successUrl'])) {
            $this->successUrl = $options['successUrl'];
        }

        if (isset($options['failUrl'])) {
            $this->failUrl = $options['failUrl'];
        }

        if (isset($options['cancelUrl'])) {
            $this->cancelUrl = $options['cancelUrl'];
        }
    }

    /**
     * @return bool
     */
    public function isDeposit(): bool
    {
        return $this->deposit;
    }

    /**
     * @param bool $deposit
     */
    public function setDeposit(bool $deposit): void
    {
        $this->deposit = $deposit;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getCost(): float
    {
        return $this->cost;
    }

    /**
     * @param float $cost
     */
    public function setCost(float $cost): void
    {
        $this->cost = $cost;
    }

    /**
     * @return string
     */
    public function getPaySystemNumber(): string
    {
        return $this->paySystemNumber;
    }

    /**
     * @param string $paySystemNumber
     */
    public function setPaySystemNumber(string $paySystemNumber): void
    {
        $this->paySystemNumber = $paySystemNumber;
    }

    /**
     * @return string
     */
    public function getInvoiceQueryId(): string
    {
        return $this->invoiceQueryId;
    }

    /**
     * @param string $invoiceQueryId
     */
    public function setInvoiceQueryId(string $invoiceQueryId): void
    {
        $this->invoiceQueryId = $invoiceQueryId;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target): void
    {
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getCancelUrl(): string
    {
        return $this->cancelUrl;
    }

    /**
     * @param string $cancelUrl
     */
    public function setCancelUrl(string $cancelUrl): void
    {
        $this->cancelUrl = $cancelUrl;
    }

    /**
     * @return string
     */
    public function getSuccessUrl(): string
    {
        return $this->successUrl;
    }

    /**
     * @param string $successUrl
     */
    public function setSuccessUrl(string $successUrl): void
    {
        $this->successUrl = $successUrl;
    }

    /**
     * @return string
     */
    public function getFailUrl(): string
    {
        return $this->failUrl;
    }

    /**
     * @param string $failUrl
     */
    public function setFailUrl(string $failUrl): void
    {
        $this->failUrl = $failUrl;
    }
}