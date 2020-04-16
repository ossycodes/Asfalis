<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait CustomApiresponse
{
    /**
     * description here.
     *
     * @param  string  $msg
     * @return array
     */
    public function okay($msg = null)
    {
        return response()->json([
            'data' => [
                'title' => $msg ?? 'okay'
            ]
        ], Response::HTTP_OK);
    }

    /**
     * description here.
     *
     * @param  string  $msg
     * @return array
     */
    public function respondWithData($msg = null)
    {
        return response()->json([
            'data' => $msg ?? 'okay'
        ], Response::HTTP_OK);
    }

    /**
     * description here.
     *
     * @return array
     */
    public function noContent()
    {
        return  response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * description here.
     *
     * @param  string  $msg
     * @return array
     */
    public function errorBadRequest($msg = null)
    {
        return response()->json([
            'error' => [
                'title' => $msg ?? 'bad request'
            ]
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * retuen JWT for the specific user.
     *
     * @param  string  $msg
     * @return array
     */
    public function respondWithToken($token)
    {
        return response()->json([
            'data' => [
                'first_name' => auth()->user()->first_name,
                'last_name' => auth()->user()->last_name,
                'phonenumber' => auth()->user()->phonenumber,
                'email' => auth()->user()->email,
                'access_token' => $token,
                'token_type' => 'bearer',
            ]
        ], Response::HTTP_CREATED);
    }

    /**
     * description here.
     *
     * @param  string|null  $msg
     * @return array
     */
    public function error($msg = null)
    {
        return response()->json([
            'error' => [
                'title' => $msg
            ]
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * description here.
     *
     * @return array
     */
    public function errorUnauthorized()
    {
        return response()->json([
            'error' => [
                'title' => 'Unauthorized'
            ]
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * description here.
     *
     * @param  string|null  $msg
     * @return array
     */
    public function errorInternal($msg = null)
    {
        return response()->json([
            'error' => [
                'title' => 'internal server error'
            ]
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * description here.
     *
     * @param  string|null  $msg
     * @return array
     */
    public function created($msg = null)
    {
        return response()->json([
            'data' => [
                'title' => $msg
            ]
        ], Response::HTTP_CREATED);
    }
}
