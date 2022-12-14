<?php
 /** @var \Illuminate\Database\Eloquent\Collection $orders*/
?>
<x-app-layout>
    <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
        <h1 class="text-3xl font-bold mb-6">My Orders</h1>
        <div class="bg-white p-3 rounded-md shadow-md">
            <table class="table table-auto w-full">
                <thead class="border-b-2">
                <tr class="text-left">
                    <th>Order</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Sub Total</th>
                    <th>Items</th>
                    <th class="w-64">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                 <tr class="border-b">
                        <td>
                            <a
                                href="{{ route('order.show', $order) }}"
                                class="text-purple-600 hover:text-purple-500"
                            >
                                #{{ $order->id }}
                            </a>
                        </td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            <small class="text-white p-1 rounded
                                {{ $order->isPaid() ? 'bg-emerald-500' : 'bg-gray-500'}}">
                                {{ $order->status }}
                            </small>
                        </td>
                        <td>${{ $order->total_price }}</td>
                     <td class="py-1 px-2 whitespace-nowrap">{{ $order->items()->count() }} item(s)</td>
                     <td class="py-1 px-2 flex gap-2 w-[100px]">

                         @if (!$order->isPaid())
                             <form action="{{ route('checkout-order', $order) }}"  method="POST">
                                 @csrf
                                 <button
                                     class="flex items-center py-1 btn-primary whitespace-nowrap"
                                 >
                                     <svg
                                         xmlns="http://www.w3.org/2000/svg"
                                         class="h-5 w-5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2"
                                     >
                                         <path
                                             stroke-linecap="round"
                                             stroke-linejoin="round"
                                             d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                                         />
                                     </svg>
                                     Pay
                                 </button>
                             </form>
                         @endif
                     </td>
                 </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
