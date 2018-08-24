<?php

namespace api\modules\v1\modules\payments\controllers;

use common\components\PaySystemInterface;
use common\components\PaySystems;
use common\models\InvoiceQuery;
use common\models\Order;
use common\models\PayInfo;
use common\models\PaySystem;
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

    public function actionSelectPs()
    {
        \Yii::$app->response->format = Response::FORMAT_HTML;
        $orderId = \Yii::$app->request->getQueryParam('orderId', null);
        // TODO: отдельный метод для получения объекта заказа с проверкой что заказ создан текущим пользователем
        $order = null;
//        $order = Order::getUserOrder($orderId);

        // TODO: вместо этого, поучать список платёжных систем из таблицы pay_systems, т.к. какая-то может быть отключена
        $ps = new PaySystems();
        $paySystems = $ps->getPaySystems();
        $psList = [];
        foreach ($paySystems as $name => $value) {
            $psList[$value] = $name;
        }

        // TODO: нужно решить что возвращать если ни одной платёжной системы нет
        return $this->renderPartial('select-ps',
            [
                'psList' => $psList,
                'orderId' => $orderId,
            ]
        );
    }

    /**
     * Метод разбирающий уведомления от платёжных систем которые сами нас уведомляют о состоянии платежей.
     * Из запроса пытаемся получить параметр invoiceId. В этом параметре мы указываем платёжной системе вернуть нам
     * id заявки на платёж в нашей локальной базе. id передаётся в момент проведения платежа.
     */
    public function actionNotification()
    {
        $request = \Yii::$app->request;
        $invoiceId = $request->getBodyParam('invoiceId', null);
        if ($invoiceId === null || !is_numeric($invoiceId)) {
            // пытаемся получит invoiceId путём перебора платёжных систем, которые "узнают" свой ответ
            $ps = new PaySystems();
            foreach ($ps->getPaySystems() as $name => $class) {
                /* @var $psi PaySystemInterface */
                $psi = new $class;
                if ($psi->isOddInvoiceId()) {
                    $invoiceId = $psi->parseInvoiceId($request);
                    if ($invoiceId !== false) {
                        break;
                    }
                }
            }
        }

        if ($invoiceId === false) {
            $msg = 'В запросе не верно указан идентификатор заявки на оплату: (' . $invoiceId . ')';
            \Yii::info($msg);
            // пустой ответ яндексу
            return [];
        }

        $invoice = InvoiceQuery::findOne($invoiceId);
        if ($invoice !== null) {
            /* @var $ps PaySystemInterface */
            try {
                $ps = new $invoice->pay_system_class;
                $status = $ps->parseNotification();
                $msg = 'Ответ после разбора уведомления платёжной системы: ' . $status;
                \Yii::info($msg);
                // TODO: реализовать установку статуса
                // пустой ответ яндексу
                return [];
            } catch (\Exception $exception) {
                \Yii::info('Нет такой платёжной системы: (' . $invoice->pay_system_class . ')');
                return [];
            }
        } else {
            \Yii::info('Нет заявки на оплату c идентификатором: (' . $invoiceId . ')');
            return [];
        }
    }

    /**
     * Показываем форму для перехода на сайт платёжной системы. Или при возвращении с платёжной системы
     * отправляем на просмотр информации по заказу.
     *
     * @param $id integer Ид заказа
     *
     * @return array|string|Response
     */
    public function actionPsPayForm($id)
    {
        if (!is_numeric($id)) {
            // сообщаем о не верном заказе
            return ['message' => \Yii::t('app', 'Такого заказа нет.')];
        }

        $order = Order::findOne($id);
        if ($order == null) {
            // сообщаем о не верном заказе
//            return ['message' =>  \Yii::t('app','Такого заказа нет.')];
        }

        $user = \Yii::$app->user;
        // TODO: исправить когда будет реализована связь
//        $orderUserId = $order->user_id;
        $orderUserId = $user->id;
        if ($orderUserId != $user->id) {
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

        // проверяем referrer, если не совпадает с нашим сайтом, значит вернулись с платёжной системы
        // иначе, показываем при необходимости форму оплаты платёжной системы
        if ($referrerHost == $request->serverName) {
            $psClass = $request->getBodyParam('ps', null);
            $ps = PaySystem::findOne(['class' => $psClass]);
            if ($ps == null || $ps->enable == false) {
                return ['message' => \Yii::t('app', 'Платёжная система не доступна.')];
            }

            // TODO: проверить есть ли уже запись с заявкой на оплату по этому заказу
            // если нет, создать
            // если есть, статус неоплачена, отменена - создать новую
            // если есть, статус ожидание подтверждения, не давать платить
            // если оплачена не давать платить ещё раз

            // заявка на оплату по одному заказу у нас должна быть одна
            /* @var $invoice InvoiceQuery */
            $invoice = InvoiceQuery::find()->Where(['order_id' => $id])->one();

            if ($invoice == null) {
                // создаём новую заявку на оплату
                $invoice = new InvoiceQuery(['order_id' => $id]);
            } else {
                // в зависимости от статуса заявки, выполняем действия
                if ($invoice->isPayed()) {
                    // заявка оплачена, отправляем пользователя смотреть заказ
                    return $this->redirect(Url::to('/order/view?id=' . $id));
                } elseif ($invoice->isWaitingPruf()) {
                    // ожидаем подтверждения оплаты, т.е. по новой платить не даём, заставляем ждать
                    return $this->redirect(Url::to('/order/view?id=' . $id));
                } elseif ($invoice->isAllowNewPay()) {
                    // если только зарегистрирована, заявка не оплачена, ожидает оплаты,
                    // отменена - показываем форму для оплаты
                } else {
                    // странная ситуация при которой у заявки статус который мы почему-то не обработали выше
                    return ['message' => \Yii::t('app', 'Не верный статус платежа.')];
                }
            }

            // TODO: параметры должны заполняться из данных в $order
            $piOptions = [
                'deposit' => false,
                'description' => 'test description',
                'cost' => '2.0',
                'paySystemNumber' => 'fuck you',
                'invoiceQueryId' => '777',
                'target' => 'подаяние',
                'successUrl' => '/pay/success',
                'failUrl' => '/pay/fail',
                'cancelUrl' => '/pay/cancel',
            ];
            $pi = new PayInfo($piOptions);

            /* @var \common\components\PaySystemInterface $psObject */
            $psObject = new $ps->class;
            $form = $psObject->getHtmlForPay($pi);

            \Yii::$app->response->format = Response::FORMAT_HTML;
            return $this->renderPartial('ps-pay-form', ['formHtml' => $form]);
        } else {
            // видимо вернулись с платёжной системы
            return $this->redirect(Url::to('/order/view?id=' . $id));
        }
    }
}
