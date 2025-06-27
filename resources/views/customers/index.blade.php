@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Customers</h1>
        <a href="{{ route('customers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Customer</a>
    </div>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Family Name</th>
                <th class="py-2 px-4 border-b">Address</th>
                <th class="py-2 px-4 border-b">Adults</th>
                <th class="py-2 px-4 border-b">Children</th>
                <th class="py-2 px-4 border-b">Babies</th>
                <th class="py-2 px-4 border-b">Special Wishes</th>
                <th class="py-2 px-4 border-b">Active</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $customer->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $customer->family_name }}</td>
                    <td class="py-2 px-4 border-b">{{ $customer->address }}</td>
                    <td class="py-2 px-4 border-b">{{ $customer->amount_adults }}</td>
                    <td class="py-2 px-4 border-b">{{ $customer->amount_children }}</td>
                    <td class="py-2 px-4 border-b">{{ $customer->amount_babies }}</td>
                    <td class="py-2 px-4 border-b">{{ $customer->special_wishes }}</td>
                    <td class="py-2 px-4 border-b">
                        @if($customer->is_active)
                            <span class="text-green-600 font-semibold">Yes</span>
                        @else
                            <span class="text-red-600 font-semibold">No</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b flex space-x-2">
                        <a href="{{ route('customers.show', $customer) }}" class="text-blue-500 hover:underline">View</a>
                        <a href="{{ route('customers.edit', $customer) }}" class="text-yellow-500 hover:underline">Edit</a>
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="py-4 px-4 text-center text-gray-500">No customers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
