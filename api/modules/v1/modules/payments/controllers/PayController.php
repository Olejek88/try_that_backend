<?php

namespace api\modules\v1\modules\payments\controllers;

use common\components\PaySystemInterface;
use common\components\PaySystems;
use common\models\InvoiceQuery;
use common\models\InvoiceQueryStatus;
use common\models\Order;
use common\models\PayInfo;
use yii\base\Module;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class PayController extends Controller
{

    public function __construct(string $id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

    }

    public function actionIndex()
    {
//        Url::to(['v1/controllers/pay/index', 'id' => 666]);
        return ['message' => \Yii::t('app', 'index pay page')];
    }

    /**
     * Форма выбора платёжной системы.
     *
     * @param integer $orderId
     * @return array|string
     */
    public function actionSelectPs($orderId)
    {
        // пытаемся найти заказ по id и пользователю
        $order = Order::findOne(['id' => $orderId, 'customer_id' => \Yii::$app->user->id]);
        if ($order == null) {
            // сообщаем о не верном заказе
            return ['message' => \Yii::t('app', 'Такого заказа нет.')];
        }

        // пытаемся получить заявку на оплату по этому заказу, для выбора дальнейших действий
        $invoice = InvoiceQuery::findOne(['order_id' => $orderId]);
        if ($invoice == null || $invoice->isAllowNewPay()) {
            // строим список для показа radiobutton с доступными платёжными системами
            $ps = new PaySystems();
            $paySystems = $ps->getEnabledPaySystems();
            $psList = [];
            foreach ($paySystems as $name => $value) {
                $psList[$value] = $name;
            }

            \Yii::$app->response->format = Response::FORMAT_HTML;
            if (empty($psList)) {
                return $this->renderPartial('select-ps-error', ['message' => 'Нет доступных платёжных систем.']);
            } else {
                return $this->renderPartial('select-ps', ['psList' => $psList, 'orderId' => $orderId]);
            }
        } else {
            if ($invoice->isPayed()) {
                return $this->renderPartial('order-view',
                    ['orderId' => $orderId, 'message' => 'Этот заказ уже оплачен.']
                );
            } else {
                return $this->renderPartial('order-view',
                    ['orderId' => $orderId, 'message' => 'Заказ ожидает подтверждения платежа.']
                );
            }
        }
    }

    /**
     * Метод разбирающий уведомления от платёжных систем которые сами нас уведомляют о состоянии платежей.
     * Из запроса пытаемся получить параметр orderId. В этом параметре мы указываем платёжной системе вернуть нам
     * id заказа в нашей локальной базе. id передаётся в момент проведения платежа.
     */
    public function actionNotification()
    {
        $request = \Yii::$app->request;
        $orderId = $request->getBodyParam('orderId', null);
        if ($orderId === null || !is_numeric($orderId)) {
            // пытаемся получит orderId путём перебора платёжных систем, которые "узнают" свой ответ
            $ps = new PaySystems();
            foreach ($ps->getPaySystems() as $name => $class) {
                /* @var $psi PaySystemInterface */
                $psi = new $class;
                if ($psi->isOddInvoiceId()) {
                    $orderId = $psi->parseOrderId($request);
                    if ($orderId !== false) {
                        break;
                    }
                }
            }
        }

        if ($orderId === false || $orderId === null) {
            $msg = 'В запросе не верно указан идентификатор заказа: (' . $orderId . ')';
            \Yii::info($msg);
            // пустой ответ платёжной системе
            return [];
        }

        $invoice = InvoiceQuery::findOne([['order_id' => $orderId]]);
        if ($invoice !== null) {
            /* @var $ps PaySystemInterface */
            try {
                $ps = new $invoice->pay_system_class;
                $status = $ps->parseNotification($invoice->cost);
                $statusString = InvoiceQuery::getStatusString($status);
                $msg = 'Ответ после разбора уведомления платёжной системы: ' . $statusString;
                \Yii::info($msg);
                $result = $invoice->updateStatus($status, date('c', time()));
                $msg = 'Результат изменения статуса заявки на оплату id: ' . $orderId . ', результат: ' . $result . ')';
                \Yii::info($msg);
                // пустой ответ платёжной системе
                return [];
            } catch (\Exception $exception) {
                \Yii::info('Нет такой платёжной системы: (' . $invoice->pay_system_class . ')');
                // пустой ответ платёжной системе
                return [];
            }
        } else {
            \Yii::info('Нет заявки на оплату c идентификатором: (' . $orderId . ')');
            // пустой ответ платёжной системе
            return [];
        }
    }

    /**
     * Показываем форму для перехода на сайт платёжной системы. Или при возвращении с платёжной системы
     * отправляем на просмотр информации по заказу.
     *
     * @param $orderId integer Ид заказа.
     *
     * @return array|string|Response
     */
    public function actionPsPayForm($orderId)
    {
        // пытаемся найти заказ по id и пользователю
        $order = Order::findOne(['id' => $orderId, 'customer_id' => \Yii::$app->user->id]);
        if ($order == null) {
            // сообщаем о не верном заказе
            return ['message' => \Yii::t('app', 'Такого заказа нет.')];
        }

        $request = \Yii::$app->request;
        $referrer = $request->referrer;
        $urlParts = parse_url($referrer);
        $referrerHost = '';
        if (isset($urlParts['host'])) {
            $referrerHost = $urlParts['host'];
        }

        // проверяем referrer, если совпадает с нашим сайтом, показываем при необходимости форму оплаты платёжной системы
        // если не совпадает, значит вернулись с сайта платёжной системы
        if ($referrerHost == $request->serverName) {
            $psClass = $request->getBodyParam('ps', null);
            if (!PaySystems::isEnabled($psClass)) {
                return ['message' => \Yii::t('app', 'Платёжная система не доступна.')];
            }

            // заявка на оплату по одному заказу у нас должна быть одна
            $invoice = InvoiceQuery::findOne(['order_id' => $orderId]);
            if ($invoice == null) {
                // создаём новую заявку на оплату
                \Yii::info('Создаём новую заявку на оплату для заказа с id: ' . $orderId);
                $invoice = new InvoiceQuery(['order_id' => $orderId, 'status_id' => InvoiceQueryStatus::NEW_ID]);
            } else {
                \Yii::info('Заявка на оплату для заказа с id: ' . $orderId . ' уже есть.');
                // в зависимости от статуса заявки, выполняем действия
                if ($invoice->isPayed()) {
                    // заявка оплачена, отправляем пользователя смотреть заказ
                    return $this->redirect(Url::to('/order/view/' . $orderId));
                } elseif ($invoice->isWaitingPruf()) {
                    // ожидаем подтверждения оплаты, т.е. по новой платить не даём, заставляем ждать
                    return $this->redirect(Url::to('/order/view/' . $orderId));
                } elseif ($invoice->isAllowNewPay()) {
                    // если только зарегистрирована, заявка не оплачена, ожидает оплаты,
                    // отменена - показываем форму для оплаты
                } else {
                    // странная ситуация при которой у заявки статус который мы почему-то не обработали выше
                    return ['message' => \Yii::t('app', 'Не верный статус платежа.')];
                }
            }

            /* @var \common\components\PaySystemInterface $psObject */
            $psObject = new $psClass;

            $invoice->pay_system_class = $psClass;
            $invoice->pay_system_name = $psObject->getName();
            $invoice->description = 'Откуда-то нужно вытащить описание заказа!';
            $invoice->cost = $invoice->order->activityListing->cost;
            $invoice->extra_info = []; // вспомнить зачем, дать внятное описание
            $invoice->setStatusNew();
            $invoice->status_date = date('c', time());
            $invoice->create_date = date('c', time());
            $invoice->last_check = null;
            $invoice->save();

            $piOptions = [
                'deposit' => false,
                'description' => $invoice->description,
                // float 0.0 (модуль платёжной системы сам должен разобраться в каком виде отправить в платёжную систему)
                'cost' => $invoice->cost,
                // к этому моменту он нам ещё не известен
                'paySystemNumber' => null,
                'orderId' => $orderId,
                'target' => $invoice->description,
                'successUrl' => '/pay/success',
                'failUrl' => '/pay/fail',
                'cancelUrl' => '/pay/cancel',
            ];
            $pi = new PayInfo($piOptions);
            $form = $psObject->getHtmlForPay($pi);

            \Yii::$app->response->format = Response::FORMAT_HTML;
            return $this->renderPartial('ps-pay-form', ['formHtml' => $form]);
        } else {
            // видимо вернулись с платёжной системы
            return $this->redirect(Url::to('/order/view/' . $orderId));
        }
    }

    public function actionOrderView($orderId, $message = null)
    {
        return $this->renderPartial('order-view', ['orderId' => $orderId, 'message' => $message]);
//        return ['message' => 'Просмотр заказа: ' . $id];
    }
}
