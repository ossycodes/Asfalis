<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait CustomApiresponse
{
    public function okay($msg = null)
    {
        return response()->json([
            'data' => [
                'title' => $msg ?? 'okay'
            ]
        ], Response::HTTP_OK);
    }

    public function respondWithData($msg = null)
    {
        return response()->json([
            'data' => $msg ?? 'okay'
        ], Response::HTTP_OK);
    }

    public function noContent()
    {
        return  response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function errorBadRequest($msg = null)
    {
        return response()->json([
            'error' => [
                'title' => $msg ?? 'bad request'
            ]
        ], Response::HTTP_BAD_REQUEST);
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
            ]
        ], Response::HTTP_CREATED);
    }

    public function error($msg = null)
    {
        return response()->json([
            'error' => [
                'title' => $msg
            ]
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function errorUnauthorized()
    {
        return response()->json([
            'error' => [
                'title' => 'Unauthorized'
            ]
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function errorInternal($msg = null)
    {
        return response()->json([
            'error' => [
                'title' => 'internal server error'
            ]
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function created($msg = null)
    {
        return response()->json([
            'data' => [
                'title' => $msg
            ]
        ], Response::HTTP_CREATED);
    }
}
