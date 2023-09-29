<?php

namespace unit\models;

use app\models\TaxYear;
use Codeception\Test\Unit;

class TaxYearTest extends Unit
{
    public function testGetTaxYearEndForDateStartOfYear() {
        $expected = 2023;
        $actual = TaxYear::getTaxYearEndForDate(new \DateTime('2022-04-06 00:00:00'));

        verify($actual)->equals($expected);
    }

    public function testGetTaxYearEndForDateEndOfYear() {
        $expected = 2023;
        $actual = TaxYear::getTaxYearEndForDate(new \DateTime('2023-04-05 23:59:59'));

        verify($actual)->equals($expected);
    }

    public function testGetTaxYearEndForDateBeforeNewYear() {
        $expected = 2023;
        $actual = TaxYear::getTaxYearEndForDate(new \DateTime('2022-12-31 23:59:59'));

        verify($actual)->equals($expected);
    }

    public function testGetTaxYearEndForDateAfterNewYear() {
        $expected = 2023;
        $actual = TaxYear::getTaxYearEndForDate(new \DateTime('2023-01-01 00:00:00'));

        verify($actual)->equals($expected);
    }
}