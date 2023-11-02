<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\Website;


class SubscriptionController extends Controller
{

    public function subscribe(Request $request, Website $website)
    {


        $validator = validator($request->all(), [
            'email' => 'required|email'
        ]);
        $email = $request->email;

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors(), 'errorCode' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Find the subscriber by email.
        $subscriber = Subscriber::firstOrCreate(['email' => $email]);



        // Check if the subscriber is already subscribed to the website.
        if ($subscriber->isSubscribedTo($website)) {
            return response()->json(['message' => 'Subscriber is already subscribed to this website', 'errorCode' => Response::HTTP_CONFLICT], Response::HTTP_CONFLICT);
        }

        // Perform the subscription.
        $subscription = new Subscription(['website_id' => $website->id]);
        $subscriber->subscriptions()->save($subscription);

        return response()->json(['message' => 'Subscriber subscribed to the website', 'website' => $website], Response::HTTP_CREATED);
    }
}
