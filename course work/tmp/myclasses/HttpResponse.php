<?php

namespace myclasses;

class HttpResponse
{
    public function createHttpResponse($code, $error, $message)
    {
        $responseArray = array(
            'code' => $code,
            'error' => $error,
            'message' => $message
        );

        return json_encode($responseArray);
    }
}