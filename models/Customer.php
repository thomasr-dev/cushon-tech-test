<?php

namespace app\models;

use yii\db\ActiveRecord;

class Customer extends ActiveRecord
{
    /**
     * Gets the total amount of all investments a customer has made during a tax year.
     * @param int $taxYearEnding The calendar year in which the tax year we're interested in ends.
     * @return float The total investment amount for this customer in the given tax year.
     */
    public function getTotalInvestmentForTaxYearEnding(int $taxYearEnding): float {
        $startDate = TaxYear::getStartOfTaxYearEndingIn($taxYearEnding)->format('Y-m-d H:i:s');
        $endDate = TaxYear::getEndOfTaxYearEndingIn($taxYearEnding)->format('Y-m-d H:i:s');

        return Investment::find()
            ->leftJoin('account', 'investment.account_id = account.id')
            ->where(['customer_id' => $this->id])
            ->andWhere(['BETWEEN', 'created_at', $startDate, $endDate])
            ->sum('amount') ?? 0;
    }
}