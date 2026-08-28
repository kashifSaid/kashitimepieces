/* =========================
   PRODUCTS
========================= */

const products = [
    {
        id: 1,
        name: "Midnight Classic",
        price: 3499,
        category: "men",
        type: "classic",
        image: "https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=900&q=85",
        description: "A refined black timepiece designed for effortless everyday elegance."
    },
    {
        id: 2,
        name: "Silver Heritage",
        price: 4299,
        category: "men",
        type: "classic",
        image: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=85",
        description: "Clean lines and timeless detailing make this an ideal formal companion."
    },
    {
        id: 3,
        name: "Golden Elite",
        price: 6999,
        category: "women",
        type: "classic",
        image: "https://images.unsplash.com/photo-1508057198894-247b23fe5ade?auto=format&fit=crop&w=900&q=85",
        description: "Elegant gold-inspired styling created for sophisticated occasions."
    },
    {
        id: 4,
        name: "Urban Steel",
        price: 5499,
        category: "men",
        type: "sport",
        image: "https://images.unsplash.com/photo-1533139502658-0198f920d8e8?auto=format&fit=crop&w=900&q=85",
        description: "A modern steel design that transitions naturally from work to weekend."
    },
    {
        id: 5,
        name: "Rose Signature",
        price: 5999,
        category: "women",
        type: "classic",
        image: "https://images.unsplash.com/photo-1523170335258-f5ed11844a49?auto=format&fit=crop&w=900&q=85",
        description: "A delicate statement piece with a refined contemporary silhouette."
    },
    {
        id: 6,
        name: "Black Chronograph",
        price: 7499,
        category: "men",
        type: "sport",
        image: "https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?auto=format&fit=crop&w=900&q=85",
        description: "Bold proportions and a sporty character for modern everyday wear."
    },
    {
        id: 7,
        name: "Pearl Minimal",
        price: 4799,
        category: "women",
        type: "classic",
        image: "https://images.unsplash.com/photo-1495857000853-fe46c8aefc30?auto=format&fit=crop&w=900&q=85",
        description: "Minimal styling with a sophisticated finish for any occasion."
    },
    {
        id: 8,
        name: "Executive Steel",
        price: 12999,
        category: "men",
        type: "classic",
        image: "https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=800&q=85",
        description: "A premium-inspired steel silhouette made to stand out."
    }
];

/* =========================
   DOM ELEMENTS
========================= */

const productsGrid = document.getElementById("productsGrid");
const cartCount = document.getElementById("cartCount");
const cartItems = document.getElementById("cartItems");
const cartTotal = document.getElementById("cartTotal");

/* =========================
   CART & GLOBAL VARS
========================= */

let cart = [];
let pendingProductId = null;
let pendingCartOpen = false;

function formatPrice(price) {
    return "Rs. " + price.toLocaleString("en-PK");
}

function updateCart() {
    if (!cartCount || !cartItems || !cartTotal) return;

    cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
    cartItems.innerHTML = "";

    if (cart.length === 0) {
        cartItems.innerHTML = `<p class="empty-cart">Your cart is empty.</p>`;
        cartTotal.textContent = "Rs. 0";
        return;
    }

    let total = 0;

    cart.forEach(item => {
        total += item.price * item.quantity;

        const div = document.createElement("div");
        div.className = "cart-item";
        div.innerHTML = `
            <img src="${item.image}" alt="${item.name}">
            <div>
                <h4>${item.name}</h4>
                <p>${formatPrice(item.price)}</p>
                <div class="qty-controls">
                    <button onclick="changeQuantity(${item.id}, -1)">-</button>
                    <span>${item.quantity}</span>
                    <button onclick="changeQuantity(${item.id}, 1)">+</button>
                </div>
            </div>
            <button class="remove-item" onclick="removeFromCart(${item.id})">Remove</button>
        `;
        cartItems.appendChild(div);
    });

    cartTotal.textContent = formatPrice(total);
}

function addToCart(id) {
    if (!isLoggedIn()) {
        pendingProductId = id;
        openAuth();
        return;
    }

    const product = products.find(item => item.id === id);
    if (!product) return;

    const existing = cart.find(item => item.id === id);

    if (existing) {
        existing.quantity++;
    } else {
        cart.push({ ...product, quantity: 1 });
    }

    updateCart();
    showToast(`${product.name} added to cart`);
    openCart();
}

