<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\IPaySystem;
use api\modules\v1\components\PaySystems;
use common\models\InvoiceQuery;
use yii\base\InvalidConfigException;
use yii\base\Module;
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
        return ['message' => 'index pay page'];
    }

    public function actionSelectPs()
    {
        \Yii::$app->response->format = Response::FORMAT_HTML;
        $orderId = \Yii::$app->request->getQueryParam('orderId', null);
        // TODO: отдельный метод для получения объекта заказа с проверкой что заказ создан текущим пользователем
        $order = null;
//      $order = Order::getUserOrder($orderId);

        // TODO: вместо этого, поучать список платёжных систем из таблицы pay_systems, т.к. какая-то может быть отключена
        $paySystems = PaySystems::getInstance()->getPaySystems();
        $psarray = [];
        foreach ($paySystems as $name => $value) {
            $psarray[$value] = $name;
        }

        // TODO: нужно решить что возвращать если ни одной платёжной системы нет
        return $this->renderPartial('select-ps', ['psList' => $psarray]);
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
        return ['message' => 'back url page'];
    }
}
