<?php
/**
 * Created by PhpStorm.
 * User: koputo
 * Date: 7/16/18
 * Time: 6:22 PM
 */

namespace api\modules\v1\components;

interface IPaySystem
{
    /**
     * Метод регистрирует в платёжной системе заявку на платёж.
     *
     * @param string $queryId Id записи в таблице order_query
     * @param string $goodsId локальный номер заказа (имя таблицы и ид в ней) ????
     * @param float $amount сумма заказа (в рублях 100.69)
     * @param string $description коментарий к заказу (описание)
     * @param string $backURL урл на который будет возвращен пользователь после ввода реквизитов карты (оплаты)
     * @param string $paySystemNumber уникальный номер заказа в платежной системе
     * @param array $params специфические параметры для платёжных систем
     * @return array возвращаем массив с двумя статусам - основным и дополнительным,
     *               а также номер заявки в платежной системе $paySystemNumber
     */
    public function registerInvoice(
        $queryId,
        $goodsId,
        $amount,
        $description,
        $backURL,
        &$paySystemNumber,
        $params = []
    );

    /**
     * Метод регистрирует в платёжной системе зявку на двухстадийный платёж
     * и возвращает номер заявки в формате платёжной системы.
     *
     * @param string $queryId Id записи в таблице order_query
     * @param string $goodsId локальный номер заказа (имя таблицы и ид в ней)
     * @param float $amount сумма заказа (в рублях 100.69)
     * @param string $description коментарий к заказу (описание)
     * @param string $backURL урл на который будет возвращен пользователь после ввода реквизитов карты (оплаты)
     * @param string $paySystemNumber уникальный номер заказа в платежной системе
     * @param array $params специфические параметры для платёжных систем
     * @return array возвращаем массив с двумя статусам - основным и дополнительным,
     *               а также номер заявки в платежной системе $paySystemNumber
     */
    public function registerPreAuth($queryId, $goodsId, $amount, $description, $backURL, &$paySystemNumber, $params);

    /**
     * функция списывает заблокированные средства по заказу
     *
     * @param string $paySystemNumber уникальный номер заказа в платежной системе
     * @param float $amount сумма заказа (в рублях 100.69)
     * @return array возвращаем массив с двумя статусам - основным и дополнительным
     */
    public function deposit($paySystemNumber, $amount);

    /**
     * Метод разблокирует средства по заказу (мы отдаём деньги обратно клиенту, не возвращаем,
     * а не берём. Возврат взятых денег - refund)
     *
     * @param string $paySystemNumber уникальный номер заказа в платежной системе
     * @return array возвращаем массив с двумя статусам - основным и дополнительным
     */
    public function reverse($paySystemNumber);

    /**
     * Получение статуса/информации о платеже из платёжной системы
     *
     * @param string $paySystemNumber уникальный номер заказа в платежной системе
     * @return array возвращаем массив с двумя статусам - основным и дополнительным
     */
    public function getStatus($paySystemNumber);

    /**
     * Возвращает урл для отправки клиента на сайт платёжной системы для оплаты заказа.
     *
     * @param array $orderData (возможно здесь должен быть объект Order)
     * @return string
     */
    public function getURLForPay($orderData);

    /**
     * Разбирает ответ платежной системы когда клиент возвращается на сайт по BACKURL
     *
     * Необходимо контролировать от кого пришел ответ,
     * для предотвращения мошеннический действий по установке ложного статуса.
     *
     * @return array возвращаем два статуса
     */
    public function parseBackURLAnswer();

    /**
     * Метод для разбора ответа от платежной системы.
     * Используется в случае когда платежная система сама нас информирует о состоянии платежа.
     *
     * Необходимо контролировать от кого пришел ответ,
     * для предотвращения мошеннический действий по установке ложного статуса.
     *
     * @return array возвращаем два статуса
     */
    public function parsePaySystemAnswer();

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
}