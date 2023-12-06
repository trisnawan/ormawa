<?php 

namespace App\Libraries;

use App\Libraries\Payment\Purwantara;

class PaymentTerminal {
    private $expiration = 21600;
    private $title = null;
    private $desc = null;
    private $amount = null; // min 1000
    private $payment = null; // require id, iss_code, endpoint, status
    private $link = null; // require for payment-link

    /**
     * return wajib gateway_code, buyer_name, expired_at
     * return kondisional price_total, virtual_account, payment_link, qr_string, qr_image
     *  */ 

    protected function isActive(){
        if(!isset($this->payment['id']) || !isset($this->payment['endpoint']) || !isset($this->payment['iss_code']) || !isset($this->payment['status'])){
            log_message('error', 'Payment Terminal require id, endpoint, iss_code, and status');
            return false;
        }
        if($this->payment['status'] == 'active'){
            return true;
        }
        log_message('error', 'Payment Terminal require status = active');
        return false;
    }

    public function __construct($amount = 0, $title = null, $desc = null, $payment = null){
        $this->amount = $amount;
        $this->title = $title;
        $this->desc = $desc;
        $this->payment = $payment;
    }

    public function setLink($link){
        $this->link = $link;
    }

    public function setPayment($payment){
        $this->payment = $payment;
    }

    public function setInvoice($amount, $title, $desc){
        $this->amount = $amount;
        $this->title = $title;
        $this->desc = $desc;
    }

    public function createPayment($id, $name = null, $email = null, $phone = null){
        if(!$this->isActive()){
            return null;
        }

        if($this->payment['endpoint'] == 'qris'){
            $expName = explode(' ', $name);
            $payload['amount'] = $this->amount;
            $payload['transaction_description'] = $this->desc;
            $payload['customer_email'] = $email;
            $payload['customer_phone'] = $phone;
            $payload['customer_first_name'] = $expName[0] ?? 'Member';
            $payload['customer_last_name'] = $expName[0] ?? 'iConfide';
            $payload['payment_channel'] = $this->payment['iss_code'];
            $payload['payment_method'] = 'wallet';
            $payload['order_id'] = $id;
            $payload['merchant_trx_id'] = $merch_id ?? $id;
        } elseif($this->payment['endpoint'] == 'virtual-account') {
            $payload['expected_amount'] = $this->amount;
            $payload['name'] = $this->title;
            $payload['description'] = $this->desc;
            $payload['bank'] = $this->payment['iss_code'];
            $payload['expired_at'] = date('c', strtotime('+'.$this->expiration.' SECOND'));
            $payload['external_id'] = $id;
            $payload['merchant_trx_id'] = $merch_id ?? $id;
        } elseif($this->payment['endpoint'] == 'payment-link') {
            if(!$this->link){
                log_message('error', 'Link not null for Payment Link');
                return null;
            }
            $payload['amount'] = $this->amount;
            $payload['title'] = $this->title;
            $payload['description'] = $this->desc;
            $payload['expires_at'] = date('c', strtotime('+'.$this->expiration.' SECOND'));
            $payload['external_id'] = $id;
            $payload['return_url'] = $this->link;
        }else {
            log_message('error', 'Payment Endpoint not found!');
            return null;
        }

        $purwantara = new Purwantara();
        $response = $purwantara->sendRequestPost($this->payment['endpoint'], $payload);
        
        return [
            'gateway_code' => $response['uuid'] ?? null,
            'buyer_name' => $response['name'] ?? $this->title ?? null,
            'expired_at' => $response['expired_at'] ?? $response['expired_time'] ?? null,
            'virtual_account' => $response['va_number'] ?? null,
            'qr_string' => $response['qr_string'] ?? null,
            'qr_image' => $response['qr_url'] ?? null,
            'payment_link' => $response['payment_link_url'] ?? null
        ];
    }

}
?>