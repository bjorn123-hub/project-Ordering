<?php
session_start();

// Menu items definition
$menuItems = [
    'Regular Burger' => ['price' => 6.00, 'img' => 'images/Buger(1).jpg'],
    'Spaghetti' => ['price' => 6.00, 'img' => 'images/spaghetti.jpg'],
    'Cheesy Burger w/ Egg' => ['price' => 7.50, 'img' => 'images/cheesy_burger.jpg'],
    'Mini Donuts' => ['price' => 3.50, 'img' => 'images/mini_donuts.jpg'],
];

// Check if 'add_to_cart' or 'Order' was clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['add_to_cart']) || isset($_POST['Order']))) {
    $item = $_POST['item']; // Get item name

    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add or update item in the cart
    if (isset($_SESSION['cart'][$item])) {
        $_SESSION['cart'][$item]['quantity'] += 1; // Increment quantity if item is already in the cart
    } else {
        $_SESSION['cart'][$item] = [
            'name' => $item,
            'price' => $menuItems[$item]['price'],
            'quantity' => 1
        ]; // Add item with default quantity of 1
    }

    $_SESSION['message'] = $item . " was added to your cart!";
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Check if 'remove_from_cart' was clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_cart'])) {
    $item = $_POST['item']; // Get item name

    // Remove or decrease quantity
    if (isset($_SESSION['cart'][$item])) {
        if ($_SESSION['cart'][$item]['quantity'] > 1) {
            $_SESSION['cart'][$item]['quantity'] -= 1; // Decrease quantity by 1 if more than 1
        } else {
            unset($_SESSION['cart'][$item]); // Remove item if quantity is 1
        }
        $_SESSION['message'] = $item . " quantity was decreased!";
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Checkout process
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $totalPrice = 0;

    // Calculate total price of items
    foreach ($_SESSION['cart'] as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    // Clear cart after checkout
    $_SESSION['cart'] = [];
    $_SESSION['message'] = "Your order has been placed! Total: $" . number_format($totalPrice, 2);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F5DEB3;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #FFF8DC;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #4B3E2F;
        }

        .message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .menu-items {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .menu-item {
            background: #FFF;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            width: calc(45% - 20px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .menu-item img {
            max-width: 100%;
            border-radius: 5px;
        }

        .checkout-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #BC9F82;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .checkout-btn:hover {
            background-color: #A88771;
        }

        .cart-items ul {
            list-style: none;
            padding: 0;
        }

        .cart-items ul li {
            padding: 10px;
            margin: 5px 0;
            background-color: #FFF;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-total {
            text-align: center;
            margin-top: 20px;
        }

        .quantity-control {
            display: inline-block;
            margin-left: 10px;
        }

        .quantity-control button {
            background-color: #BC9F82;
            border: none;
            padding: 5px 10px;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }

        .quantity-control button:hover {
            background-color: #A88771;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cart</h2>

        <!-- Display confirmation message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message">
                <?php 
                echo htmlspecialchars($_SESSION['message']);
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>

        <div class="menu-items">
            <?php foreach ($menuItems as $name => $details): ?>
                <div class="menu-item">
                    <h3><?php echo htmlspecialchars($name); ?></h3>
                    <img src="<?php echo htmlspecialchars($details['img']); ?>" alt="<?php echo htmlspecialchars($name); ?>">
                    <p>Price: $<?php echo number_format($details['price'], 2); ?></p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" name="item" value="<?php echo htmlspecialchars($name); ?>">
                        <button type="submit" name="Order" class="checkout-btn">Order</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Your Cart</h2>
        <div class="cart-items">
            <ul>
                <?php if (empty($_SESSION['cart'])): ?>
                    <li>Your cart is empty.</li>
                <?php else: ?>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <li>
                            <span><?php echo htmlspecialchars($item['name']); ?></span>
                            - $<?php echo htmlspecialchars(number_format($item['price'], 2)); ?>
                            x <?php echo htmlspecialchars($item['quantity']); ?>
                            = $<?php echo htmlspecialchars(number_format($item['price'] * $item['quantity'], 2)); ?>

                            <div class="quantity-control">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="item" value="<?php echo htmlspecialchars($item['name']); ?>">
                                    <button type="submit" name="add_to_cart">+</button>
                                </form>

                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="item" value="<?php echo htmlspecialchars($item['name']); ?>">
                                    <button type="submit" name="remove_from_cart">-</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="cart-total">
                <h3>Total Price: $<?php
                    $totalPrice = 0;
                    foreach ($_SESSION['cart'] as $item) {
                        $totalPrice += $item['price'] * $item['quantity'];
                    }
                    echo number_format($totalPrice, 2);
                ?></h3>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">   
                    <button type="submit" class="checkout-btn" name="checkout">Checkout</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>