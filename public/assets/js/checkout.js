
			// Cargar el carrito de la compra desde el almacenamiento local
document.addEventListener("DOMContentLoaded", function () {
let cart = JSON.parse(localStorage.getItem("cart")) || [];
let listaCarrito = document.getElementById("cart-items");
let totalElement = document.getElementById("total-price");
let cartCount = document.getElementById("cart-count");
let total = 0;

// Si el carrito está vacío, mostrar un mensaje
if (cart.length === 0) {
listaCarrito.innerHTML = "<li class='list-group-item text-center'>Tu carrito está vacío.</li>";
totalElement.innerText = "€0.00";
cartCount.innerText = "0";
return;
}

// Limpiar el carrito antes de volver a cargar los elementos
listaCarrito.innerHTML = "";
cart.forEach((phone, index) => {
total += parseFloat(phone.price);
let li = document.createElement("li");
li.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center");
li.innerHTML = `
                <div class="d-flex align-items-center">
                    <img src="${
phone.image_url
}" alt="${
phone.name
}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                    <div>${
phone.name
} - ${
phone.price
}</div>
                </div>
            `;
listaCarrito.appendChild(li);
});
// Actualizar el precio total y la cantidad de elementos en el carrito
totalElement.innerText = `€${
total.toFixed(2)
}`;
cartCount.innerText = cart.length;
});

// Enviar el formulario de pago y mostrar el modal de confirmación

document.getElementById("checkout-form").addEventListener("submit", function (event) {
event.preventDefault();

// Validar si todos los campos están completos
let form = event.target;
if (! form.checkValidity()) {
form.classList.add('was-validated');
return;
}


// Si el formulario es válido, mostrar el modal de confirmación
let confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
confirmationModal.show();

// Ocultar el modal después de 10 segundos y redirigir a la página de inicio
setTimeout(() => {
confirmationModal.hide();
localStorage.removeItem("cart");
window.location.href = "/home"; // Redirigir a la página de inicio después de 10 segundos
}, 10000);
});