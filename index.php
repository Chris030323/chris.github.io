<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Homepage | CLYS Event planning website</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="header">
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="Homepage.php">
                    <img src="clys logo.png.png" width="100px" alt="CLYS">
                </a>
            </div>
            <nav>
                <ul>
                    <a href="Homepage.php" class="nav-icon">
                        <img src="home icon.png" width="30px" height="30px" alt="Homepage">
                    </a>
                    <a href="about.php" class="nav-icon">
                        <img src="about icon.png" width="30px" height="30px" alt="About Us">
                    </a>
                    <a href="login.php" class="nav-icon">
                        <img src="log out icon.png" width="30px" height="30px" alt="Log out">
                    </a>
                    <a href="register.php" class="nav-icon"> 
                        <img src="register.png" width="30px" height="30px" alt="register">
                    </a>
                </ul>
            </nav>
        </div>
    
        <div class="row">
            <div class="col-2">
                <h1>Welcome to CLYS!</h1>
                <p>CLYS is a small event planning company that, provides certain events that can be found bellow </p>
                <p>We provide event places such as, Marriage hall, Stadium, Dining Hall etc.</p>
                <p>Join us by signing up to events that are available bellow.</p>
            </div>
        </div>
        </div>
    </div>
</div>

<!--Hot item-->
<div class="header2">
    <h2 class="title">Events</h2>

    <div class="image-con">
        <div class="image-wrapper">
            <?php
                // Database connection
                $dsn ="mysql:host=localhost;dbname=eventplanner";
                $username = "root";
                $password = "";
                $database = "dashboard";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch featured items from the database
                $sql_featured_items = "SELECT * FROM items";
                $result_featured_items = $conn->query($sql_featured_items);

                if ($result_featured_items->num_rows > 0) {
                    while ($row = $result_featured_items->fetch_assoc()) {
                        $imagePath = $row['image'];
                        echo '<a href="itemdetails.php?id=' . $row['id'] . '" class="nav-icon">';
                        echo '<img src="' . $imagePath . '" alt="' . $row['itemName'] . '">';
                        echo '</a>';
                    }
                } else {
                    echo "No items found";
                }

                // Close connection
                $conn->close();
                ?>
        </div>
    </div>
</div>

<script>

    const imageWrapper = document.querySelector('.image-wrapper')
    const imageItems = document.querySelectorAll('.image-wrapper > *')
    const imageLength = imageItems.length
    const perView = 4 /*to adjust how many items shown in a page*/ 
    let totalScroll = 0
    const delay = 2000   
    imageWrapper.style.setProperty('--per-view', perView)
    for(let i = 0; i < perView; i++) {
        imageWrapper.insertAdjacentHTML('beforeend', imageItems[i].outerHTML)
    }

    let autoScroll = setInterval(scrolling, delay)
    function scrolling() {
        totalScroll++
        if(totalScroll == imageLength + 1) {
            clearInterval(autoScroll)
            totalScroll = 1
            imageWrapper.style.transition = '0s'
            imageWrapper.style.left = '0'
            autoScroll = setInterval(scrolling, delay)
        }
        const widthEl = document.querySelector('.image-wrapper > :first-child').offsetWidth + 24
        imageWrapper.style.left = `-${totalScroll * widthEl}px`
        imageWrapper.style.transition = '.3s'
    }
</script>
<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <h3>Contact Us</h3>
                <p>Email: customerservice@jny.com</p>
                <p>Phone: +6019 - 8808119</p>
                <p>Address: 123, Street ABC, Cheras, Malaysia</p>
            </div>
        </div>
    </div>
</footer>
</body>
<style>
    body 
    {
        font-family: sans-serif;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: auto;
    }

    .header {
        background-color: white;
    }

    .header2 {
        text-align: center;
        margin-top: 20px;
    }

    .navbar 
    {
        background-color: #ffffff;
        padding: 30px;
        padding-bottom: 70px;
        display: flex;
        align-items: flex-end;
    }

    .navbar .logo 
    {
        display: flex;
        align-items: flex-end;
    }

    .navbar nav 
    {
        margin-left: auto; /* Move the navigation icons to the right */
    }

    .navbar nav ul a 
    {
        margin-right: 30px; /* Gap value between each icon */
    }

    /* Make the image fully responsive */
    .carousel-inner img 
    {
        width: 200px;
        height: 100%;
    }

    .carousel-item active
    {
        position: center;
    }

    /* Individual item styling */
    .col 
    {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        background-color: #fff;
        transition: transform 0.2s ease-in-out;
        margin: 0px;
        padding: 10px;
        position: center;
        justify-content: center;
        align-items: center;
        width: 500px;
    }

    /* Hover effect */
    .col:hover 
    {
        transform: scale(1.05);
    }

    .image-con {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        overflow: hidden;
        max-width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: lightyellow;
    }

    .image-wrapper {
        display: flex;
        width: 100%;
    }

    .image-wrapper a {
        flex: 0 0 auto;
        width: 300px; /* to set the width between every items */
        margin-right: 20px; /* to set the gap between every items */
        display: block;
    }

    .image-wrapper img {
        width: 100%; /* to fit the container */
        height: auto;
        border-radius: 8px;
    }

    /* IMAGE */
    .image-con 
    {
    margin: 0;
        padding: 0;
        box-sizing: border-box;
        max-width: 768px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .image-wrapper 
    {
        display: grid;
        grid-auto-flow: column;
        grid-auto-columns: calc((100% - (1.5rem * (var(--per-view) - 1))) / var(--per-view));
        grid-gap: 1.5rem;
        position: relative;
        left: 0;
        transition: .3s;
        align-items: center;
    }

    .image-wrapper > * 
    {
        aspect-ratio: 4 / 3;
    }

    .image-wrapper img 
    {
        width: 100%;
        height: auto;
        object-fit: cover;
        display: block;
        border-radius: .5rem;
    }

    .footer 
    {
        background-color: #ffffff; 
        padding: 20px 0; 
        width: 100%;
        margin-top: auto; 
        color: black;
    }

    .footer .container 
    {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .footer .content 
    .footer .content h3, 
    .footer .content p 
    {
        max-width: 600px; /* Optional: Set a max-width for the content */
        margin: 5px 0; /* Add margin for spacing */
    }
</style>
</html>

