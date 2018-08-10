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
    private const ACCOUNT_CONFIG = 'account';

    // секрет
    private $secret = '';
    private const SECRET_CONFIG = 'secret';

    // Хост на который отправляются запросы к системе
    private $paySite;

    // скрипт который обрабатывает запрос на регистрацию платежа
    private $payScript;

    // скрипт который обрабатывает запрос о состоянии заявки в платежной системе
    private $getStatusScript;

    // URL на который отправляется клиент для оплаты заказа
    private $toPayScript;

    // допустимая частота опроса платежной системы в секундах
    private $queryFrequency = 300;
    private const QUERY_FREQUENCY_CONFIG = 'queryFrequency';

    // максимальное время жизни заявки до того как она "протухнет" в секундах
    private $maxLifeTime = 7200;
    private const MAX_LIFE_TIME_CONFIG = 'maxLifeTime';

    /**
     * YaD constructor.
     */
    public function __construct()
    {
        $params = \Yii::$app->params;
        $className = 'api\modules\v1\components\YaD';

        if (isset($params['paySystems']['classes'][$className])) {
            $yadParams = $params['paySystems']['classes'][$className];
            $this->setupParams($yadParams);
        }

        if (YII_DEBUG) {
            $this->paySite = 'https://money.yandex.ru';
            $this->payScript = '';
            $this->getStatusScript = '';
            $this->toPayScript = '/quickpay/confirm.xml';
        } else {
            $this->paySite = 'https://money.yandex.ru';
            $this->payScript = '';
            $this->getStatusScript = '';
            $this->toPayScript = '/quickpay/confirm.xml';
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

    public function getHtmlForPay($orderData)
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
        return $this->maxLifeTime;
    }

    public function getQueryFrequency()
    {
        return $this->queryFrequency;
    }

    private function setupParams($params = [])
    {
        if (isset($params[self::ACCOUNT_CONFIG]) && $params[self::ACCOUNT_CONFIG] !== '') {
            $this->account = $params[self::ACCOUNT_CONFIG];
        }

        if (isset($params[self::SECRET_CONFIG]) && $params[self::SECRET_CONFIG] !== '') {
            $this->secret = $params[self::SECRET_CONFIG];
        }

        if (isset($params[self::QUERY_FREQUENCY_CONFIG]) && $params[self::QUERY_FREQUENCY_CONFIG] !== '') {
            $this->queryFrequency = $params[self::QUERY_FREQUENCY_CONFIG];
        }

        if (isset($params[self::MAX_LIFE_TIME_CONFIG]) && $params[self::MAX_LIFE_TIME_CONFIG] !== '') {
            $this->maxLifeTime = $params[self::MAX_LIFE_TIME_CONFIG];
        }
    }

    public function getName()
    {
        return 'Yandex.Money';
    }

}