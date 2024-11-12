<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Trending Plants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            padding: 20px;
        }




        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .shop-all-btn {
            background-color: #c3e130;
            color: black;
            padding: 10px 20px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
            float: right;
        }

        .swiper-container {
            width: 100%;
            height: 400px;
            overflow: hidden;
            /* Adjust the height as needed */
        }

        .swiper-slide {
            text-align: center;
            max-width: 200px;
            transition: transform 0.3s ease;
        }

        .swiper-slide img {
            width: 100%;
            border-radius: 8px;
        }

        .swiper-slide-active {
            transform: scale(1.2);
            /* Make the active slide larger */
        }

        .overlay {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: rgba(34, 139, 34, 0.9);
            color: white;
            padding: 10px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
        }

        .product h3 {
            margin-top: 10px;
            font-size: 16px;
            color: #333;
        }

        .product .price {
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Top Trending Plants</h2>
                <button class="shop-all-btn">Shop All</button>

                <!-- Swiper Slider Wrapper -->
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide product">
                            <img src="plant1.jpg" alt="Snake Plant">
                            <div class="overlay">Select Your Container</div>
                            <h3>Snake Plant (Sansevieria)</h3>
                            <p class="price">$59.99 - $147.99</p>
                        </div>
                        <div class="swiper-slide product">
                            <img src="plant2.jpg" alt="Peace Lily Plant">
                            <div class="overlay">Select Your Container</div>
                            <h3>Peace Lily Plant (Spathiphyllum)</h3>
                            <p class="price">$54.99 - $152.99</p>
                        </div>
                        <div class="swiper-slide product">
                            <img src="plant3.jpg" alt="Juniper Bonsai Tree">
                            <div class="overlay">Select Your Container</div>
                            <h3>Juniper Bonsai Tree</h3>
                            <p class="price">$54.99 - $64.99</p>
                        </div>
                        <div class="swiper-slide product">
                            <img src="plant4.jpg" alt="Money Tree Plant">
                            <div class="overlay">Select Your Container</div>
                            <h3>Money Tree Plant</h3>
                            <p class="price">$64.99 - $142.99</p>
                        </div>
                        <div class="swiper-slide product">
                            <img src="plant5.jpg" alt="Chrysanthemum Blooming Plant">
                            <div class="overlay">Select Your Container</div>
                            <h3>Chrysanthemum Blooming Plant</h3>
                            <p class="price">$36.99 - $46.99</p>
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const swiper = new Swiper('.swiper-container', {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                slidesPerView: 4,
                spaceBetween: 30,
                centeredSlides: true,
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>




</body>

</html>
