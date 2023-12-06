<?php 

namespace App\Libraries\Payment;

class Purwantara {
    protected $base_url = 'https://api.purwantara.id/v1/';
    protected $base_url_testing = 'https://sandbox-api.purwantara.id/v1/';
    protected $token = '';
    protected $tokenTesting = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5MmU4YTk0MC05ZjU1LTQ1NzMtOTYwNC1lYjM4NWZhZmMxMzkiLCJqdGkiOiJjNDYzMGRkMmUzODUwZWFjNGZiNTVlYjAzNmM2ZjkyZjY2MmY3MjEyMWU2N2RjNWI3MGUyOGYxZjI2YTZmZGI0YTZhZDQ4YmEwZjA1NzE2YSIsImlhdCI6MTY5OTQ1NzUxNC4yMzEzNjUsIm5iZiI6MTY5OTQ1NzUxNC4yMzEzNjgsImV4cCI6MTczMTA3OTkxNC4yMjIyMDgsInN1YiI6IjEyNSIsInNjb3BlcyI6WyJ2aXJ0dWFsX2FjY291bnQtcmVhZCIsInZpcnR1YWxfYWNjb3VudC13cml0ZSIsImNhcmQtcmVhZCIsImNhcmQtd3JpdGUiLCJld2FsbGV0LXJlYWQiLCJld2FsbGV0LXdyaXRlIiwiaW52b2ljZS1yZWFkIiwiaW52b2ljZS13cml0ZSIsInBheW1lbnRfbGluay1yZWFkIiwicGF5bWVudF9saW5rLXdyaXRlIl19.aVu8IXZPrreDJVev4Poqda84JPp1UMXybxMjPglkjo7sUbBjuYsk3hl36bp8qptQM9GZH8PjUGp8pnizlbYeaTzYtWzYSFQRcPgmeJy189VtnG77bTJPmH0FotpdJ0ubRryGwSFzGEbw8a-CMw01MP_WerFM-FXguHue_D77RcNR2F4eqyZZwlH_ntyi65iQlKQYTDYeyAexvncqvRmUCtmmE_iith-EfY6u4AyD2x8XN5Z8_cm_FIa5rwHmUcOIMXfJK1W1XOFiGISGUPqhEmf06CcGF3Vppmlgc0t3cFAYIVCf6F4RG_DvE_B-dqTno3soLLEi1PxzryLNkY05X_J2cIYx3egD0G2F9OUE-gMrCk8teL8IVH_bZAs4LyW6wMzElkm1-W3RnCFwDqpVvoNRWb27yln5czVXVgH-VzGJEAR3lnJY7WRj8HrHk16Kn1Iy7cNoLXzdTowGy0Ja4hY2EIj5Y-C3gAEYMeFVOI4tzQ4DcuBOkVjhZQxP4ewLTQWLKJS6zmtvQ0I4AGkhnYUkKiup3LQ3_Psy0UV2b5HvREAkaq862iE87fHORxGEk7zqjb0Fv4fXAvOGuYUXqE4AH90rlE_kR_j9APfXg_r7PMcuMKLbB42wBzoTSPAM-eMk-iuGs3AfLRuRS7yJEv-fDt9fz1HHro5cHXVSJKc';

    public function sendRequestPost($endpoint, $data){
        $baseUrl = getenv('CI_ENVIRONMENT') == 'development' ? $this->base_url_testing : $this->base_url;
        $token = getenv('CI_ENVIRONMENT') == 'development' ? $this->tokenTesting : $this->token;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $baseUrl.$endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$token
            ),
        ));
        
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE) ?? 0;
        curl_close($curl);
        
        $response = json_decode($response, true);
        if(in_array($response['status'] ?? null, [ 200, 201 ])){
            return $response['data'];
        }

        log_message('error', "Purwantara Response Code $httpcode");
        log_message('error', "Purwantara Response Data ".json_encode($response));
        return null;
    }

    public function sendRequestGet($endpoint, $data = null){
        $baseUrl = getenv('CI_ENVIRONMENT') == 'development' ? $this->base_url_testing : $this->base_url;
        $token = getenv('CI_ENVIRONMENT') == 'development' ? $this->tokenTesting : $this->token;
        if($data){
            $endpoint .= '?'.http_build_query($data);
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $baseUrl.$endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$token
            ),
        ));
        
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE) ?? 0;
        curl_close($curl);
        
        $response = json_decode($response, true);
        if(in_array($response['status'] ?? null, [ 200, 201 ])){
            return $response['data'];
        }

        log_message('error', "Purwantara Response Code $httpcode");
        log_message('error', "Purwantara Response Data ".json_encode($response));
        return null;
    }

    public function webhook(){
        $secret = "9adoH12UIp092019N1Qih3BuYas812dadlQ";
        $rawRequestInput = file_get_contents("php://input");
        $data = json_decode($rawRequestInput, true);

        if(!hash_hmac('sha256', $rawRequestInput, $secret)){
            return [ 'code' => 401 ];
        }

        if(!isset($data["uuid"]) || !isset($data["status"]) || !isset($data["external_id"])){
            return [ 'code' => 403 ];
        }

        return [
            'code' => 200,
            'status' => $data["status"],
            'id' => $data["uuid"]
        ];
    }

}
?>