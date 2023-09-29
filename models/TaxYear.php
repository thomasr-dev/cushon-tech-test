<?php

namespace app\models;

use yii\base\Model;

class TaxYear extends Model
{
    /**
     * Given a date, returns the calendar year in which the tax year containing that date ends.
     * @param \DateTimeInterface $date
     * @return int
     */
    public static function getTaxYearEndForDate(\DateTimeInterface $date): int {
        // Tax year runs from 6th April in one year to 5th April in the following year.
        // If the date we have is between 6th April and 31st December inclusive, the tax year ends in the next
        // calendar year.
        // Otherwise, it ends in the current calendar year.
        // NB all references to current and next years are relative to the date provided.
        $month = $date->format('n');

        if($month > 4) {
            // We've got a date some time between May and December, tax year ends in the next calendar
            // year.
            return (int)$date->format('Y') + 1;
        }

        if($month < 4) {
            // We've got a date between January and March, tax year ends in the current calendar year.
            return (int)$date->format('Y');
        }

        // If we've got here, the date is in April, so we need to look at the day of the month.
        $day = $date->format('j');

        if($day >= 6) {
            // We are in the first days of a tax year. Tax year ends in the next calendar year.
            return (int)$date->format('Y') + 1;
        }

        // If we've made it this far then we're in the final days of a tax year. Tax year ends in the current
        // calendar year.
        return (int)$date->format('Y');
    }

    public static function getStartOfTaxYearEndingIn(int $taxYearEnding): \DateTimeInterface {
        $startYear = $taxYearEnding - 1;
        return new \DateTime($startYear.'-04-06 00:00:00');
    }

    public static function getEndOfTaxYearEndingIn(int $taxYearEnding): \DateTimeInterface {
        return new \DateTime($taxYearEnding.'-04-05 23:59:59');
    }
}