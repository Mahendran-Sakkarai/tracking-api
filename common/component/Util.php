<?php
/**
 * Created by PhpStorm.
 * User: Udhaya Kumar
 * Date: 30-12-2016
 * Time: 16:06
 */

namespace common\component;


use Yii;

class Util
{
    public static function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9]/', '', $string); // Removes special chars.
    }

    public static function sendIncomeTaxMail($calculation, $email)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'sendTaxCalculation-html', 'text' => 'sendTaxCalculation-text'],
                ['tax_calculation' => $calculation]
            )
            ->setFrom([Yii::$app->params['noReplyEmail'] => "Appslabz Team"])
            ->setTo($email)
            ->setSubject('Tax Calculation - Indian Tax Calculator')
            ->send();
    }

    public static function getTitleOfTaxCalculationKey($key)
    {
        return strtoupper(str_replace("_", " ", $key));
    }
}