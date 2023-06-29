<?php

namespace App\Http\Controllers\Paypal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\PricingPlan;
use App\User;
use PHPUnit\Util\Json;

class PaypalController extends Controller
{
    /**
     * Paypal checkout for subscription
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout($plan_type)
    {
        if ( ! in_array($plan_type, ['geek', 'pro'])) {
            return redirect()->back();
        }
        $pricingPlan = PricingPlan::where('key', $plan_type)->first();
        //dd($pricingPlan);
        return view('paypal.checkout', compact('pricingPlan'));
    }
    public function check()
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v2/checkout/orders',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "intent": "CAPTURE",
          "purchase_units": [
            {
              "reference_id": "REFID-000-1001",
              "amount": {
                "currency_code": "EUR",
                "value": "10.00"
              },
              "payee": {
                "email_address": ""
              },
              "payment_instruction": {
                "platform_fees": [
                  {
                    "amount": {
                      "currency_code": "EUR",
                      "value": "1.00"
                    },
                    "payee": {
                      "email_address": ""
                    }
                  }
                ],
                "disbursement_mode": "INSTANT",
                "payee_pricing_tier_id": "999ZAE"
              }
            }
          ],
          "payment_source": {
            "apple_pay": {
              "id": "DSF32432423FSDFS",
              "name": "",
              "email_address": "",
              "phone_number": {
                "country_code": "",
                "national_number": ""
              },
              "shipping": {
                "name": {
                  "given_name": "",
                  "surname": ""
                },
                "email_address": "",
                "address": {
                  "address_line_1": "",
                  "address_line_2": "",
                  "admin_area_2": "",
                  "admin_area_1": "",
                  "postal_code": "",
                  "country_code": "US"
                }
              },
              "decrypted_token": {
                "transaction_amount": {
                  "currency_code": "EUR",
                  "value": "10.00"
                },
                "tokenized_card": {
                  "number": "",
                  "expiry": "",
                  "billing_address": {
                    "address_line_1": "",
                    "address_line_2": "",
                    "admin_area_2": "",
                    "admin_area_1": "",
                    "postal_code": "",
                    "country_code": ""
                  }
                },
                "device_manufacturer_id": "",
                "payment_data_type": "",
                "payment_data": {
                  "cryptogram": "",
                  "eci_indicator": ""
                }
              }
            }
          }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer <Access-Token>',
            'PayPal-Request-Id: 7b92603e-77ed-4896-8e78-5dea2050476a'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return $response ;

    }
    public function capture($orderId)
    {
     
       //$token = $this->token();
        

       $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v2/checkout/orders/'.$orderId.'/capture',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer A21AAK3zS_evkpMAf4wDuy8BjPwN2khoBHMl9Mmg5hCi1A-8RETZvucDMVwwQVnTp5fGW8mcF3L70MVW2N8WRFmtrXwi1zEJg',
    'Content-Type: application/json',
    'Cookie: ts=vreXpYrS%3D1748012090%26vteXpYrS%3D1653319490%26vr%3Df169e34b1800a1d3375266b3fa439461%26vt%3Df169e34b1800a1d3375266b3fa439460%26vtyp%3Dnew; ts_c=vr%3Df169e34b1800a1d3375266b3fa439461%26vt%3Df169e34b1800a1d3375266b3fa439460; tsrce=devdiscoverynodeweb'
  ),
));

$response = curl_exec($curl);



      // \Log::info($response);

        return $response;
    }
    
        public function token()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v1/oauth2/token',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
          CURLOPT_HTTPHEADER => array(
            'Content-Type : application/x-www-form-urlencoded',
            'Cookie : LANG=en_US%3BUS; ts=vreXpYrS%3D1748012090%26vteXpYrS%3D1653319490%26vr%3Df169e34b1800a1d3375266b3fa439461%26vt%3Df169e34b1800a1d3375266b3fa439460%26vtyp%3Dnew; ts_c=vr%3Df169e34b1800a1d3375266b3fa439461%26vt%3Df169e34b1800a1d3375266b3fa439460; tsrce=devdiscoverynodeweb'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
      
        return $response;
    }
    
}