function changeQuantity(id, change) {
    const item = cart.find(product => product.id === id);
    if (!item) return;

    item.quantity += change;

    if (item.quantity <= 0) {
        cart = cart.filter(product => product.id !== id);
    }

    updateCart();
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    updateCart();
    showToast("Product removed");
}

/* =========================
   PRODUCT DISPLAY
========================= */

function displayProducts(list) {
    if (!productsGrid) return;
    productsGrid.innerHTML = "";

    if (list.length === 0) {
        productsGrid.innerHTML = `
            <p style="grid-column:1/-1; text-align:center; color:#777; padding:50px;">
                No watches found.
            </p>
        `;
        return;
    }

    list.forEach((product, index) => {
        const card = document.createElement("article");
        card.className = "product-card";
        card.style.animationDelay = `${index * 0.08}s`;

        card.innerHTML = `
            <div class="product-image">
                <img src="${product.image}" alt="${product.name}" loading="lazy">
            </div>
            <div class="product-info">
                <span class="product-category">${product.category}</span>
                <h3>${product.name}</h3>
                <p class="product-price">${formatPrice(product.price)}</p>
                <div class="product-actions">
                    <button onclick="openProduct(${product.id})">View</button>
                    <button class="add-btn" onclick="addToCart(${product.id})">Add to Cart</button>
                </div>
            </div>
        `;
        productsGrid.appendChild(card);
    });
}

displayProducts(products);

/* =========================
   FILTER
========================= */

const filterButtons = document.querySelectorAll(".filter-btn");

filterButtons.forEach(button => {
    button.addEventListener("click", () => {
        filterButtons.forEach(btn => btn.classList.remove("active"));
        button.classList.add("active");

        const category = button.dataset.category;

        if (category === "all") {
            displayProducts(products);
            return;
        }

        const filtered = products.filter(
            product => product.category === category || product.type === category
        );

        displayProducts(filtered);
    });
});

/* =========================
   SEARCH
========================= */

const searchBtn = document.getElementById("searchBtn");
const searchOverlay = document.getElementById("searchOverlay");
const closeSearch = document.getElementById("closeSearch");
const searchInput = document.getElementById("searchInput");

if (searchBtn && searchOverlay) {
    searchBtn.addEventListener("click", () => {
        searchOverlay.classList.add("active");
        document.body.classList.add("no-scroll");
        if (searchInput) setTimeout(() => searchInput.focus(), 300);
    });
}

function closeSearchBox() {
    if (searchOverlay) {
        searchOverlay.classList.remove("active");
        document.body.classList.remove("no-scroll");
    }
}

if (closeSearch) closeSearch.addEventListener("click", closeSearchBox);

if (searchOverlay) {
    searchOverlay.addEventListener("click", event => {
        if (event.target === searchOverlay) closeSearchBox();
    });
}

if (searchInput) {
    searchInput.addEventListener("input", () => {
        const value = searchInput.value.toLowerCase().trim();

        if (!value) {
            displayProducts(products);
            return;
        }

        const filtered = products.filter(
            product =>
                product.name.toLowerCase().includes(value) ||
                product.category.toLowerCase().includes(value) ||
                (product.type && product.type.toLowerCase().includes(value))
        );

        displayProducts(filtered);
    });
}

/* =========================
   CART SIDEBAR
========================= */

const cartBtn = document.getElementById("cartBtn");
const cartSidebar = document.getElementById("cartSidebar");
const cartOverlay = document.getElementById("cartOverlay");
const closeCartBtn = document.getElementById("closeCart");

function openCart() {
    if (!isLoggedIn()) {
        pendingCartOpen = true;
        openAuth();
        return;
    }

    if (cartSidebar && cartOverlay) {
        cartSidebar.classList.add("active");
        cartOverlay.classList.add("active");
        document.body.classList.add("no-scroll");
    }
}

function closeCart() {
    if (cartSidebar && cartOverlay) {
        cartSidebar.classList.remove("active");
        cartOverlay.classList.remove("active");
        document.body.classList.remove("no-scroll");
    }
}

if (cartBtn) cartBtn.addEventListener("click", openCart);
if (closeCartBtn) closeCartBtn.addEventListener("click", closeCart);
if (cartOverlay) cartOverlay.addEventListener("click", closeCart);

/* =========================
   PRODUCT MODAL
========================= */

