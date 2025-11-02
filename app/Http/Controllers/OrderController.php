namespace App\Http\Controllers;

use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Jobs\ProcessOrderJob;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        // Add context for this specific request
        Context::add('order_type', $request->input('type', 'standard'));
        Context::addHidden('payment_token', $request->input('payment_token'));

        Log::info('Order received.', ['order_amount' => $request->input('amount')]);

        // Dispatch job (inherits context)
        ProcessOrderJob::dispatch([
            'amount' => $request->input('amount'),
            'type' => $request->input('type')
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully!'
        ]);
    }
}
