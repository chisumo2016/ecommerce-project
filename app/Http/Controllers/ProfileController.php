<?php

namespace App\Http\Controllers;

use App\Enums\AddressType;
use App\Http\Requests\ProfileRequest;

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

        $shippingAddress = $customer->shippingAddress ?:    new CustomerAddress(['type' => AddressType::Shipping]);
        $billingAddress  = $customer->billingAddress  ?:    new CustomerAddress(['type' => AddressType::Billing]);

        //dd($customer, $shippingAddress->attributesToArray(), $billingAddress, $billingAddress->customer);

        $countries = Country::query()->orderBy('name')->get();

        return view('profile.edit', compact(
            'customer',
                    'user',
                    'shippingAddress',
                    'billingAddress',
                    'countries'));
    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post(ProfileRequest $request)
    {

       $CustomerData = $request->validated();
       $shippingData = $CustomerData['shipping'];
       $billingData  = $CustomerData['billing'];

       /** @var \App\Models\User $user*/
        $user = $request->user();

        /** @var \App\Models\Customer $customer*/
        $customer = $user->customer;

        $customer->update($CustomerData);

        if ($customer->shippingAddress){
            $customer->shippingAddress->update($shippingData);

        }else{
            $shippingData['customer_id'] = $customer->user_id;
            $shippingData['type'] = AddressType::Shipping->value;
            /**Create*/
            CustomerAddress::create($shippingData);

        }
        if ($customer->billingAddress ){
            $customer->billingAddres->update($billingData);

        }else{

            $billingData['customer_id'] = $customer->user_id;
            $billingData['type'] = AddressType::Billing->value;
            /**Create*/
            CustomerAddress::create($billingData);
        }

        $request->session()->flash('flash_message','Profile was successfully updated');

        return  redirect()->route('profile.edit');
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
