<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack Bites Cafe</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General styles for the page */
        body {
            background-image: url('https://example.com/cafe-background.jpg'); /* Replace with your desired background image */
            background-size: cover;
            background-position: center;
            transition: background\ 0.5s ease-in-out;
            font-family: Arial, sans-serif;
        }
        header, .cafe-description, h2 {
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        /* Center the images and menu items */
        .menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9); /* Add a background to make the items pop */
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        /* Hover effect for menu items */
        .menu-item:hover {
            transform: scale(1.05);
        }

        /* Image styles */
        .menu-item img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        #menuItemsContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }

        /* Adjusting font size for item descriptions */
        .menu-item h3 {
            margin: 10px 0;
            font-size: 18px;
            color: #333;
        }

        .menu-item p {
            font-size: 14px;
            color: #666;
        }

        /* Search bar styles */
        .search-container {
            margin: 20px 0;
            text-align: center;
        }

        .search-container input {
            width: 80%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Filter buttons */
        .filter-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .filter-btn {
            padding: 10px 20px;
            margin: 5px;
            background-color: #444;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .filter-btn:hover {
            background-color: #666;
        }

    </style>
</head>
<body>
    <header>
        <h1>Snack Bites Cafe</h1>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Café Description Section -->
    <section class="cafe-description">
        <h2>About Snack Bites Café</h2>
        <p>
            Snack Bites Café is your destination for tasty snacks and meals like nachos, burgers, and donuts. 
            We offer quick bites and satisfying meals, perfect for any time of day!
        </p>
        <p>
            Our café is a cozy spot where you can relax, grab a bite, and enjoy delicious food at affordable prices.
        </p>
    </section>

    <section>
        <h2>About</h2>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search for items...">
        </div>

        <!-- Filter Buttons -->
        <div class="filter-container">
            <button class="filter-btn" onclick="filterItems('all')">All</button>
            <button class="filter-btn" onclick="filterItems('Burger')">Burger</button>
            <button class="filter-btn" onclick="filterItems('Chessy Burger')">Chessy Burger</button>
            <button class="filter-btn" onclick="filterItems('Spaghetti')">Spaghetti</button>
            <button class="filter-btn" onclick="filterItems('Mini Donut')">Donut</button>
        </div>

        <!-- Menu Items Display -->
        <div id="menuItemsContainer">
            <!-- Menu items will be injected here dynamically -->
        </div>
    </section>

    <script>
        // Menu items data
        const menuItems = [
            {
                name: 'Regular Burger',
                description: 'Classic burger with lettuce, tomato, and pickles.',
                image_url: 'https://www.istockphoto.com/photos/burger',
                background_image: 'https://example.com/regular-burger-bg.jpg'
            },
            {
                name: 'Chessy Burger',
                description: 'Classic burger with lettuce, tomato, and pickles.',
                image_url: 'https://example.com/Chessy Burger.jpg',
                background_image: 'https://example.com/regular-burger-bg.jpg'
            },
            {
                name: 'Spaghetti',
                description: 'Pasta with tomato sauce.',
                image_url: 'https://example.com/spaghetti.jpg',
                background_image: 'https://example.com/c:\Users\jilli\Downloads\spaghetti.jpg.'
            },
            {
                name: 'Cheesy Burger w/ Egg',
                description: 'Juicy burger topped with cheese and a fried egg.',
                image_url: 'https://example.com/cheesy-burger-egg.jpg',
                background_image: 'https://example.com/cheesy-burger-egg-bg.jpg'
            },
            {
                name: 'Mini Donut',
                description: 'Delicious bite-sized donuts, perfect for a sweet treat.',
                image_url: 'https://example.com/mini-donut.jpg',
                background_image: 'https://example.com/mini-donut-bg.jpg'
            }
        ];

        // Function to load menu items and set background image
        function loadMenuItems() {
            let container = document.getElementById('menuItemsContainer');
            container.innerHTML = '';  // Clear current items

            menuItems.forEach(item => {
                let menuItemHTML = `
                    <div class="menu-item" onclick="changeBackground('${item.background_image}')">
                        <h3>${item.name}</h3>
                        <img src="${item.image_url}" alt="${item.name}">
                        <p>${item.description}</p>
                    </div>
                `;
                container.innerHTML += menuItemHTML;
            });
        }

        // Change background image based on selected item
        function changeBackground(imageUrl) {
            document.body.style.backgroundImage = url('${imageUrl}');
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchQuery = this.value.toLowerCase();
            let filteredItems = menuItems.filter(item => item.name.toLowerCase().includes(searchQuery));
            let container = document.getElementById('menuItemsContainer');
            container.innerHTML = '';  // Clear current items

            if (filteredItems.length === 0) {
                container.innerHTML = '<p>No items found</p>';
            } else {
                filteredItems.forEach(item => {
                    let menuItemHTML = `
                        <div class="menu-item" onclick="changeBackground('${item.background_image}')">
                            <h3>${item.name}</h3>
                            <img src="${item.image_url}" alt="${item.name}">
                            <p>${item.description}</p>
                        </div>
                    `;
                    container.innerHTML += menuItemHTML;
                });
            }
        });

        // Filter functionality
        function filterItems(category) {
            let filteredItems = menuItems.filter(item => {
                if (category === 'all') return true;
                return item.name.includes(category);
            });
            let container = document.getElementById('menuItemsContainer');
            container.innerHTML = '';

            if (filteredItems.length === 0) {
                container.innerHTML = '<p>No items found</p>';
            } else {
                filteredItems.forEach(item => {
                    let menuItemHTML = `
                        <div class="menu-item" onclick="changeBackground('${item.background_image}')">
                            <h3>${item.name}</h3>
                            <img src="${item.image_url}" alt="${item.name}">
                            <p>${item.description}</p>
                        </div>
                    `;
                    container.innerHTML += menuItemHTML;
                });
            }
        }

        // Load all items by default
        window.onload = function () {
            loadMenuItems();
        };
    </script>
</body>
</html>