<?php
namespace app\models;

use Yii;

class Ledger extends \yii\base\Model
{

    /**
     *
     * @inheritdoc
     */
    public $particulars;
    public $amount;
    public $date;
    public $isCredit = False;

    function __construct($particulars, $date, $amount, $isCredit) {
        $this->particulars = $particulars;
        $this->amount = $amount;
        $this->isCredit = $isCredit;
        $this->date = $date;
    }



}
