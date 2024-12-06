<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header>
            <!-- place navbar here -->
        </header>
        <main>
            <section class="py-5">
                <div class="container">
                    <h2 class="fw-bold fs-3 mb-4">Order History</h2>
            
                    <div class="d-flex flex-column flex-lg-row justify-content-between mb-4">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link text-primary" href="#">All Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="#">Summary</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="#">Completed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="#">Cancelled</a>
                            </li>
                        </ul>
            
                        <div class="d-flex align-items-center mt-3 mt-lg-0">
                            <div class="input-group me-3">
                                <input type="text" class="form-control" placeholder="From" aria-label="From">
                            </div>
                            <span class="mx-2">To</span>
                            <div class="input-group ms-3">
                                <input type="text" class="form-control" placeholder="To" aria-label="To">
                            </div>
                        </div>
                    </div>
            
                    <ul class="list-unstyled">
                        <!-- Order 1 -->
                        <li class="border-bottom pb-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="fw-medium fs-5 mb-2">Order #: #10234987</p>
                                    <p class="fw-medium fs-5 text-muted">Order Payment: 18th March 2021</p>
                                </div>
                                <div>
                                    <button class="btn btn-outline-secondary me-2">Show Invoice</button>
                                    <button class="btn btn-primary">Buy Now</button>
                                </div>
                            </div>
                            <div class="my-3">
                                <hr class="m-0">
                            </div>
                            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center">
                                <div class="d-flex">
                                    <img src="https://pagedone.io/asset/uploads/1705474774.png" alt="Product" class="img-fluid" style="max-width: 150px;">
                                </div>
                                <div class="ms-3">
                                    <h5 class="fw-semibold fs-4">Decoration Flower Pot</h5>
                                    <p class="text-muted">By: Dust Studios</p>
                                    <div class="d-flex gap-4">
                                        <span>Size: S</span>
                                        <span>Qty: 1</span>
                                        <span>Price: $80.00</span>
                                    </div>
                                </div>
                                <div class="text-center mt-4 mt-lg-0">
                                    <p class="text-muted mb-2">Status</p>
                                    <p class="fw-semibold text-success">Delivered</p>
                                </div>
                                <div class="text-center mt-4 mt-lg-0">
                                    <p class="text-muted mb-2">Delivery Expected by</p>
                                    <p class="fw-semibold">23rd March 2021</p>
                                </div>
                            </div>
                        </li>
            
                        <!-- Order 2 -->
                        <li class="border-bottom pb-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="fw-medium fs-5 mb-2">Order #: #10234988</p>
                                    <p class="fw-medium fs-5 text-muted">Order Payment: 20th March 2021</p>
                                </div>
                                <div>
                                    <button class="btn btn-outline-secondary me-2">Show Invoice</button>
                                    <button class="btn btn-primary">Buy Now</button>
                                </div>
                            </div>
                            <div class="my-3">
                                <hr class="m-0">
                            </div>
                            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center">
                                <div class="d-flex">
                                    <img src="https://pagedone.io/asset/uploads/1705474672.png" alt="Product" class="img-fluid" style="max-width: 150px;">
                                </div>
                                <div class="ms-3">
                                    <h5 class="fw-semibold fs-4">Decoration’s Item</h5>
                                    <p class="text-muted">By: Dust Studios</p>
                                    <div class="d-flex gap-4">
                                        <span>Size: S</span>
                                        <span>Qty: 1</span>
                                        <span>Price: $80.00</span>
                                    </div>
                                </div>
                                <div class="text-center mt-4 mt-lg-0">
                                    <p class="text-muted mb-2">Status</p>
                                    <p class="fw-semibold text-danger">Cancelled</p>
                                </div>
                                <div class="text-center mt-4 mt-lg-0">
                                    <p class="text-muted mb-2">Delivery Expected by</p>
                                    <p class="fw-semibold">23rd March 2021</p>
                                </div>
                            </div>
                        </li>
                    </ul>
            
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="fw-semibold">Page 1 of 5</p>
                        <div>
                            <button class="btn btn-link text-decoration-none">Prev</button>
                            <button class="btn btn-link text-decoration-none">Next</button>
                        </div>
                    </div>
                </div>
            </section>
            
            
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