const productModal = document.getElementById("productModal");
const modalContent = document.getElementById("modalContent");
const modalClose = document.getElementById("modalClose");

function openProduct(id) {
    const product = products.find(item => item.id === id);
    if (!product || !modalContent || !productModal) return;

    modalContent.innerHTML = `
        <div class="modal-product">
            <img src="${product.image}" alt="${product.name}">
            <div class="modal-info">
                <span class="product-category">${product.category}</span>
                <h2>${product.name}</h2>
                <div class="modal-price">${formatPrice(product.price)}</div>
                <p>${product.description}</p>
                <button class="modal-add" onclick="addToCart(${product.id}); closeProductModal();">
                    Add to Cart
                </button>
            </div>
        </div>
    `;

    productModal.classList.add("active");
    document.body.classList.add("no-scroll");
}

function closeProductModal() {
    if (productModal) {
        productModal.classList.remove("active");
        document.body.classList.remove("no-scroll");
    }
}

if (modalClose) modalClose.addEventListener("click", closeProductModal);

if (productModal) {
    productModal.addEventListener("click", event => {
        if (event.target === productModal) closeProductModal();
    });
}

/* =========================
   TOAST
========================= */

let toastTimer;

function showToast(message) {
    let toastElement = document.getElementById('toast');
    if (!toastElement) return;

    toastElement.textContent = message;
    toastElement.classList.add("show");

    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
        toastElement.classList.remove("show");
    }, 2500);
}

/* =========================
   MOBILE MENU & NAVBAR
========================= */

const menuBtn = document.getElementById("menuBtn");
const navLinks = document.getElementById("navLinks");

if (menuBtn && navLinks) {
    menuBtn.addEventListener("click", () => {
        navLinks.classList.toggle("active");
    });

    navLinks.querySelectorAll("a").forEach(link => {
        link.addEventListener("click", () => {
            navLinks.classList.remove("active");
        });
    });
}

const navbar = document.getElementById("navbar");
const backTop = document.getElementById("backTop");

window.addEventListener("scroll", () => {
    if (navbar) {
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    }

    if (backTop) {
        if (window.scrollY > 600) {
            backTop.classList.add("show");
        } else {
            backTop.classList.remove("show");
        }
    }
});

if (backTop) {
    backTop.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
}

/* =========================
   NEWSLETTER & CHECKOUT
========================= */

const newsletterForm = document.getElementById("newsletterForm");

if (newsletterForm) {
    newsletterForm.addEventListener("submit", event => {
        event.preventDefault();
        const email = document.getElementById("emailInput");
        if (!email || !email.value.trim()) return;

        showToast("Thank you for subscribing.");
        email.value = "";
    });
}

const checkoutBtn = document.getElementById("checkoutBtn");

if (checkoutBtn) {
    checkoutBtn.addEventListener("click", () => {
        if (cart.length === 0) {
            showToast("Your cart is empty.");
            return;
        }
        showToast("Checkout will be available soon.");
    });
}

/* =========================
   AUTHENTICATION SYSTEM
========================= */

const authOverlay = document.getElementById("authOverlay");
const authClose = document.getElementById("authClose");
const loginContent = document.getElementById("loginContent");
const registerContent = document.getElementById("registerContent");
const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");
const showRegister = document.getElementById("showRegister");
const showLogin = document.getElementById("showLogin");

function isLoggedIn() {
    return localStorage.getItem("kashiLoggedIn") === "true";
}

function openAuth() {
    if (authOverlay) {
        authOverlay.classList.add("active");
        document.body.classList.add("no-scroll");
        showLoginForm();
    }
}

function closeAuth() {
    if (authOverlay) {
        authOverlay.classList.remove("active");
        document.body.classList.remove("no-scroll");
    }
}

function showLoginForm() {
    if (loginContent && registerContent) {
        loginContent.classList.remove("hidden");
        registerContent.classList.add("hidden");
    }
}

function showRegisterForm() {
    if (loginContent && registerContent) {
        loginContent.classList.add("hidden");
        registerContent.classList.remove("hidden");
    }
}

if (showRegister) {
    showRegister.addEventListener("click", (e) => {
        e.preventDefault();
        showRegisterForm();
    });
}

if (showLogin) {
    showLogin.addEventListener("click", (e) => {
        e.preventDefault();
        showLoginForm();
    });
}

if (authClose) authClose.addEventListener("click", closeAuth);

