<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character set and viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title of the webpage -->
    <title>Recipes by Nicole</title>
    <!-- Link to external stylesheet -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header section -->
    <header>
        <!-- Title of the website -->
        <h1><span class="cookbook"> COOKING BOOK</span></h1>
    </header>
    <!-- Top section with navigation -->
    <section id="TopSection">
        <div class="container">
            <!-- Navigation menu -->
            <nav>
                <!-- Logo of the website -->
                <div class="logo">
                    <img src="Image/cookingbook.png" alt="Logo">
                </div>
                <!-- List of navigation links -->
                <ul>
                    <li><a href="">Home </a></li>
                    <li><a href="Recipe_list.php">Recipes</a></li>
                    <li><a href="">Features </a></li>
                    <li>
                        <!-- Newsletter subscription link -->
                        <div>
                            <a href="" class="newsletter">Newsletter</a>
                        </div>
                    </li>
                    <li><a href="">About us </a></li>
                </ul>
            </nav>
        </div>
        <!-- User info section -->
        <div class="user-info">
            <?php
            // Check if the user is logged in and display their username
            if (isset($_SESSION['username'])) {
                echo '<p>Welcome, ' . $_SESSION['username'] . '!</p>';
            }
            ?>
        </div>
    </section>
    <!-- Main content section -->
    <section id="ArticleSection">
        <!-- Article introduction -->
        <div class="article">
            <h1>Simple Homemade Recipes</h1>
            <p>Offering simple homemade recipes<br>to prepare with minimal ingredients.</p>
            <!-- Button to recommended recipes -->
            <a href="login.php" class="btn">Login to your account</a>
        </div>
    </section>
    <!-- Benefits section -->
    <div class="benefits">
        <!-- Title of the benefits section -->
        <h1>Why use this website?</h1>
        <!-- Explanation of the website's simplicity -->
        <p>This website's simplicity makes it beginner-friendly as it is simple to navigate and access different parts of it.</p>
    </div>
    <!-- Title for the features section -->
    <div class="featuretitle">
        <h2>Features</h2>
    </div>
    <!-- Features section -->
    <section class="FeatureSection">
        <!-- Feature: Step-by-step instructions -->
        <div class="feature">
            <img src="Image/Steps.jpg" alt="Step-by-Step Instructions Image">
            <p>Step-by-Step Instructions</p>
        </div>
        <!-- Feature: Ingredient lists and nutritional information -->
        <div class="feature">
            <img src="Image/INGREDIENTS.jpg" alt="Ingredients Image">
            <p>Ingredient Lists and Nutritional Information.</p>
        </div>
        <!-- Feature: Video follow-up -->
        <div class="feature">
            <img src="Image/follow.jpg" alt="Image of step by step tutorial">
            <p>Video follow-up.</p>
        </div>
    </section>
    <div class="testimonials-header">
    <h1>Testimonials</h1>
    </div>
    <!-- Testimonials section -->
    <div class="testimonials-container">
        
        <div class="testimonial">
            <p>"Simple recipes and the website is very user beginner-friendly"</p>
            <p>- John Doe</p>
        </div>
        <div class="testimonial">
            <p>"My kids love the food I cook nowadays and they cannot get enough of the tasty dishes.10/10!"</p>
            <p>- Jane Smith</p>
        </div>
        <div class="testimonial">
            <p>"Highly recommended! The recipes even have videos attached to them incase you are not sure"</p>
            <p>- Chef Michael Johnson</p>
        </div>
    </div>
    
    <!-- Offers section -->
    <div class="Offers">
        <!-- Title of the offers section -->
        <h1>Offers</h1>
        <!-- Discount offer -->
        <p>A discount of 20% is available to all users who subscribe to premium between 20th May to June 20th</p>
        <!-- List of premium membership features -->
        <h2>Premium Membership features include</h2>
        <ul>
            <li>Personalized recipe recommendations</li>
            <li>Cooking Classes or Webinars</li>
            <li>Priority Customer Support</li>
            <li>Discounts on Cooking Products bought on VegieWorld</li>
        </ul>
        <!-- Button to join premium membership -->
        <a href="" class="joinbutton">Join Premium</a>
    </div>
    <!-- Updates section -->
    <div class="Updates">
        <!-- Title of the updates section -->
        <h1>Updates</h1>
        <!-- Information about the new added tab called newsletter -->
        <p>The website has a new added tab called newsletter for easy access to news regarding the website</p>
    </div>
    <!-- Social media section -->
    <div class="socialmedia">
        <!-- Title of the social media section -->
        <h1>Connect with us</h1>
        <!-- Information about connecting with the website on Instagram -->
        <p>At our recipe hub, we're not just about cooking; we're about creating a community of food lovers. That's why we've integrated social media into our platform, allowing you to connect with us and fellow culinary enthusiasts in exciting ways. You can find us on Instagram <a href="nicolerecipes.com">@nicolerecipes</a></p>
    </div>
    <!-- Footer section -->
    <footer>
        <!-- Footer content -->
        <div class="footer-content">
            <!-- Navigation links in the footer -->
            <nav>
                <ul>
                    <li><a href="">About</a></li>
                    <li><a href="">Recipes</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
            <!-- Copyright information -->
            <p>&copy; 2024 Cooking Book. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
