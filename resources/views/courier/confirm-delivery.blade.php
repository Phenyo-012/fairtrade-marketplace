<x-app-layout>

<h2>Courier Delivery Confirmation</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="/courier/confirm-delivery">
    @csrf

    <label>Delivery Code</label>
    <input type="text" name="delivery_code" required>

    <button type="submit">Confirm Delivery</button>
</form>

</x-app-layout>