let cart = JSON.parse(localStorage.getItem("cart")) || []; // Leer el carrito desde localStorage o usar un array vacío si no existe

function addToCart(phone) {
    // Agregar el producto al carrito
    cart.push(phone);
    
    // Actualizar la interfaz de usuario
    updateCartUI();
    
    // Guardar el carrito en localStorage
    saveCartToLocalStorage();
    
    // Mostrar el popup modal después de añadir el producto
    showCartModal(phone);
}

function updateCartUI() {
    let cartItems = document.getElementById("cart-items");
    let cartCount = document.getElementById("cart-count");
    let totalPrice = document.getElementById("total-price");
    let finalizarPagoBtn = document.getElementById("finalizar-pago"); // Obtén el botón de finalizar compra
    
    cartItems.innerHTML = "";
    let total = 0;

    cart.forEach((phone, index) => {
        total += parseFloat(phone.price);
        
        // Limitar nombre a 30 caracteres con "..."
        let truncatedName = phone.name.length > 25 ? phone.name.substring(0, 25) + "..." : phone.name;

        cartItems.innerHTML += `
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center w-100">
      <img src="${phone.image_url}" alt="${phone.name}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
      <div class="flex-grow-1 text-truncate" style="min-width: 0;">
        ${truncatedName} - ${phone.price}
      </div>
    </div>
    <button class="btn btn-outline-danger btn-sm remove-btn ms-2" data-index="${index}">
      <i class="fas fa-trash"></i>
    </button>
  </li>`;
    });

    cartCount.innerText = cart.length;
    totalPrice.innerText = `€${total.toFixed(2)}`;

    // Habilitar o deshabilitar el botón de finalizar compra dependiendo si el carrito está vacío
    if (cart.length === 0) {
        finalizarPagoBtn.disabled = true; // Deshabilitar
    } else {
        finalizarPagoBtn.disabled = false; // Habilitar
    }

    // Asignar evento a los botones de eliminar sin cerrar el dropdown
    document.querySelectorAll(".remove-btn").forEach(button => {
        button.addEventListener("click", function(event) {
            event.stopPropagation(); // Evita que se cierre el dropdown
            let index = this.getAttribute("data-index");
            removeFromCart(index);
        });
    });
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCartUI();
    saveCartToLocalStorage();
}

// Guardar el carrito en localStorage
function saveCartToLocalStorage() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

// Cerrar dropdown solo si se hace clic fuera de él y del icono del carrito
document.addEventListener("click", function(event) {
    let cartIcon = document.getElementById("cart-icon");
    let cartDropdown = document.getElementById("cart-dropdown");

    if (!cartIcon.contains(event.target) && !cartDropdown.contains(event.target)) {
        cartDropdown.classList.remove("show");
    }
});

// Inicializar el carrito al cargar la página
window.onload = function() {
    updateCartUI(); // Actualizar la UI con el carrito guardado
};

function showCartModal(phone) {
    // Obtener el modal y su cuerpo
    const modalBody = document.querySelector('.modal-body'); 

    // Tomar la traducción desde el HTML oculto
    const addedText = document.getElementById("addedToCartText").textContent.trim();

    // Insertar el contenido en el modal
    modalBody.innerHTML = `
        <div class="d-flex align-items-center">
            <img src="${phone.image_url}" alt="${phone.name}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover; margin-right: 10px;">
            <div>¡${phone.name} <strong>${addedText}</strong>!</div>
        </div>`;

    // Mostrar el modal de Bootstrap
    var cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
    cartModal.show();
}



