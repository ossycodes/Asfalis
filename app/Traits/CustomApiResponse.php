<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait CustomApiresponse
{
    //find a way to chain methods eg return $this->customApiResponse()->okay();
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
            'status' => true,
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
                'message' => $msg
            ]
        ], Response::HTTP_CREATED);
    }

    /**
     * public function emergencyContactCreated() {
     *  return (new Emergencycontacts($emergencycontacts))
     * ->response()
     *  ->header('Location', route('emergencycontact.show', ['id' =>
     *  $emergencycontact->id]));
     * }
     */

    /**
     * public function emergencyContactUpdated() {
     *    return new Emergencycontacts($emergencyContact);
     *}
     */
}
