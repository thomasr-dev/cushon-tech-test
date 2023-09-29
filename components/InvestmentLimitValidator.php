<?php

namespace app\components;

use app\models\Account;
use app\models\Customer;
use app\models\InvestmentLimit;
use app\models\TaxYear;
use yii\validators\Validator;

class InvestmentLimitValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $investmentAmount = $model->$attribute;
        $taxYearEnd = TaxYear::getTaxYearEndForDate(new \DateTime());

        $annualLimit =
            InvestmentLimit::find()
                ->where([
                    'tax_year_end' => $taxYearEnd
                ])
                ->one();

        if(!$annualLimit) {
            // We don't know what the annual investment limit is for the current tax year.
            // Fail validation with a suitable error message.
            $this->addError(
                $model,
                $attribute,
                'System error: no investment limit set for the tax year ending {taxYear}',
                ['taxYear' => $taxYearEnd]
            );
        }

        // We need to get the total investments the customer has made during the current tax year.
        // Which means we first need to get the customer the account we're investing into belongs to.
        // NB the account ID should have already been validated by earlier validation rules, so we can assume it
        // is correct and definitely exists at this point.
        $account = Account::findOne($model->account_id);
        $customer = Customer::findOne($account->customer_id);

        $totalInvestmentToDate =
            $customer->getTotalInvestmentForTaxYearEnding(TaxYear::getTaxYearEndForDate(new \DateTime()));

        $maximumAllowedInvestment = $annualLimit->annual_limit - $totalInvestmentToDate;

        if($investmentAmount > $maximumAllowedInvestment) {
            // This investment takes the customer over their limit.
            $this->addError(
                $model,
                $attribute,
                'The selected investment amount is too high. You can currently invest a maximum of £{maximum} in the current tax year.',
                ['maximum' => number_format($maximumAllowedInvestment, 2)]
            );
        }
    }
}