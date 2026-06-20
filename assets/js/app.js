fetch('http://127.0.0.1:8000/api/v1/dashboard/summary')
    .then(response => response.json())
    .then(data => {

        document.getElementById('total-products').innerText =
            data.total_products;

        document.getElementById('total-orders').innerText =
            data.total_orders;

        document.getElementById('total-revenue').innerText =
            data.total_revenue_cents;

        document.getElementById('low-stock').innerText =
            data.low_stock_items;

    })
    .catch(error => {
        console.error('Error:', error);
    });