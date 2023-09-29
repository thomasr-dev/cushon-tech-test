<?php

namespace app\models;

use app\components\InvestmentLimitValidator;
use yii\db\ActiveRecord;

class Investment extends ActiveRecord
{
    const SCENARIO_NEW_INVESTMENT = 'new_investment';

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_NEW_INVESTMENT] = ['account_id', 'fund_id', 'amount'];

        return $scenarios;
    }

    public function rules() {
        return [
            // To register a new investment, we require an account ID, fund ID and investment amount.
            [['account_id', 'fund_id', 'amount'], 'required', 'on' => self::SCENARIO_NEW_INVESTMENT],

            // The account ID must exist in the account table.
            ['account_id', 'exist', 'targetClass' => Account::class, 'targetAttribute' => ['account_id' => 'id']],

            // The fund ID must exist in the fund table.
            ['fund_id', 'exist', 'targetClass' => Fund::class, 'targetAttribute' => ['fund_id' => 'id']],

            // The investment amount must be a number > 0.
            ['amount', 'number', 'min' => 0.01],

            // The investment amount must not take the customer beyond their annual investment limit.
            ['amount', InvestmentLimitValidator::class]
        ];
    }
}