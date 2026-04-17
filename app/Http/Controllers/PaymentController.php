<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Plan;
use App\Models\Subscription;

class PaymentController extends Controller
{
    public function pay($id)
    {
        $plan = Plan::findOrFail($id);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $order = $api->order->create([
            'receipt' => 'order_'.time(),
            'amount' => $plan->price * 100, // paisa
            'currency' => 'INR'
        ]);

        return view('payment.razorpay', [
            'order' => $order,
            'plan' => $plan,
            'user' => auth()->user(),
            'key'  => env('RAZORPAY_KEY')
        ]);
    }

    public function success(Request $request)
    {
        $plan = Plan::find($request->plan_id);
        $school = auth()->user()->school;

        // 🔥 ACTIVATE PLAN
        Subscription::where('school_id',$school->id)
            ->update(['status'=>'expired']);

        Subscription::create([
            'school_id' => $school->id,
            'plan_id' => $plan->id,
            'start_date' => now(),
            'end_date' => now()->addDays($plan->duration),
            'status' => 'active',
            'amount' => $plan->price
        ]);

        $school->update([
            'student_limit' => $plan->student_limit,
            'teacher_limit' => $plan->teacher_limit,
        ]);

        return redirect()->route('school_admin.dashboard')
            ->with('success','✅ Payment successful & plan activated');
    }
}