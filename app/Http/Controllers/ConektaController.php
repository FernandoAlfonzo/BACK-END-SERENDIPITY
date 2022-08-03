<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DateTime;
use DateInterval;

require '../../vendor/conekta/conekta-php/lib/Conekta.php';
\Conekta\Conekta::setApiKey("key_vgYrzyYp9cnZoiKUMSrq3Q");
\Conekta\Conekta::setApiVersion("2.0.0");

class ConektaController extends Controller
{
    public function getClients()
    {
        $client = new Client();

        /*$response = $client->request('GET', 'https://api.conekta.io/plans/SYSTSPO', [
        'headers' => [
            'Accept' => 'application/vnd.conekta-v2.0.0+json',
            'Authorization' => 'Basic a2V5X3ZnWXJ6eVlwOWNuWm9pS1VNU3JxM1E=',
            'Content-Type' => 'application/json',
        ],
        ]);*/

        $response = $client->request('POST', 'https://api.conekta.io/customers/cus_2rN2YFhT2vKU1NUx2/subscription', [
            'body' => '{"plan": "NET"}',
            'headers' => [
              'Accept' => 'application/vnd.conekta-v2.0.0+json',
              'Authorization' => 'Basic a2V5X3ZnWXJ6eVlwOWNuWm9pS1VNU3JxM1E=',
              'Content-Type' => 'application/json',
            ],
          ]);

          //"{"id":"sub_2rN2r4jTCGgZcHCpB","status":"active","object":"subscription","charge_id":"62178a2a41de2719b8768b2f","created_at":1645709866,"subscription_start":1645709866,"billing_cycle_start":1645709856,"billing_cycle_end":1646179199,"plan_id":"SYSTSPO","last_billing_cycle_order_id":"ord_2rN2r4jTCGgZcHCpE","customer_id":"cus_2rN2YFhT2vKU1NUx2","card_id":"src_2rN2YEyjKJVVgwNhg"}"

          /*$response = $client->request('GET', 'https://api.conekta.io/customers/cus_2rN2YFhT2vKU1NUx2/subscription', [
            'headers' => [
              'Accept' => 'application/vnd.conekta-v2.0.0+json',
              'Authorization' => 'Basic a2V5X3ZnWXJ6eVlwOWNuWm9pS1VNU3JxM1E=',
              'Content-Type' => 'application/json',
            ],
          ]);*/

        $contents = (string) $response->getBody();
        dd($contents);
    }

    public function OrderOXXOPayCreate($nameReference, $total, $quantity, $currency, $nameUser, $emailUser, $phoneUser)
    {
      try{
        $thirty_days_from_now = (new DateTime())->add(new DateInterval('P30D'))->getTimestamp(); 
        //dd($thirty_days_from_now);
        $order = \Conekta\Order::create(
          [
            "line_items" => [
              [
                "name" => $nameReference,
                "unit_price" => $total,
                "quantity" => $quantity
              ]
            ],
            /*"shipping_lines" => [
              [
                "amount" => 1500,
                "carrier" => "FEDEX"
              ]
            ],*/ //shipping_lines - physical goods only
            "currency" => $currency,
            "customer_info" => [
              "name" => $nameUser,
              "email" => $emailUser,
              "phone" => $phoneUser
            ],
            /*"shipping_contact" => [
              "address" => [
                "street1" => "Calle 123, int 2",
                "postal_code" => "06100",
                "country" => "MX"
              ]
            ],*/ //shipping_contact - required only for physical goods
            "charges" => [
              [
                "payment_method" => [
                  "type" => "oxxo_cash",
                  "expires_at" => $thirty_days_from_now
                ]
              ]
            ]
          ]
        );

        return $order;
      } catch (\Conekta\ParameterValidationError $error){
        echo $error->getMessage();
      } catch (\Conekta\Handler $error){
        echo $error->getMessage();
      }

     
    }

    public function notificaciones(Request $request)
    {
      echo "sii";
    }

    public function OrderOXXOPayFind(Type $var = null)
    {
      $orderFind = \Conekta\Order::find('ord_2rSipFGMhiAgp3oJi');
      dd($orderFind);
    }
}
