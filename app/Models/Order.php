<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewOrderNotification; // Importando a notificação
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory, Notifiable; // Certifique-se de que o trait Notifiable esteja presente

    // Defina a tabela caso seja diferente de 'orders'
    protected $table = 'orders';  // Caso a tabela tenha um nome diferente

    // Atributos que podem ser atribuídos em massa
    protected $fillable = [
        'add_url',
        'address_city',
        'address_company',
        'address_country',
        'address_country_name',
        'address_first_name',
        'address_id',
        'address_last_name',
        'address_mobile_no',
        'address_phone_no',
        'address_salutation',
        'address_salutation_name',
        'address_state',
        'address_street',
        'address_street2',
        'address_street_name',
        'address_street_number',
        'address_tax_id',
        'address_title',
        'address_zipcode',
        'affiliate_id',
        'affiliate_name',
        'amount',
        'amount_affiliate',
        'amount_brutto',
        'amount_credited',
        'amount_fee',
        'amount_main_affiliate',
        'amount_netto',
        'amount_partner',
        'amount_payout',
        'amount_provider',
        'amount_vat',
        'amount_vendor',
        'api_mode',
        'billing_city',
        'billing_company',
        'billing_country',
        'billing_first_name',
        'billing_id',
        'billing_last_name',
        'billing_mobile_no',
        'billing_phone_no',
        'billing_salutation',
        'billing_salutation_name',
        'billing_state',
        'billing_status',
        'billing_street',
        'billing_street2',
        'billing_street_name',
        'billing_street_number',
        'billing_tax_id',
        'billing_title',
        'billing_type',
        'billing_zipcode',
        'buyer_address_city',
        'buyer_address_company',
        'buyer_address_country',
        'buyer_address_id',
        'buyer_address_mobile_no',
        'buyer_address_phone_no',
        'buyer_address_state',
        'buyer_address_street',
        'buyer_address_street2',
        'buyer_address_tax_id',
        'buyer_address_zipcode',
        'buyer_email',
        'buyer_first_name',
        'buyer_id',
        'buyer_language',
        'buyer_last_name',
        'campaignkey',
        'click_id',
        'country',
        'currency',
        'custom',
        'custom_key',
        'customer_affiliate_name',
        'customer_affiliate_promo_url',
        'email',
        'first_amount',
        'first_billing_interval',
        'first_vat_amount',
        'has_custom_forms',
        'invoice_url',
        'ipn_config_id',
        'ipn_config_product_ids',
        'ipn_version',
        'is_gdpr_country',
        'is_payment_planned',
        'item_count',
        'language',
        'language_name',
        'license_accessdata_keys',
        'license_created_2',
        'license_data_email_2',
        'license_data_first_name_2',
        'license_data_last_name_2',
        'license_data_product_2',
        'license_data_quantity_2',
        'license_id_2',
        'license_key_2',
        'license_key_type_2',
        'merchant_id',
        'merchant_name',  // Certifique-se de que 'merchant_name' está aqui
        'monthly_amount',
        'monthly_vat_amount',
        'newsletter_choice',
        'newsletter_choice_msg',
        'next_payment_at',
        'number_of_installments',
        'order_date',
        'order_date_time',
        'order_details_url',
        'order_id',
        'order_item_id',
        'order_item_id_2',
        'order_time',
        'order_type',
        'orderform_id',
        'other_amounts',
        'other_billing_intervals',
        'other_vat_amounts',
        'parent_transaction_id',
        'pay_method',
        'pay_sequence_no',
        'payment_id',
        'payplan_id',
        'product_amount',
        'product_amount_2',
        'product_delivery_type',
        'product_delivery_type_2',
        'product_id',
        'product_id_2',
        'product_language',
        'product_language_2',
        'product_name',
        'product_name_2',
        'product_name_intern',
        'product_name_intern_2',
        'product_netto_amount',
        'product_netto_amount_2',
        'product_shipping_amount',
        'product_shipping_amount_2',
        'product_txn_amount',
        'product_txn_amount_2',
        'product_txn_netto_amount',
        'product_txn_netto_amount_2',
        'product_txn_shipping',
        'product_txn_shipping_2',
        'product_txn_vat_amount',
        'product_txn_vat_amount_2',
        'product_vat_amount',
        'product_vat_amount_2',
        'purchase_key',
        'quantity',
        'quantity_2',
        'rebill_stop_noted_at',
        'rebilling_can_be_stopped_at',
        'rebilling_stop_url',
        'receipt_url',
        'refund_days',
        'renew_url',
        'request_refund_url',
        'salesteam_id',
        'salesteam_name',
        'support_url',
        'switch_pay_interval_url',
        'tag',
        'tag_2',
        'tags',
        'trackingkey',
        'transaction_amount',
        'transaction_currency',
        'transaction_date',
        'transaction_id',
        'transaction_time',
        'transaction_type',
        'transaction_vat_amount',
        'upgrade_key',
        'upsell_no',
        'upsell_path',
        'variant_id',
        'variant_name',
        'vat_amount',
        'vat_rate',
        'voucher_code',
        'function_call',
        'event',
        'event_label',
        'sha_sign'
    ];

    protected static function boot()
    {
        parent::boot();

        // Evento para quando o pedido for criado
        static::created(function ($order) {
            // Recupera todos os usuários ativos (ou use outro critério, como 'is_admin')
            $users = \App\Models\User::where('is_active', true)->get(); // Exemplo de filtro
            foreach ($users as $user) {
                // Envia a notificação para cada usuário
                $user->notify(new NewOrderNotification($order)); // Envia a notificação
            }
        });
    }

    /**
     * Relacionamento: Cada pedido pertence a um usuário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class); // A relação pode ser configurada para o usuário que fez o pedido
    }
}
