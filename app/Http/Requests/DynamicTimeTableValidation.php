<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DynamicTimeTableValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "bi_nNoOfDays" => "required|integer|gt:0|lte:7",
            "bi_nNoOfSubject" => "required|integer|gt:0|lt:9",
            "bi_nTotalSubject" => "required|integer",
            "bi_nTotalHours" => "required|integer",
        ];
    }

    public function attributes()
    {
        return [
            "jrq_iCompanyId" => "No. Of Working Days",
            "bi_nNoOfSubject" => "No. Of Subject Per Days",
            "bi_nTotalSubject" => "Total Subjects",
            "bi_nTotalHours" => "Total Hours",
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

