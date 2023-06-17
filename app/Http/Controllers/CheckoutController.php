<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{

 public function createSession(Request $request): string
    {
        $secretKey = env('SECRETKEY');

        $seed = date('c');
        $this->createNonce();

        $reference = Str::random(10);

        $response = Http::post('https://checkout-test.placetopay.com/api/session',
            [
            'auth' => [
                'login' => env('LOGIN'),
                'tranKey' => base64_encode(sha1($this->nonce . $seed . $secretKey, true)),
                'nonce' => base64_encode($this->nonce),
                'seed' => $seed,
            ],
            'payer' => [
                'document' => '1000888765',
                'documentType' => 'CC',
                'name' => 'Andres Felipe',
                'surname' => 'Mogollón',
                'email' => 'mogllon@prueba.com',
                'mobile' => '3117879834',
            ],
            'payment' => [
                'reference' => $reference,
                'description' => 'Primer consumo',
                'amount' => [
                    'currency' => 'USD',
                    'total' => $request->total
                ],
                'fields' => [
                    'keyword' =>'subscription',
                    'value' =>'1 mes',
                    'displayOn' =>'both',
                ]
            ],
            'expiration' => date('c',strtotime('+30 minutes')),
            "returnUrl" => "https://www.youtube.com/$reference",
            "cancelUrl" => "https://www.google.com/$reference",
            'ipAddress' => $request->ip(),
            "userAgent" => "PlacetoPay Sandbox"
        ]);

        return redirect(json_decode($response->body())->processUrl);
    }  
    
    public function createNonce(): void
    {
        if (function_exists('random_bytes')) {
            $this->nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $this->nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $this->nonce = mt_rand();
        }
    }

}
