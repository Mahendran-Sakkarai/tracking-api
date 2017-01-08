<?php
/**
 * Created by PhpStorm.
 * User: Udhaya Kumar
 * Date: 29-08-2016
 * Time: 15:20
 */

namespace api\components;

class WrapResponse
{
    public static function wrapResponse($data, $totalCount, $page)
    {
        $endCount = (int)(($totalCount < ($page * 20) + 20) ? $totalCount : ($page * 20) + 20);
        return [
            "status" => !empty($data) ? true : false,
            "total" => (int)$totalCount,
            "start" => !empty($data) ? (int)($page * 20) + 1 : 0,
            "end" => !empty($data) ? $endCount : 0,
            "data" => $data
        ];
    }
}