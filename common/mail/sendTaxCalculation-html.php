<?php
/* @var $tax_calculation common\models\TaxCalculation */
?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>Tax Calculation - Indian Tax Calculator</title>

    <style type="text/css">
        .ReadMsgBody {
            width: 100%;
            background-color: #ffffff;
        }

        .ExternalClass {
            width: 100%;
            background-color: #ffffff;
        }

        body {
            width: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            font-family: Georgia, Times, serif
        }

        table {
            border-collapse: collapse;
        }

        @media only screen and (max-width: 640px) {
            .deviceWidth {
                width: 440px !important;
                padding: 0;
            }

            .center {
                text-align: center !important;
            }
        }

        @media only screen and (max-width: 479px) {
            .deviceWidth {
                width: 280px !important;
                padding: 0;
            }

            .center {
                text-align: center !important;
            }
        }

    </style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="font-family: Georgia, Times, serif">

<!-- Wrapper -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td width="100%" valign="top" bgcolor="#ffffff" style="padding-top:20px">

            <!-- Start Header-->
            <table width="580" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth"
                   style="margin:0 auto;">
                <tr>
                    <td width="100%" bgcolor="#ffffff" style="text-align:center">
                        <a href="https://play.google.com/store/apps/details?id=com.appslabz.indiantax&hl=en&pcampaignid=MKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1"><img
                                src="https://s29.postimg.org/nj0ix61yv/Indian_tax_calculator.png"
                                alt="Indian Tax Calculator" border="0" style="max-width:100px"/></a><br/>
                        <a href="https://play.google.com/store/apps/details?id=com.appslabz.indiantax&hl=en&pcampaignid=MKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1"
                           style="text-decoration: none; color: #3b3b3b;">Indian Tax Calculator</a>
                    </td>

                    </td>
                </tr>
            </table>
            <!-- End Header -->

            <!-- One Column -->
            <table width="580" class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center"
                   bgcolor="#eeeeed" style="margin:0 auto;">
                <tr>
                    <td style="font-size: 13px; color: #959595; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px"
                        bgcolor="#eeeeed">
                        <?php
                        echo "<table>";
                        echo "<tr><td colspan='2'>Hi IndianTax Calculator User,<br/></td></tr>";
                        echo "<br/>";

                        echo "<tr><td colspan='2'>As you requested, below we sent you the tax details which you calculated.<br/></td></tr>";

                        foreach ($tax_calculation as $key => $value) {
                            if ($key != "id" && $key != "user_id" && $key != "by_user" && $key != "created_at" && $key != "updated_at") {
                                if ($key == "year" || $key == "category") {
                                    echo "<tr><td><strong>" . \common\component\Util::getTitleOfTaxCalculationKey($key) . " </strong><td style=\"font-size: 18px; color: #f1f1f1; color:#999; font-family: Arial, sans-serif; padding-bottom:20px; text-align:center\">" . $value . "</td></tr>";
                                } else if($key == "income_from_salary" || $key == "total_income" || $key == "taxable_income" || $key == "tax" || $key == "cess" || $key == "final_deduction" || $key == "final_tax") {
                                    echo "<tr><td><strong>" . \common\component\Util::getTitleOfTaxCalculationKey($key) . "</strong><td style=\"font-size: 18px; color: #f1f1f1; color:#999; font-family: Arial, sans-serif; padding-bottom:20px; text-align:center\">Rs " . (empty($value)?"0.00":$value) . " </td></tr>";
                                }else if (!empty($value)) {
                                    echo "<tr><td><strong>" . \common\component\Util::getTitleOfTaxCalculationKey($key) . "</strong><td style=\"font-size: 18px; color: #f1f1f1; color:#999; font-family: Arial, sans-serif; padding-bottom:20px; text-align:center\">Rs " . $value . "</td></tr>";
                                }
                            }
                        }

                        echo "<br/>";

                        echo "<tr><td colspan='2'>Thanks for using Indian Tax Calculator. Wish you pay the tax and help the country. </td></tr>";
                        echo "<tr><td colspan='2'>Please Promote us to reach our milestone by sharing the application using the below <a href=\"https://play.google.com/store/apps/details?id=com.appslabz.indiantax&hl=en\">link</a> and also don't forgot to rate and review us.<br/></td></tr>";
                        echo "<br/>";

                        echo "<tr><td colspan='2'>Thanks Again, </td></tr><tr><td> Appslabz Team.</td></tr>";
                        echo "</table>";
                        ?>
                    </td>
                </tr>
            </table>
            <!-- End One Column -->


            <div style="height:15px;margin:0 auto;">&nbsp;</div>
            <!-- spacer -->

            <!-- 4 Columns -->
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td bgcolor="#363636" style="padding:30px 0">
                        <table width="580" border="0" cellpadding="10" cellspacing="0" align="center"
                               class="deviceWidth" style="margin:0 auto;">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="left"
                                           class="deviceWidth">
                                        <tr>
                                            <td valign="top"
                                                style="font-size: 11px; color: #f1f1f1; color:#999; font-family: Arial, sans-serif; padding-bottom:20px; text-align:center"
                                                class="center">
                                                This mail contains tax calculations. If you are not requested to this
                                                email please report it and delete this email.

                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                style="font-size: 11px; color: #f1f1f1; color:#999; font-family: Arial, sans-serif; padding-bottom:20px; text-align:center"
                                                class="center">
                                                This is an auto generated email. Please don't reply. If you want to
                                                report mail us to <a
                                                    href="mailto:hello@appslabz.com">hello@appslabz.com</a>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                style="font-size: 11px; color: #f1f1f1; color:#999; font-family: Arial, sans-serif; padding-bottom:20px; text-align:center"
                                                class="center">
                                                <a href='https://play.google.com/store/apps/details?id=com.appslabz.indiantax&hl=en&pcampaignid=MKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'><img
                                                        alt='Get it on Google Play'
                                                        src='https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png'
                                                        style="max-width:250px"/></a>
                                            </td>
                                        </tr>
                                    </table>

                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="right"
                                           class="deviceWidth">
                                        <tr>
                                            <td valign="top"
                                                style="font-size: 11px; color: #f1f1f1; font-weight: normal; font-family: Georgia, Times, serif; line-height: 26px; vertical-align: top; text-align:center"
                                                class="center">
                                                <p>Powered By</p>
                                                <a href="http://appslabz.com"><img
                                                        src="https://s30.postimg.org/ql2aa5b8h/appslabz_logo.png" alt=""
                                                        border="0" style="padding-top: 5px;"/></a><br/>
                                                <a href="http://appslabz.com"
                                                   style="text-decoration: none; color: #848484; font-weight: normal;">appslabz.com</a><br/>
                                                <a href="tel:+918042117859"
                                                   style="text-decoration: none; color: #848484; font-weight: normal;">+91-80-4211-7859</a><br/>
                                                <a href="mailto:hello@appslabz.com"
                                                   style="text-decoration: none; color: #848484; font-weight: normal;">hello@appslabz.com</a>
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- End 4 Columns -->

        </td>
    </tr>
</table>
<!-- End Wrapper -->
<div style="display:none; white-space:nowrap; font:15px courier; color:#ffffff;">
    - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
</div>
</body>
</html>

