<?php

/* @var $tax_calculation common\models\TaxCalculation */
echo "Hi IndianTax Calculator User,\n\n";

echo "As you requested, below we added the tax details which you calculated.\n";

foreach($tax_calculation as $key => $value) {
    if($key != "user_id" && $key != "by_user" && $key != "created_at" && $key != "updated_at") {
        if($key == "year" || $key == "category" || $key == "income_from_salary" || $key == "total_income" || $key == "taxable_income" || $key == "tax" || $key == "cess" || $key == "final_deduction" || $key == "final_tax") {
            echo \common\component\Util::getTitleOfTaxCalculationKey($key)." : ".$value . "\n";
        } else if(!empty($value)) {
            echo \common\component\Util::getTitleOfTaxCalculationKey($key)." : ".$value . "\n";
        }
    }
}

echo "\n";

echo "Thanks for using Indian Tax Calculator. Wish you pay the tax and help the country. \n";
echo "Please Promote us to reach our milestone by sharing the application using the link and also don't forgot to rate and review us.\n";
echo "https://play.google.com/store/apps/details?id=com.appslabz.indiantax&hl=en\n\n";

echo "Thanks Again, \nAppslabz Team.";

echo "This mail contains tax calculations. If you are not requested to this email please report it and delete this email.";
