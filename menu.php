<?php
session_start();

// Menu items definition
$menuItems = [
    'Nachos' => ['price' => 5.00],
    'Regular Burger' => ['price' => 6.00],
    'Cheesy Burger w/ Egg' => ['price' => 7.50],
    'Mini Donuts' => ['price' => 3.50],
    'Spaghetti' => ['price' => 3.50],
];

// Check if an item has been posted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item'])) {
    $item = $_POST['item']; // Get the item name

    // Check if the item exists in the menu
    if (array_key_exists($item, $menuItems)) {
        // Initialize the cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add the item to the cart or increase its quantity
        if (isset($_SESSION['cart'][$item])) {
            $_SESSION['cart'][$item]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$item] = [
                'name' => $item,
                'price' => $menuItems[$item]['price'],
                'quantity' => 1
            ];
        }

        // Set a confirmation message
        $_SESSION['message'] = "$item has been added to your cart.";
    }

    // Redirect back to the menu page
    header('Location: menu.php');
    exit();
}

// Remove item from the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_item'])) {
    $item = $_POST['remove_item']; // Get the item name to remove

    // Check if the item is in the cart
    if (isset($_SESSION['cart'][$item])) {
        // Decrease quantity or remove if quantity is 1
        if ($_SESSION['cart'][$item]['quantity'] > 1) {
            $_SESSION['cart'][$item]['quantity'] -= 1; // Reduce the quantity
            $_SESSION['message'] = "One $item has been removed from your cart."; // Confirmation message
        } else {
            unset($_SESSION['cart'][$item]); // Remove the item from the cart
            $_SESSION['message'] = "$item has been removed from your cart."; // Confirmation message
        }
    }

    header('Location: menu.php');
    exit();
}

// Cancel the entire order
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_order'])) {
    unset($_SESSION['cart']); // Clear the cart
    $_SESSION['message'] = "Your order has been canceled."; // Confirmation message
    header('Location: menu.php');
    exit();
}

// Function to calculate total price
function calculateTotalPrice() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $cartItem) {
            $total += $cartItem['price'] * $cartItem['quantity'];
        }
    }
    return $total;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        /* Background color */
        body {
            background-color: #BC9F82;
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            color: white;
        }

        .menu-items {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .menu-column {
            display: flex;
            flex-direction: column;
            margin: 15px;
        }

        .menu-item {
            text-align: center;
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 200px;
            margin: 10px;
        }

        img {
            width: 150px;
            height: 150px;
            border-radius: 5px;
        }

        .menu-item button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #BC9F82;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .menu-item button:hover {
            background-color: #A88771;
        }

        .cart {
            margin: 20px;
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            margin-bottom: 10px;
        }

        .cart-total {
            margin-top: 20px;
            font-weight: bold;
        }

        .cancel-order-btn {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #BC9F82;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .cancel-order-btn:hover {
            background-color: #A88771;
        }

        .message {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
    <section class="food-menu">
        <h2>Menu</h2>
        
        <!-- Display Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        
        <form action="menu.php" method="POST">
            <div class="menu-items">
                <!-- First Column -->
                    <div class="menu-item">
                        <img src="images/regular_burger.jpg" alt="Regular Burger">
                        <h3>Regular Burger</h3>
                        <p>Price: $6.00</p>
                        <p>Grilled beef patty in a soft bun, simple and classic.</p>
                        <button type="submit" name="item" value="Regular Burger">Order Regular Burger</button>
                    </div>

                    <div class="menu-item">
                        <img src="images/regular_burger.jpg" alt="Regular Burger">
                        <h3>Spaghetti</h3>
                        <p>Price: $6.00</p>
                        <p>Pasta with tomato sauce</p>
                        <button type="submit" name="item" value="Spaghetti">Order Spaghetti</button>
                    </div>

                    <div class="menu-item">
                        <img src="images/cheesy_burger.jpg" alt="Cheesy Burger with Egg">
                        <h3>Cheesy Burger w/ Egg</h3>
                        <p>Price: $7.50</p>
                        <p>A burger with melted cheese and a fried egg.</p>
                        <button type="submit" name="item" value="Cheesy Burger w/ Egg">Order Cheesy Burger w/ Egg</button>
                    </div>

                    <div class="menu-item">
                        <img src="images/mini_donuts.jpg" alt="Mini Donuts">
                        <h3>Mini Donuts</h3>
                        <p>Price: $3.50</p>
                        <p>Delicious mini donuts topped with chocolate crumbs.</p>
                        <button type="submit" name="item" value="Mini Donuts">Order Mini Donuts</button>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Cart Display Section -->
        <section class="cart">
            <h3>Your Menu</h3>
            <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <div class="cart-item">
                        <p><?php echo $item['name']; ?> - Quantity: <?php echo $item['quantity']; ?> | Price: $<?php echo number_format($item['price'], 2); ?></p>
                        <form action="menu.php" method="POST" style="display:inline;">
                            <input type="hidden" name="remove_item" value="<?php echo $item['name']; ?>">
                            <button type="submit" style="background-color: #FF4C4C; color: white; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer;">Remove 1</button>
                        </form>
                    </div>
                <?php endforeach; ?>
                <div class="cart-total">
                    Total Price: $<?php echo number_format(calculateTotalPrice(), 2); ?>
                </div>
                <form action="menu.php" method="POST">
                    <button type="submit" name="cancel_order" class="cancel-order-btn">Cancel Order</button>
                </form>
            <?php else: ?>
                <p>Your menu is empty.</p>
            <?php endif; ?>
        </section>
    </section>
</body>
</html>