if (authOverlay) {
    authOverlay.addEventListener("click", event => {
        if (event.target === authOverlay) closeAuth();
    });
}

/* =========================
   LOGIN
========================= */

if (loginForm) {
    loginForm.addEventListener("submit", event => {
        event.preventDefault();

        const emailInput = document.getElementById("loginEmail");
        const passInput = document.getElementById("loginPassword");

        if (!emailInput || !passInput) return;

        const email = emailInput.value.trim();
        const password = passInput.value.trim();

        const savedUser = JSON.parse(localStorage.getItem("kashiUser"));

        if (!savedUser) {
            showToast("Account not found. Please create an account.");
            return;
        }

        if (email !== savedUser.email || password !== savedUser.password) {
            showToast("Invalid email or password.");
            return;
        }

        localStorage.setItem("kashiLoggedIn", "true");
        closeAuth();
        showToast(`Welcome back, ${savedUser.name}!`);

        if (pendingProductId !== null) {
            const productId = pendingProductId;
            pendingProductId = null;
            setTimeout(() => { addToCart(productId); }, 400);
            return;
        }

        if (pendingCartOpen) {
            pendingCartOpen = false;
            setTimeout(() => { openCart(); }, 400);
        }
    });
}

/* =========================
   REGISTER / SIGNUP (FIXED)
========================= */

if (registerForm) {
    registerForm.addEventListener("submit", async event => {
        event.preventDefault();

        const nameInput = document.getElementById("registerName");
        const emailInput = document.getElementById("registerEmail");
        const passwordInput = document.getElementById("registerPassword");

        const name = nameInput ? nameInput.value.trim() : "";
        const email = emailInput ? emailInput.value.trim() : "";
        const password = passwordInput ? passwordInput.value.trim() : "";

        if (!name || !email || !password) {
            showToast("Please fill all fields.");
            return;
        }

        const formData = new FormData(registerForm);
        formData.append('signup', '1');

        try {
            const response = await fetch('signup.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                const user = { name: name, email: email, password: password };
                localStorage.setItem("kashiUser", JSON.stringify(user));
                localStorage.setItem("kashiLoggedIn", "true");

                registerForm.reset();
                closeAuth();
                showToast(`Welcome to KASHI, ${name}!`);

                if (pendingProductId !== null) {
                    const productId = pendingProductId;
                    pendingProductId = null;
                    setTimeout(() => { addToCart(productId); }, 400);
                    return;
                }

                if (pendingCartOpen) {
                    pendingCartOpen = false;
                    setTimeout(() => { openCart(); }, 400);
                }
            } else {
                showToast(result.message || "Registration failed.");
            }
        } catch (error) {
            const user = { name: name, email: email, password: password };
            localStorage.setItem("kashiUser", JSON.stringify(user));
            localStorage.setItem("kashiLoggedIn", "true");

            registerForm.reset();
            closeAuth();
            showToast(`Welcome to KASHI, ${name}!`);
        }
    });
}

/* =========================
   LOGOUT
========================= */

const logoutBtn = document.getElementById('logoutBtn');

if (logoutBtn) {
    logoutBtn.addEventListener('click', () => {
        localStorage.clear();
        sessionStorage.clear();
        showToast('Successfully logged out!');
        setTimeout(() => {
            window.location.reload();
        }, 1200);
    });
}

/* =========================
   COMPLAINT FORM
========================= */

const complaintForm = document.getElementById("complaintForm");

if (complaintForm) {
    complaintForm.addEventListener("submit", event => {
        event.preventDefault();

        const name = document.getElementById("complaintName")?.value.trim();
        const subject = document.getElementById("complaintSubject")?.value.trim();
        const message = document.getElementById("complaintMessage")?.value.trim();

        if (!name || !subject || !message) {
            showToast("Please fill all fields.");
            return;
        }

        showToast("Your complaint has been submitted.");
        complaintForm.reset();
    });
}

/* =========================
   ESCAPE KEY & REVEAL
========================= */

document.addEventListener("keydown", event => {
    if (event.key === "Escape") {
        closeSearchBox();
        closeCart();
        closeProductModal();
        closeAuth();
    }
});

const revealElements = document.querySelectorAll(".reveal");

if (revealElements.length > 0) {
    const revealObserver = new IntersectionObserver(
        entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    revealObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12 }
    );

    revealElements.forEach(element => revealObserver.observe(element));
}