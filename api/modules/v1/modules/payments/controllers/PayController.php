<?php

namespace api\modules\v1\modules\payments\controllers;

use common\components\IPaySystem;
use common\components\PaySystems;
use common\models\InvoiceQuery;
use common\models\Order;
use common\models\PayInfo;
use common\models\PaySystem;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\Request;
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
        $paySystems = PaySystems::getInstance()->getPaySystems();
        $psarray = [];
        foreach ($paySystems as $name => $value) {
            $psarray[$value] = $name;
        }

        // TODO: нужно решить что возвращать если ни одной платёжной системы нет
        return $this->renderPartial('select-ps',
            [
                'psList' => $psarray,
                'orderId' => $orderId,
            ]
        );
    }

    /**
     * Метод разбирающий уведомления от платёжных систем которые сами нас уведомляют о состоянии платежей.
     * Из запроса пытаемся получить параметр iid. В этом параметре мы указываем платёжной системе вернуть нам
     * id заявки на платёж в нашей локальной базе. id передаётся в момент проведения платежа.
     * Если платёжная система не позволяет это сделать, и передаёт необходимое нам значение в параметре
     * с другим именем, необходимо сделать обёртку для выделения этого параметра и приведения его к необходимой
     * нам форме. Url обёртки передавать платёжной системе как адрес для уведомления по платежу.
     *
     * // TODO: возможно ли динамически на этапе создания экземляра класса контроллера получить из всех доступных
     * // классов платёжных систем методы для обработки уведомлений?
     * // Т.е. при обращении к /hue-moe-notification, находим метод из списка доступных платёжных систем
     * // и вызываем его для обработки уведомления.
     * // В таком случае не придётся дописывать для каждой новой странной системы обработчик в этом классе.
     */
    public function actionNotification()
    {
        $invoiceId = \Yii::$app->request->getBodyParam('iid', null);
        if ($invoiceId === null || !is_numeric($invoiceId)) {
            $msg = 'В запросе не верно указан идентификатор заявки на оплату: (' . $invoiceId . ')';
            \Yii::info($msg);
            // пустой ответ яндексу
            return [];
        }

        $invoice = InvoiceQuery::findOne($invoiceId);
        if ($invoice !== null) {
            /* @var $ps IPaySystem */
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
     * Обработчик уведомления от Yandex.Money
     * Так как нет возможности указать платёжной системе какие параметры нужно передать нам в уведомлении,
     * "создаём" нужный нам получив значение из параметра в котором мы передаём системе id заявки на оплату.
     * Далее обрабатываем уведомление "штатным" методом.
     * @return string Статус платежа.
     */
    public function actionNotificationYad()
    {
        $invoiceId = \Yii::$app->request->getBodyParam('label', null);
        if ($invoiceId !== null && is_numeric($invoiceId)) {
            $_POST['iid'] = $invoiceId;
            try {
                \Yii::$app->set('request', new Request());
            } catch (InvalidConfigException $exception) {

            }
        }

        return $this->actionNotification();
    }

    public function actionBackUrl()
    {
//        Url::to(['v1/controllers/pay/index', 'id' => 666]);
//        \Yii::warning($_POST, 'application');
        return ['message' => \Yii::t('app', 'back url page')];
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

            /* @var \common\components\IPaySystem $psObject */
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
