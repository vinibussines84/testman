<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('add_url');
            $table->string('address_city');
            $table->string('address_company')->nullable();
            $table->string('address_country');
            $table->string('address_country_name');
            $table->string('address_first_name');
            $table->string('address_id');
            $table->string('address_last_name');
            $table->string('address_mobile_no')->nullable();
            $table->string('address_phone_no')->nullable();
            $table->string('address_salutation')->nullable();
            $table->string('address_salutation_name')->nullable();
            $table->string('address_state');
            $table->string('address_street');
            $table->string('address_street2')->nullable();
            $table->string('address_street_name')->nullable();
            $table->string('address_street_number');
            $table->string('address_tax_id')->nullable();
            $table->string('address_title')->nullable();
            $table->string('address_zipcode');
            
            $table->decimal('amount', 10, 2);
            $table->decimal('amount_affiliate', 10, 2)->default(0);
            $table->decimal('amount_brutto', 10, 2);
            $table->decimal('amount_credited', 10, 2)->default(0);
            $table->decimal('amount_fee', 10, 2)->default(0);
            $table->decimal('amount_main_affiliate', 10, 2)->default(0);
            $table->decimal('amount_netto', 10, 2);
            $table->decimal('amount_partner', 10, 2)->default(0);
            $table->decimal('amount_payout', 10, 2);
            $table->decimal('amount_provider', 10, 2);
            $table->decimal('amount_vat', 10, 2)->default(0);
            $table->decimal('amount_vendor', 10, 2);
            
            $table->string('api_mode');
            $table->string('billing_city');
            $table->string('billing_company')->nullable();
            $table->string('billing_country');
            $table->string('billing_first_name');
            $table->string('billing_id');
            $table->string('billing_last_name');
            $table->string('billing_mobile_no')->nullable();
            $table->string('billing_phone_no')->nullable();
            $table->string('billing_salutation')->nullable();
            $table->string('billing_salutation_name')->nullable();
            $table->string('billing_state');
            $table->string('billing_status');
            $table->string('billing_street');
            $table->string('billing_street2')->nullable();
            $table->string('billing_street_name')->nullable();
            $table->string('billing_street_number');
            $table->string('billing_tax_id')->nullable();
            $table->string('billing_title')->nullable();
            $table->string('billing_type');
            $table->string('billing_zipcode');
            
            // Outras colunas que são parte do payload
            $table->string('buyer_address_city');
            $table->string('buyer_address_company')->nullable();
            $table->string('buyer_address_country');
            $table->string('buyer_address_id');
            $table->string('buyer_address_mobile_no')->nullable();
            $table->string('buyer_address_phone_no')->nullable();
            $table->string('buyer_address_state');
            $table->string('buyer_address_street');
            $table->string('buyer_address_street2')->nullable();
            $table->string('buyer_address_tax_id')->nullable();
            $table->string('buyer_address_zipcode');
            
            $table->string('buyer_email');
            $table->string('buyer_first_name');
            $table->string('buyer_id');
            $table->string('buyer_language');
            $table->string('buyer_last_name');
            
            $table->string('campaignkey')->nullable();
            $table->string('click_id')->nullable();
            $table->string('country');
            $table->string('currency');
            $table->string('custom')->nullable();
            $table->string('custom_key')->nullable();
            $table->string('customer_affiliate_name');
            $table->string('customer_affiliate_promo_url');
            
            $table->string('email');
            $table->decimal('first_amount', 10, 2);
            $table->string('first_billing_interval');
            $table->decimal('first_vat_amount', 10, 2);
            
            $table->string('invoice_url');
            $table->string('ipn_config_id');
            $table->string('ipn_config_product_ids');
            $table->string('ipn_version');
            $table->string('is_gdpr_country');
            $table->string('is_payment_planned');
            $table->integer('item_count');
            $table->string('language');
            $table->string('license_data_email_2');
            $table->string('license_data_first_name_2');
            $table->string('license_data_last_name_2');
            $table->string('license_data_product_2');
            $table->integer('license_data_quantity_2');
            $table->string('license_id_2');
            $table->string('license_key_2');
            $table->string('license_key_type_2');
            $table->string('merchant_id');
            $table->string('merchant_name');
            
            // Outros campos adicionais do payload
            $table->decimal('monthly_amount', 10, 2);
            $table->decimal('monthly_vat_amount', 10, 2);
            $table->string('newsletter_choice');
            $table->string('newsletter_choice_msg');
            $table->string('next_payment_at');
            $table->integer('number_of_installments');
            $table->string('order_date');
            $table->string('order_date_time');
            $table->string('order_details_url');
            $table->string('order_id');
            $table->string('order_item_id');
            $table->string('order_item_id_2');
            $table->string('order_time');
            $table->string('order_type');
            $table->string('orderform_id')->nullable();
            $table->decimal('other_amounts', 10, 2);
            $table->string('other_billing_intervals');
            $table->decimal('other_vat_amounts', 10, 2);
            $table->string('parent_transaction_id')->nullable();
            $table->string('pay_method');
            $table->integer('pay_sequence_no');
            $table->string('payment_id');
            $table->string('payplan_id');
            $table->decimal('product_amount', 10, 2);
            $table->decimal('product_amount_2', 10, 2);
            $table->string('product_delivery_type');
            $table->string('product_delivery_type_2');
            $table->string('product_id');
            $table->string('product_id_2');
            $table->string('product_language');
            $table->string('product_language_2');
            $table->string('product_name');
            $table->string('product_name_2');
            $table->string('product_name_intern');
            $table->string('product_name_intern_2');
            $table->decimal('product_netto_amount', 10, 2);
            $table->decimal('product_netto_amount_2', 10, 2);
            $table->decimal('product_shipping_amount', 10, 2);
            $table->decimal('product_shipping_amount_2', 10, 2);
            $table->decimal('product_txn_amount', 10, 2);
            $table->decimal('product_txn_amount_2', 10, 2);
            $table->decimal('product_txn_netto_amount', 10, 2);
            $table->decimal('product_txn_netto_amount_2', 10, 2);
            $table->decimal('product_txn_shipping', 10, 2);
            $table->decimal('product_txn_shipping_2', 10, 2);
            $table->decimal('product_txn_vat_amount', 10, 2);
            $table->decimal('product_txn_vat_amount_2', 10, 2);
            $table->decimal('product_vat_amount', 10, 2);
            $table->decimal('product_vat_amount_2', 10, 2);
            $table->string('purchase_key');
            $table->integer('quantity');
            $table->integer('quantity_2');
            $table->string('rebill_stop_noted_at')->nullable();
            $table->string('rebilling_can_be_stopped_at')->nullable();
            $table->string('rebilling_stop_url')->nullable();
            $table->string('receipt_url');
            $table->string('refund_days');
            $table->string('renew_url');
            $table->string('request_refund_url');
            $table->string('salesteam_id')->nullable();
            $table->string('salesteam_name')->nullable();
            $table->string('support_url');
            $table->string('switch_pay_interval_url');
            $table->string('tag')->nullable();
            $table->string('tag_2')->nullable();
            $table->string('tags')->nullable();
            $table->string('trackingkey')->nullable();
            $table->decimal('transaction_amount', 10, 2);
            $table->string('transaction_currency');
            $table->string('transaction_date');
            $table->string('transaction_id');
            $table->string('transaction_time');
            $table->string('transaction_type');
            $table->decimal('transaction_vat_amount', 10, 2);
            $table->string('upgrade_key');
            $table->integer('upsell_no');
            $table->string('upsell_path')->nullable();
            $table->string('variant_id');
            $table->string('variant_name');
            $table->decimal('vat_amount', 10, 2);
            $table->decimal('vat_rate', 10, 2);
            $table->string('voucher_code')->nullable();
            $table->string('function_call');
            $table->string('event');
            $table->string('event_label');
            $table->string('sha_sign');
            
            $table->timestamps();
        });
    }
        /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
