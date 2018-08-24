<?php
/**
 * Created by PhpStorm.
 * User: koputo
 * Date: 7/16/18
 * Time: 6:25 PM
 */

namespace api\modules\v1\modules\payments\components;

use common\models\InvoiceQueryStatus;
use common\components\PaySystemInterface;
use yii\helpers\Html;
use yii\web\Request;

/**
 * Class YaD
 * Класс реализует интерфейс взаимодействия с Яндекс.Деньги в режими p2p платежей.
 * @package api\modules\v1\modules\payments\components
 */
class YaD implements PaySystemInterface
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

    // список правил для маршрутов urlManager
    private const ROUTES_CONFIG = 'routes';
    private $routes = [];

    /**
     * YaD constructor.
     */
    public function __construct()
    {
        $params = \Yii::$app->params;
        $className = YaD::class;

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

    public function registerInvoice($payInfo)
    {
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
        $form = Html::beginForm($this->paySite . $this->toPayScript);
        $form .= "\n" . Html::hiddenInput('receiver', $this->account);
        $form .= "\n" . Html::hiddenInput('formcomment', $payInfo->getDescription());
        $form .= "\n" . Html::hiddenInput('short-dest', $payInfo->getDescription());
        $form .= "\n" . Html::hiddenInput('label', json_encode($payInfo->getInvoiceQueryId()));
        $form .= "\n" . Html::hiddenInput('quickpay-form', $this->quickPayForm);
        $form .= "\n" . Html::hiddenInput('targets', $payInfo->getTarget());
        $form .= "\n" . Html::hiddenInput('sum', $payInfo->getCost());
        // варианты оплаты
        $items = [
            'PC' => 'Яндекс.Деньгами',
            'AC' => 'Банковской картой',
//            'MC' => 'Мобильный телефон',
        ];
        $form .= "\n" . Html::radioList('paymentType', 'PC', $items);
        $form .= "\n" . Html::submitButton('Оплатить');
        $form .= "\n" . html::a('Отмена', $payInfo->getCancelUrl());
        $form .= "\n" . Html::endForm();
        return $form;
    }

    public function parseBackUrlAnswer()
    {
        // при редиректе пользователя обратно на сайт yad ни чего нам не передаёт
        return null;
    }

    public function parseNotification()
    {
        if ($this->secret == '') {
            // не указан секрет для работы с яндексом
            // запись в лог об этом
            return null;
        }

        // параметры запроса
        $request = \Yii::$app->request;
        $params = self::getRequestParams($request);

        // строка для расчёта хеша
        $val = $this->stringForCalculateHash($params);

        // расчитываем хеш
        $testSha1Hash = sha1($val);

        // строка для отправки в лог
        $req_p = 'notification_type=' . $params['notification_type'] . ',' .
            'operation_id=' . $params['operation_id'] . ',' .
            'amount=' . $params['amount'] . ',' .
            'currency=' . $params['currency'] . ',' .
            'datetime=' . $params['datetime'] . ',' .
            'sender=' . $params['sender'] . ',' .
            'codePro=' . $params['codePro'] . ',' .
            'label=' . $params['label'];

        // отправляем в лог информацию о платеже
        \Yii::info($req_p, 'application');

        // проверка подлинности подтверждения
        if ($testSha1Hash == $params['sha1_hash']) {
            \Yii::info('Товар с ид ' . $params['label'] . ' оплачен.', 'application');
            return InvoiceQueryStatus::PAYED;
        } else {
            \Yii::info('Для товара с ид ' . $params['label'] . ' подтверждение платежа не верное.', 'application');
            return InvoiceQueryStatus::NOT_PAYED;
        }
    }

    /**
     * Возвращает массив параметров переданных YaD
     *
     * @param $request Request
     * @return array
     */
    private function getRequestParams($request)
    {
        $params = [
            'notification_type' => $request->post('notification_type', null),
            'operation_id' => $request->post('operation_id', null),
            'amount' => $request->post('amount', null),
            'currency' => $request->post('currency', null),
            'datetime' => $request->post('datetime', null),
            'sender' => $request->post('sender', null),
            'codePro' => $request->post('codepro', null),
            'label' => $request->post('label', null),
            'sha1_hash' => $request->post('sha1_hash', null),
        ];

        return $params;
    }

    /**
     * Формирует строку для расчёта хеша.
     *
     * @param $params array
     * @return string
     */
    private function stringForCalculateHash($params)
    {
        $val = $params['notification_type'] . '&' .
            $params['operation_id'] . '&' .
            $params['amount'] . '&' .
            $params['currency'] . '&' .
            $params['datetime'] . '&' .
            $params['sender'] . '&' .
            $params['codePro'] . '&' .
            $this->secret . '&' .
            $params['label'];
        return $val;
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

        if (isset($params[self::ROUTES_CONFIG]) && is_array($params[self::ROUTES_CONFIG])) {
            $this->routes = $params[self::ROUTES_CONFIG];
        }
    }

    public function getName()
    {
        return 'Yandex.Money';
    }

    public function isParseBackUrl()
    {
        return false;
    }

    public function isOddInvoiceId()
    {
        return true;
    }

    public function parseInvoiceId($request)
    {
        $params = self::getRequestParams($request);
        $val = self::stringForCalculateHash($params);
        $testHash = sha1($val);
        if ($testHash == $params['sha1_hash']) {
            return $params['label'];
        } else {
            return false;
        }
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}