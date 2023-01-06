<?php

namespace App\Http\Controllers\Api;

use App\Enums\AddressType;
use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerListResource;
use App\Http\Resources\CustomerResource;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $search         = request('search', '');
        $perPage        = request('per_page', 10);
        $sortField      = request('sort_field', 'updated_at');
        $sortDirection  = request('sort_direction', 'desc');

        $query = Customer::query()
            ->orderBy("customers.$sortField", $sortDirection);

        if ($search) {
            $query
                ->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
                ->join('users', 'customers.user_id', '=', 'users.id')
                ->orWhere('users.email', 'like', "%{$search}%")
                ->orWhere('customers.phone', 'like', "%{$search}%");
        }

        $paginator = $query->paginate($perPage);

        return  CustomerListResource::collection($paginator);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return CustomerResource
     */
    public function show(Customer $customer)
    {

        return  new  CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return CustomerResource
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $CustomerData = $request->validated();
        $CustomerData['updated_by'] = $request->user()->id;

        $CustomerData['status'] = $CustomerData['status'] ? CustomerStatus::Active->value : CustomerStatus::Disabled->value;

        $shippingData = $CustomerData['shippingAddress']; //billing/ to shippingAddress
        $billingData  = $CustomerData['billingAddress'];  //billing/ to billingAddress

        $customer->update($CustomerData);

        /**Checking if the Customer as shipping or billing address  create*/
        if ($customer->shippingAddress){
            $customer->shippingAddress->update($shippingData);

        }else{
            $shippingData['customer_id'] = $customer->user_id;
            $shippingData['type'] = AddressType::Shipping->value;

            /**Create ShippingData*/
            CustomerAddress::create($shippingData);

        }
        if ($customer->billingAddress ){
            $customer->billingAddress->update($billingData);

        }else{

            $billingData['customer_id'] = $customer->user_id;
            $billingData['type'] = AddressType::Billing->value;

            /**Create BillingData*/
            CustomerAddress::create($billingData);
        }

        return  new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return  response()->noContent();
    }


}
