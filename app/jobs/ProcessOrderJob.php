namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Log;

class ProcessOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $orderData;

    public function __construct(array $orderData)
    {
        $this->orderData = $orderData;
    }

    public function handle()
    {
        // Scoped context: temporarily add extra info
        Context::scope(function () {
            Context::add('job_step', 'processing_payment');
            Log::info('Processing payment.', ['amount' => $this->orderData['amount']]);
        });

        // Stack example: track history of actions
        Context::push('order_actions', 'payment_processed');

        Log::info('Updating inventory.', ['order_type' => $this->orderData['type']]);
        Context::push('order_actions', 'inventory_updated');

        // Hidden stack example
        Context::push('hidden_actions', 'internal_audit', hidden: true);

        Log::info('Order completed.');
    }
}
