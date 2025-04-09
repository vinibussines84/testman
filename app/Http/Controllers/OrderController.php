<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;  // Para notificar o usuário
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validação da chave da API
        $apiKey = $request->header('X-API-KEY');
        if ($apiKey !== 'yN6zc1UTmKyUk72L6XVzAX7HaGl7cwoM') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Processar o Payload
        $data = $request->all();

        try {
            // Verificar se o 'merchant_name' foi enviado no payload, caso contrário, definir o valor padrão
            $merchantName = $data['merchant_name'] ?? 'vinicius';  // Valor padrão: 'vinicius'

            // Criar o pedido e salvar todos os campos do payload, incluindo o 'merchant_name'
            $order = Order::create([
                'merchant_name' => $merchantName,  // Usa o 'merchant_name' do payload ou o valor padrão
                'add_url' => $data['add_url'] ?? null,
                'address_city' => $data['address_city'] ?? null,
                'address_company' => $data['address_company'] ?? null,
                'address_country' => $data['address_country'] ?? null,
                'address_country_name' => $data['address_country_name'] ?? null,
                'address_first_name' => $data['address_first_name'] ?? null,
                'address_id' => $data['address_id'] ?? null,
                'address_last_name' => $data['address_last_name'] ?? null,
                'address_mobile_no' => $data['address_mobile_no'] ?? null,
                'address_phone_no' => $data['address_phone_no'] ?? null,
                'address_salutation' => $data['address_salutation'] ?? null,
                'address_salutation_name' => $data['address_salutation_name'] ?? null,
                'address_state' => $data['address_state'] ?? null,
                'address_street' => $data['address_street'] ?? null,
                'address_street2' => $data['address_street2'] ?? null,
                'address_street_name' => $data['address_street_name'] ?? null,
                'address_street_number' => $data['address_street_number'] ?? null,
                'address_tax_id' => $data['address_tax_id'] ?? null,
                'address_title' => $data['address_title'] ?? null,
                'address_zipcode' => $data['address_zipcode'] ?? null,

                'amount' => $data['amount'] ?? 0,
                'amount_affiliate' => $data['amount_affiliate'] ?? 0,
                'amount_brutto' => $data['amount_brutto'] ?? 0,
                'amount_credited' => $data['amount_credited'] ?? 0,
                'amount_fee' => $data['amount_fee'] ?? 0,
                'amount_main_affiliate' => $data['amount_main_affiliate'] ?? 0,
                'amount_netto' => $data['amount_netto'] ?? 0,
                'amount_partner' => $data['amount_partner'] ?? 0,
                'amount_payout' => $data['amount_payout'] ?? 0,
                'amount_provider' => $data['amount_provider'] ?? 0,
                'amount_vat' => $data['amount_vat'] ?? 0,
                'amount_vendor' => $data['amount_vendor'] ?? 0,

                'api_mode' => $data['api_mode'] ?? null,
                'billing_city' => $data['billing_city'] ?? null,
                'billing_company' => $data['billing_company'] ?? null,
                'billing_country' => $data['billing_country'] ?? null,
                'billing_first_name' => $data['billing_first_name'] ?? null,
                'billing_id' => $data['billing_id'] ?? null,
                'billing_last_name' => $data['billing_last_name'] ?? null,
                'billing_mobile_no' => $data['billing_mobile_no'] ?? null,
                'billing_phone_no' => $data['billing_phone_no'] ?? null,
                'billing_salutation' => $data['billing_salutation'] ?? null,
                'billing_salutation_name' => $data['billing_salutation_name'] ?? null,
                'billing_state' => $data['billing_state'] ?? null,
                'billing_status' => $data['billing_status'] ?? null,
                'billing_street' => $data['billing_street'] ?? null,
                'billing_street2' => $data['billing_street2'] ?? null,
                'billing_street_name' => $data['billing_street_name'] ?? null,
                'billing_street_number' => $data['billing_street_number'] ?? null,
                'billing_tax_id' => $data['billing_tax_id'] ?? null,
                'billing_title' => $data['billing_title'] ?? null,
                'billing_type' => $data['billing_type'] ?? null,
                'billing_zipcode' => $data['billing_zipcode'] ?? null,

                'buyer_address_city' => $data['buyer_address_city'] ?? null,
                'buyer_address_company' => $data['buyer_address_company'] ?? null,
                'buyer_address_country' => $data['buyer_address_country'] ?? null,
                'buyer_address_id' => $data['buyer_address_id'] ?? null,
                'buyer_address_mobile_no' => $data['buyer_address_mobile_no'] ?? null,
                'buyer_address_phone_no' => $data['buyer_address_phone_no'] ?? null,
                'buyer_address_state' => $data['buyer_address_state'] ?? null,
                'buyer_address_street' => $data['buyer_address_street'] ?? null,
                'buyer_address_street2' => $data['buyer_address_street2'] ?? null,
                'buyer_address_tax_id' => $data['buyer_address_tax_id'] ?? null,
                'buyer_address_zipcode' => $data['buyer_address_zipcode'] ?? null,

                'buyer_email' => $data['buyer_email'] ?? null,
                'buyer_first_name' => $data['buyer_first_name'] ?? null,
                'buyer_id' => $data['buyer_id'] ?? null,
                'buyer_language' => $data['buyer_language'] ?? null,
                'buyer_last_name' => $data['buyer_last_name'] ?? null,

                'campaignkey' => $data['campaignkey'] ?? null,
                'click_id' => $data['click_id'] ?? null,
                'country' => $data['country'] ?? null,
                'currency' => $data['currency'] ?? null,
                'custom' => $data['custom'] ?? null,
                'custom_key' => $data['custom_key'] ?? null,
                'customer_affiliate_name' => $data['customer_affiliate_name'] ?? null,
                'customer_affiliate_promo_url' => $data['customer_affiliate_promo_url'] ?? null,

                'email' => $data['email'] ?? null,
                'first_amount' => $data['first_amount'] ?? 0,
                'first_billing_interval' => $data['first_billing_interval'] ?? null,
                'first_vat_amount' => $data['first_vat_amount'] ?? 0,

                'invoice_url' => $data['invoice_url'] ?? null,
                'ipn_config_id' => $data['ipn_config_id'] ?? null,
                'ipn_config_product_ids' => $data['ipn_config_product_ids'] ?? null,
                'ipn_version' => $data['ipn_version'] ?? null,
                'is_gdpr_country' => $data['is_gdpr_country'] ?? null,
                'is_payment_planned' => $data['is_payment_planned'] ?? null,
                'item_count' => $data['item_count'] ?? 0,
                'language' => $data['language'] ?? null,

                'license_data_email_2' => $data['license_data_email_2'] ?? null,
                'license_data_first_name_2' => $data['license_data_first_name_2'] ?? null,
                'license_data_last_name_2' => $data['license_data_last_name_2'] ?? null,
                'license_data_product_2' => $data['license_data_product_2'] ?? null,
                'license_data_quantity_2' => $data['license_data_quantity_2'] ?? 0,
                'license_id_2' => $data['license_id_2'] ?? null,
                'license_key_2' => $data['license_key_2'] ?? null,
                'license_key_type_2' => $data['license_key_type_2'] ?? null,

                'merchant_id' => $data['merchant_id'] ?? null,

                'monthly_amount' => $data['monthly_amount'] ?? 0,
                'monthly_vat_amount' => $data['monthly_vat_amount'] ?? 0,
                'newsletter_choice' => $data['newsletter_choice'] ?? null,
                'newsletter_choice_msg' => $data['newsletter_choice_msg'] ?? null,
                'next_payment_at' => $data['next_payment_at'] ?? null,
                'number_of_installments' => $data['number_of_installments'] ?? 0,

                // Novos campos adicionados
                'order_date' => $data['order_date'] ?? null,
                'order_date_time' => $data['order_date_time'] ?? null,
                'order_details_url' => $data['order_details_url'] ?? null,
                'order_id' => $data['order_id'] ?? null,
                'order_item_id' => $data['order_item_id'] ?? null,
                'order_item_id_2' => $data['order_item_id_2'] ?? null,
                'order_time' => $data['order_time'] ?? null,
                'order_type' => $data['order_type'] ?? null,
                'orderform_id' => $data['orderform_id'] ?? null,

                'order_status' => $data['order_status'] ?? null,
                'payment_method' => $data['payment_method'] ?? null,
                'payment_status' => $data['payment_status'] ?? null,
                'product_category_id' => $data['product_category_id'] ?? null,
                'product_description' => $data['product_description'] ?? null,
                'product_id' => $data['product_id'] ?? null,
                'product_name' => $data['product_name'] ?? null,
                'product_price' => $data['product_price'] ?? 0,
                'product_quantity' => $data['product_quantity'] ?? 0,
                'product_vat' => $data['product_vat'] ?? 0,

                // Campos adicionais para produtos
                'product_id_2' => $data['product_id_2'] ?? null,
                'product_name_2' => $data['product_name_2'] ?? null,
                'product_name_3' => $data['product_name_3'] ?? null,
                'product_name_4' => $data['product_name_4'] ?? null,

                'recurring_amount' => $data['recurring_amount'] ?? 0,
                'recurring_interval' => $data['recurring_interval'] ?? null,
                'status' => $data['status'] ?? null,
                'total_amount' => $data['total_amount'] ?? 0,
                'total_vat_amount' => $data['total_vat_amount'] ?? 0,
                'transaction_date' => $data['transaction_date'] ?? null,
                'transaction_id' => $data['transaction_id'] ?? null,
                'transaction_type' => $data['transaction_type'] ?? null,
                'vat_id' => $data['vat_id'] ?? null,
                'zip' => $data['zip'] ?? null,
            ]);

            // Verificar se o 'user_id' está presente no payload e notificar o usuário, se possível
            if (isset($data['user_id'])) {
                $user = User::find($data['user_id']);
                if ($user) {
                    $user->notify(new NewOrderNotification($order));  // Envia a notificação
                }
            }

            return response()->json(['message' => 'Order created successfully', 'order' => $order], 200);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error creating order: ' . $e->getMessage());
            return response()->json(['message' => 'Bad Request: ' . $e->getMessage()], 400);
        }
    }
}
