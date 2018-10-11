<?php

use yii\db\Migration;

/**
 * Class m180817_111234_pay_status_procedures
 */
class m180817_111234_pay_status_procedures extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $db = $this->getDb();
        $sql = "
        CREATE PROCEDURE " . \common\models\InvoiceQuery::PROCEDURE_STATUS_UPDATE_NAME . " (
          IN queryId int,
          IN status_new int,
          IN status_date_new datetime
        )
        BEGIN
             DECLARE status_old char(32);
             SELECT status_id INTO status_old FROM " . $db->tablePrefix . "invoice_query WHERE id=queryId;
             IF status_old<7 AND status_new>status_old THEN
                UPDATE " . $db->tablePrefix . "invoice_query SET status_id=status_new, status_date=status_date_new WHERE id=queryId;
                SELECT '" . \common\models\InvoiceQuery::CHANGE . "';
             ELSE
                SELECT '" . \common\models\InvoiceQuery::NOT_CHANGE . "';
             END IF;
        END";
        $db->createCommand($sql)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m180817_111234_pay_status_procedures cannot be reverted.\n";
        $db = $this->getDb();
        $db->createCommand('DROP PROCEDURE IF EXISTS '
            . \common\models\InvoiceQuery::PROCEDURE_STATUS_UPDATE_NAME)->execute();
        return true;
    }
}
