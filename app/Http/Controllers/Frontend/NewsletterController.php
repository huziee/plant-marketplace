<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsletterSubscribeRequest;
use App\Models\NewsletterSubscriber;

class NewsletterController extends Controller
{
    public function subscribe(NewsletterSubscribeRequest $request)
    {
        $email = strtolower($request->validated()['email']);

        $subscriber = NewsletterSubscriber::where('email', $email)->first();

        if ($subscriber) {
            if ($subscriber->status === 'unsubscribed') {
                $subscriber->update([
                    'status' => 'active',
                    'subscribed_at' => now(),
                    'unsubscribed_at' => null,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Welcome back! Your subscription has been reactivated.',
                ]);
            }

            return response()->json([
                'status' => 'info',
                'message' => 'You are already subscribed to our newsletter.',
            ]);
        }

        NewsletterSubscriber::create([
            'email' => $email,
            'status' => 'active',
            'source' => $request->input('source', 'website_footer'),
            'subscribed_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you for subscribing to Plantora weekly notes!',
        ]);
    }
}
