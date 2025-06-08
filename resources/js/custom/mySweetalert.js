import Swal from 'sweetalert2';
document.querySelector(".do-logout").onclick = function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "Are you sure you want to log out? Any unsaved changes may be lost.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#757575",
        confirmButtonText: "Yes, logout!",
    }).then((result) => {
        if (result.isConfirmed) {
            this.closest("form").submit();
        }
    });
};

document.querySelectorAll(".btn-order-details").forEach(function(btn){
    btn.addEventListener('click', function(){
        const order = JSON.parse(this.getAttribute('data-order'));
        let productsHtml = "<ul>";
        order.products.forEach(function(product) {
            productsHtml += `<li> <strong>${product.product_name}</strong> (Qty: ${product.quantity}) <br> Store: ${product.store_name}</li>`;
        });
        productsHtml += "</ul>";

        Swal.fire({
            title: "Order Details",
            html: `
                <p><strong>Customer: </strong> ${order.customer}</p>
                <p><strong>Order In: </strong> ${order.order_in}</p>
                <p><strong>Total Amount: </strong> ${order.total_amount}</p>
                <p><strong>Products: </strong> ${productsHtml}</p>
            `,
            icon: "info",
            showCloseButton: true,
            allowOutsideClick: true,
            showConfirmButton: false,
        });
    })
});

document.querySelectorAll(".clear-form-btn").forEach(function(btn){
    btn.addEventListener('click', function(e){
        e.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to clear the form?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#757575",
            confirmButtonText: "Yes, clear!",
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest("form").reset();
            }
        });
    });
});