<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<style>
    /* Your CSS code here */
    body {
        background-color: #eeeeee;
        font-family: 'Open Sans', serif;
    }

    .container {
        margin-top: 50px;
        margin-bottom: 50px;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 0.10rem;
    }

    .card-header:first-child {
        border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0;
    }

    .card-header {
        padding: 0.75rem 1.25rem;
        margin-bottom: 0;
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .track {
        position: relative;
        background-color: #ddd;
        height: 7px;
        display: flex;
        margin-bottom: 60px;
        margin-top: 50px;
    }

    .track .step {
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative;
    }

    .track .step.active:before {
        background: #FF5722;
    }

    .track .step::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px;
    }

    .track .step.active .icon {
        background: #ee5435;
        color: #fff;
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd;
    }

    .track .step.active .text {
        font-weight: 400;
        color: #000;
    }

    .track .text {
        display: block;
        margin-top: 7px;
    }

    .itemside {
        display: flex;
        width: 100%;
    }

    .itemside .aside {
        flex-shrink: 0;
    }

    .img-sm {
        width: 80px;
        height: 80px;
        padding: 7px;
    }

    ul.row {
        list-style: none;
        padding: 0;
    }

    .itemside .info {
        padding-left: 15px;
        padding-right: 7px;
    }

    .itemside .title {
        display: block;
        margin-bottom: 5px;
        color: #212529;
    }

    .btn-warning {
        color: #ffffff;
        background-color: #ee5435;
        border-color: #ee5435;
        border-radius: 1px;
    }

    .btn-warning:hover {
        background-color: #ff2b00;
        border-color: #ff2b00;
    }
</style>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>

        <div class="container">
            <article class="card">
                <header class="card-header"> My Orders / Tracking </header>
                <div class="card-body">
                    <h6>Order ID: OD45345345435</h6>
                    <article class="card">
                        <div class="card-body row">
                            <div class="col"> <strong>Estimated Delivery time:</strong> <br>29 nov 2019 </div>
                            <div class="col"> <strong>Shipping BY:</strong> <br> BLUEDART, | <i
                                    class="fa fa-phone"></i> +1598675986 </div>
                            <div class="col"> <strong>Status:</strong> <br> Picked by the courier </div>
                            <div class="col"> <strong>Tracking #:</strong> <br> BD045903594059 </div>
                        </div>
                    </article>
                    <div class="track">
                        <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span
                                class="text">Order confirmed</span> </div>
                        <div class="step active"> <span class="icon"> <i class="fa fa-user"></i> </span> <span
                                class="text"> Picked by courier</span> </div>
                        <div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span
                                class="text"> On the way </span> </div>
                        <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span
                                class="text">Ready for pickup</span> </div>
                    </div>
                    <hr>
                    <ul class="row">
                        <li class="col-md-4">
                            <figure class="itemside mb-3">
                                <div class="aside"><img src="https://i.imgur.com/iDwDQ4o.png" class="img-sm border">
                                </div>
                                <figcaption class="info align-self-center">
                                    <p class="title">Dell Laptop with 500GB HDD <br> 8GB RAM</p> <span
                                        class="text-muted">$950 </span>
                                </figcaption>
                            </figure>
                        </li>
                        <li class="col-md-4">
                            <figure class="itemside mb-3">
                                <div class="aside"><img src="https://i.imgur.com/tVBy5Q0.png" class="img-sm border">
                                </div>
                                <figcaption class="info align-self-center">
                                    <p class="title">HP Laptop with 500GB HDD <br> 8GB RAM</p> <span
                                        class="text-muted">$850 </span>
                                </figcaption>
                            </figure>
                        </li>
                        <li class="col-md-4">
                            <figure class="itemside mb-3">
                                <div class="aside"><img src="https://i.imgur.com/Bd56jKH.png" class="img-sm border">
                                </div>
                                <figcaption class="info align-self-center">
                                    <p class="title">ACER Laptop with 500GB HDD <br> 8GB RAM</p> <span
                                        class="text-muted">$650 </span>
                                </figcaption>
                            </figure>
                        </li>
                    </ul>
                    <hr>
                    <a href="{{ route('orders.index') }}" class="btn btn-warning" data-abc="true"> <i class="fa fa-chevron-left"></i> Back
                        to orders</a>
                </div>
            </article>
        </div>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
