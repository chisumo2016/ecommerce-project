<?php

namespace App\Http\Controllers;

use App\Enums\AddressType;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Country;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        /** @var \App\Models\Customer $customer */
        $customer = $user->customer;

        $shippingAddress = $customer->shippingAddress ?: new CustomerAddress(['type' => AddressType::Shipping]);
        $billingAddress  = $customer->billingAddress  ?:    new CustomerAddress(['type' => AddressType::Billing]);

        dd($customer, $shippingAddress->attributesToArray(), $billingAddress, $billingAddress->customer);

        $countries = Country::query()->orderBy('name')->get();

        return view('profile.edit', compact('customer', 'user',
            'shippingAddress',
            'billingAddress', 'countries'));



    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
