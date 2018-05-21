<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $invoice_id
 * @property int $tax_id
 * @property int $order_id
 * @property int $interest_id
 * @property string $start_date
 * @property int $total_amount
 * @property string $invoice_code
 * @property int $prev_lease_rent
 * @property int $grand_total
 * @property int $prev_tax
 * @property int $prev_interest
 * @property int $prev_dues_total
 * @property int $current_lease_rent
 * @property int $current_tax
 * @property int $current_interest
 * @property int $current_dues_total
 * @property int $current_total_dues
 *
 * @property Interest $interest
 * @property Orders $order
 * @property Rate $rate
 * @property Tax $tax
 * @property Payment[] $payments
 */
class InvoiceSearchData extends \yii\base\Model
{
    /**
     * @inheritdoc
     */
    public $to_date;
    public $from_date;
    public $search_key;

    public function rules()
    {
        return [
            [['to_date', 'from_date', 'search_key'], 'safe'],
            [['to_date', 'from_date'], 'string'],
        ];
    }

}
