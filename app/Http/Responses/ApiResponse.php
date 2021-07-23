<?php

namespace App\Http\Responses;
use Illuminate\Http\Response;

class ApiResponse extends Response
{

    public $body = [
        'status' => 'ERROR',
        'message' => 'Произошла ошибка',
    ];

    public function setStatus($value) {
        $this->body['status'] = $value;
    }

    public function setMessage($value) {
        $this->body['message'] = $value;
    }

    public function setData($value) {
        $this->body['data'] = $value;
    }

    public function asJson()
    {
        return response()->json($this->body);
    }
}

