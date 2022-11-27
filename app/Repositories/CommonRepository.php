<?php

namespace App\Repositories;

use App\Mail\ExceptionsEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Throwable;

class CommonRepository
{

    function getAppName()
    {
        return config("app.name");
    }

    function getAppMediaPath()
    {
        return config("app.VIEW_APPMEDIAPATH");
    }

    function getExcelFormatPath()
    {
        return config("app.VIEW_EXCELFORMATPATH");
    }


    function getAppLogoImagePath()
    {
        return config("app.VIEW_APPLOGOIMAGE");
    }

    function getAppShortImagePath()
    {
        return config("app.VIEW_APPSHORTIMAGE");
    }

    function isSendEmail()
    {
        return config("app.IS_SEND_MAIL");
    }

    function isSendExceptionReportEmail()
    {
        return config("app.IS_SEND_EXCEPTION_REPORT");
    }

    function getExceptionReportEmailList()
    {
        return config("app.EXCEPTION_REPORT_MAIL");
    }

    function currentDate()
    {
        $timezone = "Asia/Kolkata";
        $currentDate = Carbon::parse(date('Y-m-d H:i:s'), 'UTC')->setTimezone($timezone)->format("Y-m-d H:i:s");
        return $currentDate;
    }

    function currentDateFormate($formate)
    {
        return date($formate);
    }

    function getClientIP()
    {
        $request = Request();
        return $request->ip();
    }

    function filterInput($str)
    {
        return trim(strip_tags($str));
    }

    /*
    * This function is used to create has of user password
    */
    function createHash($str)
    {
        return Hash::make($str);
    }

    function getUserDevice()
    {
        $request = Request();
        return $request->header('User-Agent');
    }

    function getUpperCaseText($str)
    {
        return strtoupper($str);
    }

    function getLowerCaseText($str)
    {
        return strtolower($str);
    }

    function getTempExcelFolderName()
    {
        return "excelfileforimport";
    }

    function getTempFilePathForMessage()
    {
        return "tempFileForSendMessage/";
    }
    
    /**
     * Get Human date diff between from date to currnet date 
     * 
     * * Paramter 
     * 
     * 1) date : from date 
     * 
     * 2) Timezone : timezone name
     * 
     * 
     */
    function getHumanDateDiff($date, $timezone)
    {
        return Carbon::parse($date, $timezone)->diffForHumans();
    }

    function isRedirectRequired($currentUrl, $previousUrl, $startWith)
    {
        $isDealerSigin = Str::contains($previousUrl, "dealer-signin");
        $isFromSignInCheck = Str::contains($previousUrl, "signincheck");
        $isAdminSigin = Str::contains($previousUrl, "admin-signin");
        $isForgotPassword = Str::contains($previousUrl, "forgotpassword");
        $isResetPassword = Str::contains($previousUrl, "resetpassword");
        $isStartWith = Str::startsWith($previousUrl, $startWith);

        if ($currentUrl != $previousUrl && !$isDealerSigin && !$isAdminSigin && url('/') != $previousUrl && $isStartWith && !$isForgotPassword && !$isResetPassword  && !$isFromSignInCheck) {
            return true;
        } else {
            return false;
        }
    }
}
