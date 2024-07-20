document.addEventListener('DOMContentLoaded', () => {
  const rentButtons = document.querySelectorAll('.rent-btn');
  const cartCount = document.getElementById('cart-count');
  const cartItemsModal = document.getElementById('cart-items-modal');
  const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
  const cartButton = document.getElementById('cart-button');

  let cart = [];

  function renderCartModal() {
    cartItemsModal.innerHTML = '';
    cart.forEach(item => {
      const li = document.createElement('li');
      li.classList.add('list-group-item', 'd-flex', 'align-items-center', 'justify-content-between');
      li.innerHTML = `
        <span>${item.title}</span>
        <div class="d-flex align-items-center">
          <button class="btn btn-secondary btn-sm btn-decrease mr-2" data-id="${item.id}">-</button>
          <span class="quantity">${item.quantity}</span>
          <button class="btn btn-secondary btn-sm btn-increase ml-2" data-id="${item.id}">+</button>
        </div>
      `;
      cartItemsModal.appendChild(li);
    });

    const decreaseButtons = cartItemsModal.querySelectorAll('.btn-decrease');
    const increaseButtons = cartItemsModal.querySelectorAll('.btn-increase');

    decreaseButtons.forEach(button => {
      button.addEventListener('click', () => {
        const id = button.getAttribute('data-id');
        updateCartItemQuantity(id, -1);
      });
    });

    increaseButtons.forEach(button => {
      button.addEventListener('click', () => {
        const id = button.getAttribute('data-id');
        updateCartItemQuantity(id, 1);
      });
    });
  }

  function updateCartItemQuantity(id, change) {
    const item = cart.find(item => item.id === id);
    if (item) {
      item.quantity += change;
      if (item.quantity <= 0) {
        cart = cart.filter(item => item.id !== id);
      }
    }
    renderCartModal();
    updateCartCount();
  }

  function addToCart(id, title) {
    const existingItem = cart.find(item => item.id === id);
    if (existingItem) {
      existingItem.quantity++;
    } else {
      cart.push({ id, title, quantity: 1 });
    }
    renderCartModal();
    updateCartCount();
  }

  function updateCartCount() {
    let totalCount = 0;
    cart.forEach(item => {
      totalCount += item.quantity;
    });
    cartCount.textContent = totalCount;
  }

  rentButtons.forEach(button => {
    button.addEventListener('click', () => {
      const card = button.closest('.card');
      const id = card.getAttribute('data-id');
      const title = card.querySelector('.card-title').textContent;
      addToCart(id, title);
    });
  });

  cartButton.addEventListener('click', () => {
    renderCartModal();
    cartModal.show();
  });
});