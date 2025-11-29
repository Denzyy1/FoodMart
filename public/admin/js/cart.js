document.addEventListener('DOMContentLoaded', function() {

    let cart = JSON.parse(localStorage.getItem('foodmart_cart')) || [];

    const cartToggleBtn = document.getElementById('cartToggleBtn');
    const cartCloseBtn = document.getElementById('cartCloseBtn');
    const cartPanel = document.getElementById('cartPanel');
    const cartOverlay = document.getElementById('cartOverlay');
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    const cartCountBadge = document.getElementById('cartCountBadge');
    const cartSubtotal = document.getElementById('cartSubtotal');
    const cartTotalPrice = document.getElementById('cartTotalPrice');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const clearCartBtn = document.getElementById('clearCartBtn');

    function openCart() {
        if (cartPanel) {
            cartPanel.style.transform = 'translateX(0)';
        }
        if (cartOverlay) {
            cartOverlay.style.opacity = '0.5';
            cartOverlay.style.visibility = 'visible';
        }
        document.body.style.overflow = 'hidden';
    }

    function closeCart() {
        if (cartPanel) {
            cartPanel.style.transform = 'translateX(100%)';
        }
        if (cartOverlay) {
            cartOverlay.style.opacity = '0';
            cartOverlay.style.visibility = 'hidden';
        }
        document.body.style.overflow = '';
    }

    function saveCart() {
        localStorage.setItem('foodmart_cart', JSON.stringify(cart));
    }

    function calculateTotals() {
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        return { subtotal, total: subtotal };
    }

    function updateCartUI() {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        
        if (cartCountBadge) {
            cartCountBadge.textContent = totalItems;
        }
        
        if (cartItemsContainer) {
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = '<p class="text-muted text-center my-5">Your cart is empty.</p>';
                if (checkoutBtn) checkoutBtn.disabled = true;
            } else {
                if (checkoutBtn) checkoutBtn.disabled = false;
                let html = '';
                cart.forEach((item, index) => {
                    html += `
                        <div class="cart-item d-flex align-items-center mb-3 pb-3 border-bottom" data-index="${index}">
                            <img src="${item.image}" alt="${item.name}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-1 fw-bold" style="font-size: 14px;">${item.name}</h6>
                                <div class="d-flex align-items-center">
                                    <div class="input-group input-group-sm" style="width: 100px;">
                                        <button class="btn btn-outline-secondary cart-qty-minus" type="button" data-index="${index}">-</button>
                                        <input type="text" class="form-control text-center cart-qty-input" value="${item.quantity}" data-index="${index}" readonly>
                                        <button class="btn btn-outline-secondary cart-qty-plus" type="button" data-index="${index}">+</button>
                                    </div>
                                    <span class="ms-2 text-success fw-bold">$${(item.price * item.quantity).toFixed(2)}</span>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-outline-danger ms-2 cart-item-remove" data-index="${index}">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </button>
                        </div>
                    `;
                });
                cartItemsContainer.innerHTML = html;
            }
        }

        const totals = calculateTotals();
        if (cartSubtotal) {
            cartSubtotal.textContent = '$' + totals.subtotal.toFixed(2);
        }
        if (cartTotalPrice) {
            cartTotalPrice.textContent = '$' + totals.total.toFixed(2);
        }
    }

    function addToCart(productId, name, price, image, quantity) {
        const existingIndex = cart.findIndex(item => item.id === productId);
        
        if (existingIndex > -1) {
            cart[existingIndex].quantity += quantity;
        } else {
            cart.push({
                id: productId,
                name: name,
                price: parseFloat(price),
                image: image,
                quantity: quantity
            });
        }
        
        saveCart();
        updateCartUI();
        openCart();
        showToast(`${name} added to cart!`);
    }

    function updateCartItemQuantity(index, change) {
        if (cart[index]) {
            cart[index].quantity += change;
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
            saveCart();
            updateCartUI();
        }
    }

    function removeFromCart(index) {
        if (cart[index]) {
            const itemName = cart[index].name;
            cart.splice(index, 1);
            saveCart();
            updateCartUI();
            showToast(`${itemName} removed from cart`);
        }
    }

    function clearCart() {
        cart = [];
        saveCart();
        updateCartUI();
        showToast('Cart cleared');
    }

    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'position-fixed bottom-0 end-0 m-3 p-3 bg-dark text-white rounded shadow';
        toast.style.zIndex = '9999';
        toast.style.animation = 'fadeIn 0.3s ease';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }

    if (cartToggleBtn) {
        cartToggleBtn.addEventListener('click', openCart);
    }
    
    if (cartCloseBtn) {
        cartCloseBtn.addEventListener('click', closeCart);
    }
    
    if (cartOverlay) {
        cartOverlay.addEventListener('click', closeCart);
    }

    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function() {
            if (cart.length > 0 && confirm('Are you sure you want to clear your cart?')) {
                clearCart();
            }
        });
    }

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            if (cart.length > 0) {
                window.location.href = '/checkout';
            }
        });
    }

    if (cartItemsContainer) {
        cartItemsContainer.addEventListener('click', function(e) {
            const target = e.target.closest('button');
            if (!target) return;

            const index = parseInt(target.dataset.index);

            if (target.classList.contains('cart-qty-minus')) {
                updateCartItemQuantity(index, -1);
            } else if (target.classList.contains('cart-qty-plus')) {
                updateCartItemQuantity(index, 1);
            } else if (target.classList.contains('cart-item-remove')) {
                removeFromCart(index);
            }
        });
    }

  
    document.addEventListener('click', function(e) {
        const target = e.target.closest('button');
        if (!target) return;

        const productItem = target.closest('.product-item');
        if (!productItem) return;

        const quantityInput = productItem.querySelector('.product-quantity');
        if (!quantityInput) return;

        let quantity = parseInt(quantityInput.value) || 1;

        if (target.classList.contains('quantity-left-minus')) {
            e.preventDefault();
            if (quantity > 1) {
                quantityInput.value = quantity - 1;
            }
        } else if (target.classList.contains('quantity-right-plus')) {
            e.preventDefault();
            if (quantity < 99) {
                quantityInput.value = quantity + 1;
            }
        }
    });


    document.addEventListener('click', function(e) {
        const addBtn = e.target.closest('.add-to-cart-btn');
        if (!addBtn) return;

        e.preventDefault();
        
        const productItem = addBtn.closest('.product-item');
        if (!productItem) return;

        const productId = productItem.dataset.productId;
        const name = productItem.dataset.productName;
        const price = productItem.dataset.productPrice;
        const image = productItem.dataset.productImage;
        const quantityInput = productItem.querySelector('.product-quantity');
        const quantity = parseInt(quantityInput.value) || 1;

        addToCart(productId, name, price, image, quantity);
        
       
        quantityInput.value = 1;
    });

    
    updateCartUI();

   
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(20px); }
        }
        .add-to-cart-btn {
            transition: all 0.2s ease;
        }
        .add-to-cart-btn:hover {
            background-color: #198754 !important;
            color: white !important;
            border-radius: 4px;
        }
        .cart-item {
            transition: all 0.2s ease;
        }
        .cart-item:hover {
            background-color: #f8f9fa;
        }
    `;
    document.head.appendChild(style);
});
