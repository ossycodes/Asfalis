<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;

class Customresponses
{
    public function okay($msg = null)
    {
        return response()->json([
            'message' => $msg ?? 'okay'
        ], Response::HTTP_OK);
    }

    public function errorBadRequest($msg = null)
    {
        return response()->json([
            'error' => $msg ?? 'bad request'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function errorInternal($msg = null)
    {
        return response()->json([
            'error' => $msg ?? 'internal server error'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
