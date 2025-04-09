<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    // O construtor agora aceita um objeto Order
    public function __construct(public Order $order)
    {
        // Nenhuma lógica adicional aqui
    }

    public function via($notifiable)
    {
        return ['database']; // Notificação via banco de dados (pode adicionar outros canais como 'mail' se necessário)
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Novo pedido recebido! O pedido {$this->order->id} foi registrado.",
            'order_id' => $this->order->id,
            'order_amount' => $this->order->amount, // Supondo que o campo `amount` seja o total do pedido
            'order_status' => $this->order->status, // Adapte conforme o campo que armazena o status do pedido
            'order_date' => $this->order->order_date, // Adapte conforme o campo que armazena a data do pedido
        ];
    }
}
