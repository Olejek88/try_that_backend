<?php
/**
 * Created by PhpStorm.
 * User: koputo
 * Date: 7/16/18
 * Time: 6:25 PM
 */

namespace api\modules\v1\components;

/**
 * Class YaD
 * Класс реализует интерфейс взаимодействия с Яндекс.Деньги в режими p2p платежей.
 * @package api\modules\v1\components
 */
class YaD implements IPaySystem
{
    // номер "счёта" на который будут перечисленны деньги
    private $account = '';

    // секрет
    private $secret = '';

    // Хост на который отправляются запросы к системе
    private $paySite;

    // скрипт который обрабатывает запрос на регистрацию платежа
    private $payScript;

    // скрипт который обрабатывает запрос о состоянии заявки в платежной системе
    private $getStatusScript;

    // URL на который отправляется клиент для оплаты заказа
    private $toPayScript;

    // допустимая частота опроса платежной системы в секундах
    private static $QUERY_FREQUENCY = 300;

    // максимальное время жизни заявки до того как она "протухнет" в секундах
    private static $MAX_LIFE_TIME = 7200;

    /**
     * YaD constructor.
     */
    public function __construct()
    {
        // TODO: Реализовать установку параметров из $app->params

        //
        if (YII_DEBUG) {
            $this->paySite = '';
            $this->payScript = 'init_payment.php';
            $this->getStatusScript = 'get_status.php';
            $this->toPayScript = 'payment_params.php';
        } else {
            $this->paySite = '';
            $this->payScript = 'init_payment.php';
            $this->getStatusScript = 'get_status.php';
            $this->toPayScript = 'payment_params.php';
        }

    }

    public function registerInvoice(
        $queryId,
        $goodsId,
        $amount,
        $description,
        $backURL,
        &$paySystemNumber,
        $params = []
    ) {
        // TODO: Implement registerInvoice() method.
    }

    public function registerPreAuth($queryId, $goodsId, $amount, $description, $backURL, &$paySystemNumber, $params)
    {
        // TODO: Implement registerPreAuth() method.
    }

    public function deposit($paySystemNumber, $amount)
    {
        // TODO: Implement deposit() method.
    }

    public function reverse($paySystemNumber)
    {
        // TODO: Implement reverse() method.
    }

    public function getStatus($paySystemNumber)
    {
        // TODO: Implement getStatus() method.
    }

    public function getURLForPay($orderData)
    {
        // TODO: Implement getURLForPay() method.
    }

    public function parseBackURLAnswer()
    {
        // TODO: Implement parseBackURLAnswer() method.
    }

    public function parsePaySystemAnswer()
    {
        // TODO: Implement parsePaySystemAnswer() method.
    }

    public function getMaxInvoiceLifeTime()
    {
        // TODO: реализовать проверку данного параметра в $app->params
        return self::$MAX_LIFE_TIME;
    }

    public function getQueryFrequency()
    {
        // TODO: реализовать проверку данного параметра в $app->params
        return self::$QUERY_FREQUENCY;
    }

}