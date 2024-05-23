<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'subemail' => 'required|email',
            ]);
            $subscriber = new Subscriber();
            $subscriber->subemail = $validatedData['subemail'];
            if ($subscriber->save()) {
                return view('layout.sub');
            }
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->getMessageBag());
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
        return redirect()->back()->withErrors(['Failed to subscribe. Please try again.']);
    }
}
