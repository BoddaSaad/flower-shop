<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymobService
{
    protected string $secret;
    protected array $methods;
    protected string $api;
    protected string $notificationUrl;

    public function __construct()
    {
        $this->secret = config('paymob.secret_key');
        $this->methods = config('paymob.methods');
        $this->api = config('paymob.api_url');
        $this->notificationUrl = config('paymob.notification_url') ?? route('checkout.webhook');
    }

    public function intent($total_price_cents, $reference){
        $user = Auth::user();
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $this->secret,
            'Content-Type' => 'application/json'
        ])->post($this->api . "/v1/intention/", [
            "amount"=> $total_price_cents,
            "currency"=> "EGP",
            "special_reference"=>$reference,
            "notification_url"=> $this->notificationUrl,
            "redirection_url"=> route('checkout.callback'),
            "payment_methods"=> $this->methods,
            "billing_data"=>[
                "first_name"=>$user->name,
                "last_name"=>"NA",
                "email"=>$user->email,
                "phone_number"=>"NA"
            ]
        ]);
        return $response;
    }

    public function hmacCalc($data, $hmac){
        $concatenated = $data['amount_cents'].$data['created_at'].$data['currency'].($data['error_occured'] ? "true" : "false").($data['has_parent_transaction'] ? "true" : "false").$data['id'].$data['integration_id'].($data['is_3d_secure'] ? "true" : "false").($data['is_auth'] ? "true" : "false").($data['is_capture'] ? "true" : "false").($data['is_refunded'] ? "true" : "false").($data['is_standalone_payment'] ? "true" : "false").($data['is_voided'] ? "true" : "false").$data['order']['id'].$data['owner'].($data['pending'] ? "true" : "false").$data['source_data']['pan'].$data['source_data']['sub_type'].$data['source_data']['type'].($data['success'] ? "true" : "false");
        $hashedString = hash_hmac('sha512', $concatenated, config('paymob.hmac_secret'));
        if($hashedString === $hmac){
            return true;
        }
        return false;
    }
}
