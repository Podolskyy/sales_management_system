function toggleDrawer() {
    const drawer = document.getElementById('drawer');
    drawer.classList.toggle('open');
}

function openModal() {
    document.getElementById("custom-modal").style.display = "flex";
}

function closeModal() {
    document.getElementById("custom-modal").style.display = "none";
}

function confirmAddToCart() {
    const productId = document.getElementById("product-id-input").value.trim();
    if (!productId) {
        alert("Please enter a valid Product ID.");
        return;
    }

    // Call the addToCart functionality with the entered Product ID
    addToCartFloating(productId);

    // Close the modal
    closeModal();
}

function addToCartFloating(productId) {
    fetch('addtocart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `productId=${encodeURIComponent(productId)}&quantity=1`,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 'success') {
                alert(data.message || "Product successfully added to the cart!");
            } else {
                alert(data.message || "Failed to add product to cart. Please try again.");
            }
        })
        .catch((error) => {
            console.error("Error adding product to cart:", error);
            alert("An error occurred while adding the product to the cart.");
        });
}

function searchProducts() {
    const searchInput = document.getElementById("search-input").value.trim();

    if (searchInput === "") {
        alert("Please enter a search term.");
        return;
    }

    const ordersContainer = document.querySelector(".orders");
    ordersContainer.innerHTML = "<p>Searching...</p>";

    fetch(`product.php?search=${encodeURIComponent(searchInput)}`)
        .then((response) => response.text())
        .then((html) => {
            ordersContainer.innerHTML = html;
        })
        .catch((err) => {
            console.error("Error searching for products:", err);
            ordersContainer.innerHTML = "<p>Error loading search results. Please try again.</p>";
        });
}

function addToCart(productId) {
    fetch('addtocart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `productId=${productId}&quantity=1`,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 'success') {
                alert(data.message);
            } else {
                alert('Failed to add product to cart. Please try again.');
            }
        })
        .catch((err) => {
            console.error('Error adding to cart:', err);
            alert('An error occurred. Please try again.');
        });
}

function viewCart() {
    fetch('viewcart.php')
        .then((response) => response.json())
        .then((cart) => {
            console.log(cart); // Display cart items
            let cartHtml = '<ul>';
            for (const [productId, quantity] of Object.entries(cart)) {
                cartHtml += `<li>Product ID: ${productId}, Quantity: ${quantity}</li>`;
            }
            cartHtml += '</ul>';
            document.getElementById('cart-container').innerHTML = cartHtml;
        })
        .catch((err) => {
            console.error('Error fetching cart:', err);
        });
}

function loadDetails(productId) {
    console.log(`Loading details for product ID: ${productId}`); // Debugging statement

    const productCard = document.getElementById(`product-${productId}`);
    if (!productCard) {
        console.error(`Product card not found for ID: ${productId}`);
        return;
    }

    if (productCard.querySelector('.additional-details')) {
        console.log(`Details already loaded for product ID: ${productId}`);
        return;
    }

    const detailsContainer = document.createElement('div');
    detailsContainer.classList.add('additional-details');
    detailsContainer.innerHTML = "<p>Loading details...</p>";
    productCard.appendChild(detailsContainer);

    fetch(`productdetails.php?id=${productId}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            console.log("Received data:", data); // Debugging statement
            if (data.error) {
                detailsContainer.innerHTML = `<p>Error: ${data.error}</p>`;
                return;
            }
            detailsContainer.innerHTML = `
                <p class='product-ingredients'><strong>Ingredients:</strong> ${data.product_ingredients}</p>
                <p class='product-nutrition'><strong>Nutritional Info:</strong> ${data.product_details}</p>
            `;
        })
        .catch((err) => {
            console.error("Error loading product details:", err);
            detailsContainer.innerHTML = "<p>Error loading details. Please try again.</p>";
        });
}

function handleKeyPress(event) {
    if (event.key === "Enter") {
        searchProducts();
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".tab");
    const ordersContainer = document.querySelector(".orders");

    function loadOrders(category) {
        ordersContainer.innerHTML = "<p>Loading...</p>";
        fetch(`product.php?category=${category}`)
            .then((response) => response.text())
            .then((html) => {
                ordersContainer.innerHTML = html;
            })
            .catch((err) => {
                console.error("Error fetching orders:", err);
                ordersContainer.innerHTML = "<p>Error loading orders. Please try again.</p>";
            });
    }

    tabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            document.querySelector(".tab.active").classList.remove("active");
            tab.classList.add("active");

            const category = tab.getAttribute("data-category");
            loadOrders(category);
        });
    });

    // Load "All" products by default
    loadOrders("All");
});
