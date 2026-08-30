<?php
session_start();
$loggedIn = !empty($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="google-site-verification" content="75cLfg8jmlZauuINjYMd8aSL4zJ2dvFaOBHqW_WseVM" />


    <title>KASHI TIMEPIECES | Timeless Luxury</title>

    <meta
        name="description"
        content="Discover premium watches designed for timeless style and modern living."
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<!-- ================= SIGN IN / LOGIN ================= -->

<div class="auth-overlay" id="authOverlay">

    <div class="auth-box">

        <button class="auth-close" id="authClose">
            ×
        </button>

        <!-- LOGIN -->

        <div class="auth-content" id="loginContent">

            <p class="eyebrow">WELCOME BACK</p>

            <h2>Sign In</h2>

            <p class="auth-subtitle">
                Sign in to continue your shopping experience.
            </p>

            <form id="loginForm" action="login.php" method="POST">

                <div class="input-group">

                    <label>Email Address</label>

                    <input
                        type="email"
                        name="email"
                        id="loginEmail"
                        placeholder="Enter your email"
                        required
                    >

                </div>

                <div class="input-group">

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        id="loginPassword"
                        placeholder="Enter your password"
                        required
                    >

                </div>

                <button type="submit" name="login" class="auth-btn">
                    Sign In
                </button>

            </form>

            <p class="auth-switch">

                Don't have an account?

                <button id="showRegister">
                    Create Account
                </button>

            </p>

        </div>


        <!-- REGISTER -->

        <div class="auth-content hidden" id="registerContent">

            <p class="eyebrow">JOIN KASHI</p>

            <h2>Create Account</h2>

            <p class="auth-subtitle">
                Create your account to start shopping.
            </p>

            <form id="registerForm" action="signup.php" method="POST">

                <div class="input-group">
                    <label>Full Name</label>
                    <input
                        type="text"
                        name="name"
                        id="registerName"
                        placeholder="Your full name"
                        required
                    >
                </div>

                <div class="input-group">
                    <label>Email Address</label>
                    <input
                        type="email"
                        name="email"
                        id="registerEmail"
                        placeholder="Your email"
                        required
                    >
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" id="registerPassword" placeholder="Create password" minlength="6" required>
                </div>
                <div class="input-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm password" minlength="6" required>
                </div>

                <button type="submit" name="signup" class="auth-btn">
                    Create Account
                </button>

            </form>

            <p class="auth-switch">

                Already have an account?

                <button id="showLogin">
                    Sign In
                </button>

            </p>

        </div>

    </div>

</div>

<!-- ================= NAVBAR ================= -->

<header class="navbar" id="navbar">

    <a href="#home" class="logo">
        KASHI<span>TIMEPIECES</span>
    </a>

    <nav class="nav-links" id="navLinks">

        <a href="#home">Home</a>
        <a href="#collection">Collection</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>

    </nav>

    <div class="nav-actions">

        <a class="icon-btn" href="admin/login.php" title="Admin Panel">
            Admin
        </a>

        <button class="icon-btn cart-btn" id="cartBtn">
            Cart <span id="cartCount">0</span>
        </button>

<?php if ($loggedIn): ?>
            <span class="user-greeting">Hi, <?= htmlspecialchars($userName) ?></span>
            <a class="icon-btn" href="logout.php">Logout</a>
        <?php else: ?>
            <button class="icon-btn" id="openAuthBtn">Sign In</button>
        <?php endif; ?>

        <button class="menu-btn" id="menuBtn">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>

</header>


<!-- ================= HERO ================= -->

<section class="hero" id="home">

    <div class="hero-content reveal">

        <p class="eyebrow">
            THE ART OF TIME
        </p>

        <h1>
            Timeless style.<br>
            <span>Modern precision.</span>
        </h1>

        <p class="hero-text">
            Discover carefully selected timepieces designed
            to elevate every moment.
        </p>

        <div class="hero-buttons">

            <a href="#collection" class="primary-btn">
                Explore Collection
            </a>

            <a href="#about" class="secondary-btn">
                Our Story
            </a>

        </div>

    </div>

    <div class="hero-watch reveal">

        <div class="watch-glow"></div>

        <img
            src="https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=1000&q=85"
            alt="Luxury wrist watch"
        >

    </div>

</section>


<!-- ================= FEATURES ================= -->

<section class="features">

    <div class="feature reveal">
        <h3>Premium Design</h3>
        <p>Elegant details created for modern lifestyles.</p>
    </div>

    <div class="feature reveal">
        <h3>Curated Collection</h3>
        <p>Selected styles for every personality.</p>
    </div>

    <div class="feature reveal">
        <h3>Timeless Style</h3>
        <p>Designed to remain stylish beyond trends.</p>
    </div>

</section>


<!-- ================= COLLECTION ================= -->

<section class="collection section" id="collection">

    <div class="section-heading reveal">

        <p class="eyebrow">
            OUR COLLECTION
        </p>

        <h2>
            Find your signature timepiece
        </h2>

        <p>
            Explore our carefully curated collection.
        </p>

    </div>


    <!-- FILTERS -->

    <div class="filters reveal">

        <button class="filter-btn active" data-category="all">
            All
        </button>

        <button class="filter-btn" data-category="men">
            Men
        </button>

        <button class="filter-btn" data-category="women">
            Women
        </button>

        <button class="filter-btn" data-category="classic">
            Classic
        </button>

        <button class="filter-btn" data-category="sport">
            Sport
        </button>

    </div>


    <!-- PRODUCTS -->

    <div class="products-grid" id="productsGrid"></div>

</section>


<!-- ================= FEATURED BANNER ================= -->

<section class="featured-banner reveal">

    <div class="banner-content">

        <p class="eyebrow">
            THE SIGNATURE SERIES
        </p>

        <h2>
            Made for moments<br>
            that matter.
        </h2>

        <a href="#collection" class="primary-btn">
            Discover More
        </a>

    </div>

</section>


<!-- ================= ABOUT ================= -->

<section class="about section" id="about">

    <div class="about-image reveal">

        <img
            src="https://images.unsplash.com/photo-1539874754764-5a96559165b0?auto=format&fit=crop&w=900&q=85"
            alt="Classic luxury watch"
        >

    </div>

    <div class="about-content reveal">

        <p class="eyebrow">
            OUR PHILOSOPHY
        </p>

        <h2>
            Time is more than a number.
        </h2>

        <p>
            At KASHIF WATCHES, we believe a watch is not simply
            an instrument for measuring time. It is an expression
            of character, taste and individuality.
        </p>

        <p>
            Our collection focuses on clean design, refined
            aesthetics and timeless style.
        </p>

        <a href="#collection" class="text-link">
            Explore our collection →
        </a>

    </div>

</section>


<!-- ================= NEWSLETTER ================= -->

<section class="newsletter reveal" id="contact">

    <div>

        <p class="eyebrow">
            STAY IN THE LOOP
        </p>

        <h2>
            Discover what's next.
        </h2>

        <p>
            Join our mailing list for new collections and special offers.
        </p>

    </div>

    <form id="newsletterForm">

        <input
            type="email"
            id="emailInput"
            name="email"
            placeholder="Your email address"
            required
        >

        <button type="submit">
            Subscribe
        </button>

    </form>

</section>
<!-- ================= COMPLAINT BOX ================= -->

<section class="complaint-section" id="complaint">

    <div class="complaint-container">

        <div class="complaint-heading">

            <p class="eyebrow">
                CUSTOMER SUPPORT
            </p>

            <h2>
                Have a complaint?
            </h2>

            <p>
                We value your experience. Tell us what went wrong
                and our team will look into it.
            </p>

        </div>


        <form class="complaint-form" id="complaintForm">

            <div class="complaint-row">

                <div class="complaint-field">

                    <label for="complaintName">
                        Your Name
                    </label>

                    <input
                        type="text"
                        id="complaintName"
                        name="name"
                        placeholder="Enter your name"
                        required
                    >

                </div>


                <div class="complaint-field">

                    <label for="complaintEmail">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="complaintEmail"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >

                </div>

            </div>


            <div class="complaint-field">

                <label for="complaintSubject">
                    Subject
                </label>

                <input
                    type="text"
                    id="complaintSubject"
                    placeholder="What is your complaint about?"
                    required
                >

            </div>


            <div class="complaint-field">

                <label for="complaintMessage">
                    Your Complaint
                </label>

                <textarea
                    id="complaintMessage"
                    name="message"
                    rows="6"
                    placeholder="Write your complaint here..."
                    required
                ></textarea>

            </div>


            <button
                type="submit"
                class="complaint-btn"
            >
                Submit Complaint
            </button>

        </form>

    </div>

</section>

<!-- ================= FOOTER ================= -->

<footer>

    <div class="footer-main">

        <div class="footer-brand">

            <h2>
                KASHI<span>TIMEPIECES</span>
            </h2>

            <p>
                Timeless style. Modern precision.
            </p>

        </div>

        <div class="footer-column">

            <h4>Explore</h4>

            <a href="#home">Home</a>
            <a href="#collection">Collection</a>
            <a href="#about">About</a>

        </div>

        <div class="footer-column">

            <h4>Categories</h4>

            <a href="#collection">Men</a>
            <a href="#collection">Women</a>
            <a href="#collection">Classic</a>
            <a href="#collection">Sport</a>

        </div>

        <div class="footer-column">

            <h4>Contact</h4>

            <a href="mailto:kashifsaid2005@gmail.com" class="footer-social-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                kashifsaid2005@gmail.com
            </a>

            <a href="https://www.instagram.com/kashif_qaisrani1/" target="_blank" rel="noopener noreferrer" class="footer-social-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                Instagram
            </a>

            <a href="https://www.facebook.com/kashif.baloch.167189" target="_blank" rel="noopener noreferrer" class="footer-social-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                Facebook
            </a>

        </div>

    </div>

    <div class="footer-bottom">

        <p>
            &copy;  KASHI TIMEPIECES
        </p>

        <p>
            GET IN TOUCH WITH US
        </p>

    </div>

</footer>


<!-- ================= CART SIDEBAR ================= -->

<div class="cart-overlay" id="cartOverlay"></div>

<aside class="cart-sidebar" id="cartSidebar">

    <div class="cart-header">

        <h2>
            Your Cart
        </h2>

        <button id="closeCart">
            ×
        </button>

    </div>

    <div class="cart-items" id="cartItems">

        <p class="empty-cart">
            Your cart is empty.
        </p>

    </div>

    <div class="cart-footer">

        <div class="cart-total">

            <span>Total</span>

            <strong id="cartTotal">
                Rs. 0
            </strong>

        </div>

        <button class="checkout-btn" id="checkoutBtn">
            Proceed to Checkout
        </button>

    </div>

</aside>


<!-- ================= PRODUCT MODAL ================= -->

<div class="modal-overlay" id="productModal">

    <div class="product-modal">

        <button class="modal-close" id="modalClose">
            ×
        </button>

        <div id="modalContent"></div>

    </div>

</div>


<!-- ================= TOAST ================= -->

<div class="toast" id="toast">
    Added to cart
</div>


<!-- ================= BACK TO TOP ================= -->

<button class="back-top" id="backTop">
    ↑
</button>


<script>window.KASHI_AUTH = <?= $loggedIn ? 'true' : 'false' ?>;</script>
<script src="assets/js/script.js"></script>

</body>
</html>