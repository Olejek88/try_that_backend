<?php
/**
 * Created by PhpStorm.
 * User: koputo
 * Date: 7/16/18
 * Time: 6:22 PM
 */

namespace common\components;

use common\models\PayInfo;

interface IPaySystem
{
    /**
     * Признак того что перед оплатой нужно зарегистрировать платёжн в платёжной системе.
     *
     * @return boolean
     */
    public function isRegisterInvoice();

    /**
     * Метод регистрирует в платёжной системе заявку на платёж.
     *
     * @param PayInfo $payInfo
     * @return null|string статус согласно константам из модели PaySystemStatus
     */
    public function registerInvoice($payInfo);

    /**
     * Метод регистрирует в платёжной системе заявку на двухстадийный платёж.
     *
     * @param PayInfo $payInfo
     * @return null|string статус согласно константам из модели PaySystemStatus
     */
    public function registerPreAuth($payInfo);

    /**
     * Метод списывает заблокированные средства при двухстадийном платеже.
     *
     * @param string $paySystemNumber уникальный номер заказа в платежной системе
     * @param float $amount сумма заказа (в рублях 100.69)
     * @return null|string статус согласно константам из модели PaySystemStatus
     */
    public function deposit($paySystemNumber, $amount);

    /**
     * Метод разблокирует средства заблокированные при двухстадийном платеже.
     *
     * @param string $paySystemNumber уникальный номер заказа в платежной системе
     * @return null|string статус согласно константам из модели PaySystemStatus
     */
    public function reverse($paySystemNumber);

    /**
     * Признак того что у платёжной системы можно запросить информацию по платежу.
     *
     * @return boolean
     */
    public function isGetStatus();

    /**
     * Получение статуса/информации о платеже из платёжной системы
     *
     * @param string $paySystemNumber уникальный номер заказа в платежной системе
     * @return null|string статус согласно константам из модели PaySystemStatus
     */
    public function getStatus($paySystemNumber);

    /**
     * Возвращает html код для отправки клиента на сайт платёжной системы для оплаты заказа.
     * (сформированная ссылка, форма и т.п.)
     *
     * @param PayInfo $payInfo информация о платеже
     * @return string
     */
    public function getHtmlForPay($payInfo);

    /**
     * Признак необходимости разбирать "ответ" платёжной системы когда пользователь возвращается на сайт.
     *
     * @return boolean
     */
    public function isParseBackUrl();

    /**
     * Разбирает ответ платежной системы когда клиент возвращается на сайт по BACKURL
     *
     * Необходимо контролировать от кого пришел ответ,
     * для предотвращения мошеннический действий по установке ложного статуса.
     *
     * @return null|string статус согласно константам из модели PaySystemStatus
     */
    public function parseBackUrlAnswer();

    /**
     * Метод для разбора уведомления от платежной системы.
     * Используется в случае когда платежная система сама нас информирует о состоянии платежа.
     *
     * Необходимо контролировать от кого пришел ответ,
     * для предотвращения мошеннический действий по установке ложного статуса.
     *
     * @return null|string статус согласно константам из модели PaySystemStatus
     */
    public function parseNotification();

    /**
     * Возвращает максимальный срок жизни заявки на оплату в платёжной системе.
     *
     * @return integer Время в секундах.
     */
    public function getMaxInvoiceLifeTime();

    /**
     * Возвращает максимальную частоту опроса платёжной системы по состоянию заявки на оплату.
     *
     * @return integer Время в секундах.
     */
    public function getQueryFrequency();

    /**
     * Возвращает название платёжной системы
     *
     * @return string
     */
    public function getName();
}