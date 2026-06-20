<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Products</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Inventory Dashboard</a>

        <div class="navbar-nav">
            <a class="nav-link text-white" href="index.php">Home</a>
            <a class="nav-link text-white" href="products.php">Inventory</a>
            <a class="nav-link text-white" href="orders.php">Orders</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <h2 class="mb-4">Available Products</h2>

    <div class="row" id="product-container">

    </div>

</div>

<!-- Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Place Order
                </h5>
            </div>

            <div class="modal-body">

                <input
                    type="hidden"
                    id="selectedProductId"
                >

                <label class="form-label">
                    Quantity
                </label>

                <input
                    type="number"
                    id="quantity"
                    class="form-control"
                    value="1"
                    min="1"
                >

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-success"
                    onclick="placeOrder()"
                >
                    Place Order
                </button>

            </div>

        </div>

    </div>

</div>

<script>

let modal;

window.onload = function () {

    modal = new bootstrap.Modal(
        document.getElementById('orderModal')
    );

    loadProducts();
};

function loadProducts()
{
    fetch('http://127.0.0.1:8000/api/v1/products', {
    headers: {
        'X-API-TOKEN': 'inventory-secret-123'
    }
})
    .then(response => response.json())
    .then(data => {

        let html = '';

        data.data.forEach(product => {

let imageName = '';

switch(product.id)
{
case 1: imageName = 'dell_laptop.jpg'; break;
case 2: imageName = 'HP_laptop.jpg'; break;
case 3: imageName = 'lenovo_laptop.jpg'; break;
case 4: imageName = 'logitech_mouse.jpg'; break;
case 5: imageName = 'hp_mouse.jpg'; break;
case 6: imageName = 'mechanical_keyboard.jpg'; break;
case 7: imageName = 'wireless_keyboard.jpg'; break;
case 8: imageName = 'lg_monitor.jpg'; break;
case 9: imageName = 'samsung_monitor.jpg'; break;
case 10: imageName = 'canon_printer.jpg'; break;
case 11: imageName = 'hp_printer.jpg'; break;
case 12: imageName = 'pen_drive.jpg'; break;
case 13: imageName = 'external_hard_disk.jpg'; break;
case 14: imageName = 'samsung_ssd.jpg'; break;
case 15: imageName = 'webcam.jpg'; break;
case 16: imageName = 'jbl_headphones.jpg'; break;
case 17: imageName = 'bluetooth_speaker.jpg'; break;
case 18: imageName = 'wifi_router.jpg'; break;
case 19: imageName = 'ethernet_cable.jpg'; break;
case 20: imageName = 'laptop_charger.jpg'; break;
}

            html += `
            <div class="col-md-3 mb-4">

                <div class="card h-100 shadow-sm">

                    <img
                        src="assets/images/${imageName}"
                        class="card-img-top"
                        style="height:220px;object-fit:contain;background:#ffffff;padding:10px;"
                    >

                    <div class="card-body">

                        <h5 class="card-title">
                            ${product.name}
                        </h5>

                        <p>
                             $ ${(product.price_cents / 100).toFixed(2)}
                        </p>

                        <span class="badge bg-success">
                            Stock: ${product.stock_quantity}
                        </span>

                        <br><br>

${product.stock_quantity > 0
? `<button
        class="btn btn-primary"
        onclick="openOrderModal(${product.id})"
    >
        Buy Now
    </button>`
: `<button
        class="btn btn-danger"
        disabled
    >
        Out Of Stock
    </button>`
}

                    </div>

                </div>

            </div>
            `;
        });

        document.getElementById(
            'product-container'
        ).innerHTML = html;
    });
}

function openOrderModal(productId)
{
    document.getElementById(
        'selectedProductId'
    ).value = productId;

    document.getElementById(
        'quantity'
    ).value = 1;

    modal.show();
}

function placeOrder()
{
    const productId =
        document.getElementById(
            'selectedProductId'
        ).value;

    const quantity =
        document.getElementById(
            'quantity'
        ).value;

    fetch('http://127.0.0.1:8000/api/v1/orders', {

        method: 'POST',

headers: {
    'Content-Type': 'application/json',
    'X-API-TOKEN': 'inventory-secret-123'
},
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })

    })
    .then(response => response.json())
    .then(data => {

        alert(data.message);

        modal.hide();

        loadProducts();
    })
    .catch(error => {

        alert('Order failed');

        console.log(error);
    });
}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>