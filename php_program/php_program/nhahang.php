<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GACHA HOTEL</title>
    <link rel="stylesheet" href="css/servicestyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Cinzel&family=Unna:ital,wght@0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Unna', sans-serif;
            background-color:#d9d1d0;
        }

        header {
            text-align: center;
            background-color: wheat;
            padding: 1rem;
        }

        nav {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }

        nav a {
            margin: 0 1rem;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .restaurant-image {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .section-title {
            text-align: left;
            font-size: 2.5rem;
        }

        .lead {
            font-size: 1.25rem;
        }

        .location {
            margin-top: 1rem;
        }

        .hours {
            float: left;
            margin-right: 2rem;
        }

        .menu {
            float: right;
            margin-left: 2rem;
        }

        .menu img {
            width: 100%;
            height: auto;
            margin-right: 1rem;
            float: right;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
    <h1> GACHA HOTEL</h1> 
    <nav>
      <a href="nhahang.php">Nhà Hàng</a>
      <a href="spa.php">Spa</a>
      <a href="fitness.php">Fitness</a>
      <a href="index.php">Back to lobby</a>
    </nav>
  </header>

    <img class="restaurant-image" src="https://acihome.vn/uploads/15/mau-thiet-ke-nha-hang-an-sang-trong-tai-khach-san-4-5-sao-4.JPG" alt="">

    <div class="container">
        <h1 class="section-title">The Restaurant</h1>
<p class="lead">Led by Chef de Micheal Martin, The Restaurant is celebrated for its excellent cuisine and unique ambience. The gorgeous dining room features three open studio kitchens, allowing you to enjoy the sights and sounds of the culinary artistry on display. The menu showcases both Asian and European influences, with a tempting selection of classic favorites and creative dishes for you to sample. Cheese connoisseurs will be drawn to the Wine and Cheese Cellar, housed in five-meter-high glass walls, where our knowledgeable staff can introduce you to some of New York's greatest culinary treasures.</p>

        <div class="location">
            <h class="mt-4">Location: Floor 2 </h>
        </div>

        <div class="hours">
            <p><b>Hours:</b></p>
            <h>Breakfast: 6.am-11.am </h>
            <h>Lunch: 12.noon-2.pm </h>
            <h>Dinner: 6.pm-10.pm </h>
        </div>

        <div class="menu">
            <p><b>Terrace:</b></p>
            <h>Open for drinks only </h>
            <h1>Menu</h1>
            
            <div>
                <p><b>New dishes:</b></p>  
                <h5>Mozzarella Pizza ....20$</h5>
                <h5>French Onion Soup ............15$</h5>
                <h5>Beef Wellington .........42$</h5> 
                <h5>Roast Yuzu Chicken ..........33$</h5>
            </div>

            <div>
                <p><b>New Drinks:</b></p>  
                <h5>SKY MERLOT (limited edition) ....77.77$ </h5>
                <h5>SANTA OLGA Gran Reserva (Red) ............49$</h5>
                <h5>TALÒ San Marzano (Red) .........31$</h5> 
                <h5>CÌU CÍU Tebaldo (White) ..........31$</h5>
                <h5>X PLUS Reserva (Red) ..........24.25$</h5>
                <img src="https://incucdep.com/wp-content/uploads/2016/10/menu-bia-cung-nha-hang-quan-an-03-min.jpg" alt="">
            </div>
        </div>
    </div>
</body>
</html>
