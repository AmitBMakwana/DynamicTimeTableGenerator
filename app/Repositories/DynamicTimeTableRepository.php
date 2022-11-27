<?php

namespace App\Repositories;

use App\Repositories\CommonRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DynamicTimeTableRepository extends CommonRepository
{
    function addDynamicTimeTable(
        $bi_nNoOfDays,
        $bi_nNoOfSubject,
        $bi_nTotalSubject,
        $bi_nTotalHours
    ) {
        $res = [];
        try {
            DB::beginTransaction();

            $add = [
                "bi_nNoOfDays" => $bi_nNoOfDays,
                "bi_nNoOfSubject" => $bi_nNoOfSubject,
                "bi_nTotalSubject" => $bi_nTotalSubject,
                "bi_nTotalHours" => $bi_nTotalHours,
            ];
            $result = DB::table('basicinfo')->insertGetId($add);
            
            if ($result > 0) {
                DB::commit();
                $res['status'] = "1";
                $res['id'] = $result;
                $res['message'] = "save successfully.";
            } else {
                DB::rollBack();
                $res['status'] = "0";
                $res['message'] = "Some thing went wrong when saving Please try again.";
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            $res['status'] = "0";
            $res['message'] = $ex->getMessage();
        }
        return $res;
    }

    function getOneData($bi_iId)
    {
        $res = [];
        try {

            $data = DB::table('basicinfo')
                ->select([
                    "basicinfo.*",
                ])
                ->where([
                    ["basicinfo.bi_iId", "=",$bi_iId],
                ])
                ->first();

            if ($data) {
                $res['status'] = "1";
                $res['message'] = "TimeTable fetched successfully.";
                $res['data'] = $data;
            } else {
                $res['status'] = "0";
                $res['message'] = "TimeTable not found.";
            }
        } catch (\Exception $ex) {
            $res['status'] = "0";
            $res['message'] = $ex->getMessage();
        }
        return $res;
    }
}
?>