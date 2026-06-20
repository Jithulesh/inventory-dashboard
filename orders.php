<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1 class="mb-4">Orders</h1>

    <a href="index.php" class="btn btn-primary mb-3">
        Dashboard
    </a>

    <table class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>Order Number</th>
                <th>Total Amount ($)</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody id="orders-table-body">

        </tbody>

    </table>

</div>

<script>

fetch('http://127.0.0.1:8000/api/v1/orders', {
    headers: {
        'X-API-TOKEN': 'inventory-secret-123'
    }
})
.then(response => response.json())
.then(data => {

    let html = '';

    data.forEach(order => {

        html += `
            <tr>
                <td>${order.id}</td>
                <td>${order.order_number}</td>
                <td>$ ${(order.total_amount_cents / 100).toFixed(2)}</td>
                <td>${order.status}</td>
            </tr>
        `;
    });

    document.getElementById(
        'orders-table-body'
    ).innerHTML = html;

});

</script>

</body>
</html>

