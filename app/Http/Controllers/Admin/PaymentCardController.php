<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentCard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentCardController extends Controller
{
    public function index(Request $request)
    {
        $payment_cards = PaymentCard::orderBy("created_at", "desc")->paginate(10);
        return view("backend.payment-cards.payment-cards", ["payment_cards" => $payment_cards]);
    }
    public function show_create_form(Request $request)
    {
        return view('backend.payment-cards.create-payment-card');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'last_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'card_number' => 'required|digits_between:13,19|regex:/^\d+$/',
            'expiry_month' => 'required|integer|between:1,12',
            'expiry_year' => 'required|integer|min:' . date('Y') . '|max:' . (date('Y') + 10),
            'cvv' => 'required|digits:3',
            'card_status' => [
                'required',
                Rule::in(['active', 'inactive'])
            ],
        ]);

        $payment_card = new PaymentCard();
        $payment_card->first_name = strtolower(trim($request->first_name));
        $payment_card->last_name = strtolower(trim($request->last_name));
        $payment_card->card_number = $request->card_number;
        $payment_card->expiry_month = $request->expiry_month;
        $payment_card->expiry_year = $request->expiry_year;
        $payment_card->cvv = $request->cvv;
        $payment_card->is_active = $request->card_status === 'active' ? '1' : '0';

        $saved = $payment_card->save();
        if ($saved)
            return back()->with('success', 'Card successfully added');
        return redirect()->back()->with('error', 'Something went wrong...');

    }
    public function show_update_form(PaymentCard $payment_card, Request $request)
    {
        if (!$payment_card) {
            return redirect()->back()->with('error', 'Card not found');
        }
        return view('backend.payment-cards.update-payment-card', ['card' => $payment_card]);
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'last_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'card_number' => 'required|digits_between:13,19|regex:/^\d+$/',
            'expiry_month' => 'required|integer|between:1,12',
            'expiry_year' => 'required|integer|min:' . date('Y') . '|max:' . (date('Y') + 10),
            'cvv' => 'required|digits:3',
            'card_status' => [
                'required',
                Rule::in(['active', 'inactive'])
            ],
        ]);
        $payment_card = PaymentCard::find($request->payment_card_id);
        if (!$payment_card) {
            return redirect()->route('backend.payment_card.view')->with('error', 'Payment Card not found');
        }
        $payment_card->first_name = trim($request->first_name);
        $payment_card->last_name = trim($request->last_name);
        $payment_card->card_number = $request->card_number;
        $payment_card->expiry_month = $request->expiry_month;
        $payment_card->expiry_year = $request->expiry_year;
        $payment_card->cvv = $request->cvv;
        $payment_card->is_active = $request->card_status === 'active' ? '1' : '0';

        $updated = $payment_card->save();
        if ($updated)
            return redirect()->route('backend.payment_card.view')->with('success', 'Card successfully updated');
        return redirect()->back()->with('error', 'Something went wrong...');


    }
    public function delete(Request $request)
    {
        $card = PaymentCard::find($request->payment_card_id);
        if (!$card)
            return redirect()->route("backend.payment_card.view")->with('error', 'Card not found');
        $deleted = $card->delete();
        if ($deleted) {
            $key = 'success';
            $message = 'Card successfully deleted';
        } else {
            $key = 'error';
            $message = 'Something went wrong';
        }

        return redirect()->route("backend.payment_card.view")->with($key, $message);
    }
}
