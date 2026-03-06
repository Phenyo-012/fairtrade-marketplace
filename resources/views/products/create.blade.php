<h1>Add Product</h1>

<form method="POST" action="/products">
    @csrf

    <input type="text" name="name" placeholder="Product name" required>

    <textarea name="description" placeholder="Product description"></textarea>

    <input type="number" step="0.01" name="price" placeholder="Price" required>

    <input type="number" name="stock_quantity" placeholder="Stock quantity" required>

    <input type="text" name="category" placeholder="Category" required>

    <select name="condition">
        <option value="new">New</option>
        <option value="handmade">Handmade</option>
        <option value="quality_second_hand">Quality Second Hand</option>
    </select>

    <button type="submit">Create Product</button>

</form>