<?php
/**
 * Created by PhpStorm.
 * User: koputo
 * Date: 7/16/18
 * Time: 6:25 PM
 */

namespace api\modules\v1\components;

use common\models\PaySystemStatus;

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

    // форма "кнопки"
    private $quickPayForm = 'donate';

    // Хост на который отправляются запросы к системе
    private $paySite;

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
            $this->toPayScript = '/quickpay/confirm.xml';
        } else {
            $this->paySite = 'https://money.yandex.ru';
            $this->toPayScript = '/quickpay/confirm.xml';
        }

    }

    public function isRegisterInvoice()
    {
        // yad p2p не требует регистрации платежа
        return false;
    }

    public function registerInvoice($payInfo) {
        return null;
    }

    public function registerPreAuth($payInfo)
    {
        return null;
    }

    public function deposit($paySystemNumber, $amount)
    {
        return null;
    }

    public function reverse($paySystemNumber)
    {
        return null;
    }

    public function isGetStatus()
    {
        // yad p2p не предоставляет возможности получить статус платежа, т.к. сама система
        // информирует по url кторый указан в настройках кошелька
        return false;
    }

    public function getStatus($paySystemNumber)
    {
        return null;
    }

    public function getHtmlForPay($payInfo)
    {
        // вместо регистрации платежа используется форма
        // TODO: Implement getURLForPay() method.
        $form['receiver'] = array(
            '#type' => 'hidden',
            '#value' => $this->account,
        );

        $form['formcomment'] = array(
            '#type' => 'hidden',
            '#value' => $payInfo->getDescription(),
        );

        $form['short-dest'] = array(
            '#type' => 'hidden',
            '#value' => $payInfo->getDescription(),
        );

        $form['label'] = array(
            '#type' => 'hidden',
            '#value' => json_encode($payInfo->getInvoiceQueryId()),
        );

        $form['quickpay-form'] = array(
            '#type' => 'hidden',
            '#value' => $this->quickPayForm,
        );

        $form['targets'] = array(
            '#type' => 'hidden',
            '#value' => $payInfo->getTarget(),
        );

        $form['sum'] = array(
            '#type' => 'hidden',
            '#value' => $payInfo->getCost(),
        );

        // варианты оплаты
        $form['paymentType'] = array(
            '#type' => 'radios',
            '#options' => array(
                'PC' => 'Яндекс.Деньгами',
                'AC' => 'Банковской картой',
                'MC' => 'Мобильный телефон',
            ),
            '#default_value' => 'PC',
        );

        $from['actions'] = array(
            '#type' => 'actions',
            '#weight' => 10,
            '#action' => $this->paySite . $this->toPayScript,
            'submit' => [
                '#type' => 'submit',
                '#value' => 'Оплатить',
            ],
            'cancel' => [
                '#type' => 'link',
                '#title' => 'Отмена',
                '#href' => $payInfo->getCancelUrl(),
            ]
        );

        return $form;
    }

    public function parseBackUrlAnswer()
    {
        // при редиректе пользователя обратно на сайт yad ни чего нам не передаёт
        return null;
    }

    public function parsePaySystemAnswer()
    {
        $hook_param = array();

        if ($this->secret == '') {
            // не указан секрет для работы с яндексом
            // запись в лог об этом
            return null;
        }

        // параметры запроса
        // notification_type
        $notification_type = isset($_REQUEST['notification_type']) ? $_REQUEST['notification_type'] : '';
        $hook_param['notification_type'] = $notification_type;

        // operation_id
        $operation_id = isset($_REQUEST['operation_id']) ? $_REQUEST['operation_id'] : '';
        $hook_param['operation_id'] = $operation_id;

        // amount
        $amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : '';
        $hook_param['amount'] = $amount;

        // currency
        $currency = isset($_REQUEST['currency']) ? $_REQUEST['currency'] : '';
        $hook_param['currency'] = $currency;

        // datetime
        $datetime = isset($_REQUEST['datetime']) ? $_REQUEST['datetime'] : '';
        $hook_param['datetime'] = $datetime;

        // sender
        $sender = isset($_REQUEST['sender']) ? $_REQUEST['sender'] : '';
        $hook_param['sender'] = $sender;

        // codepro
        $codepro = isset($_REQUEST['codepro']) ? $_REQUEST['codepro'] : '';
        $hook_param['codepro'] = $codepro;

        // label
        $label = isset($_REQUEST['label']) ? $_REQUEST['label'] : '';
        $hook_param['label'] = json_decode($label, true);

        // sha1_hash
        $inHash = isset($_REQUEST['sha1_hash']) ? $_REQUEST['sha1_hash'] : '';
        $hook_param['sha1_hash'] = $inHash;

        // строка для расчёта хеша
        $val = $notification_type . '&' .
            $operation_id . '&' .
            $amount . '&' .
            $currency . '&' .
            $datetime . '&' .
            $sender . '&' .
            $codepro . '&' .
            $this->secret . '&' .
            $label;

        // расчитываем хеш
        $sha1_hash = sha1($val);
        // строка для отправки в лог
        $req_p = 'notification_type=' . $notification_type. ',' .
            'operation_id=' . $operation_id . ',' .
            'amount=' . $amount . ',' .
            'currency=' . $currency . ',' .
            'datetime=' . $datetime . ',' .
            'sender=' . $sender . ',' .
            'codepro=' . $codepro . ',' .
            'label=' . $label;

        // проверка подлинности подтверждения
        if($sha1_hash != $inHash) {
            $hook_param['confirmed'] = false;
        } else {
            $hook_param['confirmed'] = true;
        }

        // отправляем в лог информацию о платеже
        \Yii::warning($req_p,'application');

        // в зависимости от результата проверки уведомления от платёжной системы возвращаем статус платежа
        return PaySystemStatus::PAYED;
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