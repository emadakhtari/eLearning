<?php

namespace App\Http\Requests;

use App\Libs\HelpFunction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MyRequest extends FormRequest
{
    protected function failedValidation($validator)
    {
        $message = HelpFunction::nestedToSingle($validator->errors()->messages());
        throw new HttpResponseException(
            HelpFunction::result(1, $message[0], 422, (object) [])
        );
    }

//    public function forbiddenResponse()
    //    {
    //        return redirect('error')->with('error_message', $this->error);
    //    }
}
