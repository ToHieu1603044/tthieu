<!doctype html>
<html lang="en">

<head>
    <title>H Shop</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Font Awesome for the check icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles for the animation -->
    <style>
        /* Animation for button */
        .btn-animation {
            transition: all 0.3s ease;
        }

        .btn-animation:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.5);
        }

        /* Style for the check icon */
        .check-icon-container {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto 20px auto;  /* Center the icon horizontally */
        }

        .check-icon {
            position: absolute;
            top: 0;
            left: 0;
            width: 80px;
            height: 80px;
            background-color: #4caf50;
            border-radius: 50%;
            color: white;
            font-size: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: scale(0) rotate(0deg);
            animation: rotateToCheck 2s ease forwards;
        }

        /* Bounce effect for check icon */
        @keyframes rotateToCheck {
            0% {
                opacity: 0;
                transform: scale(0) rotate(0deg);
            }
            50% {
                opacity: 1;
                transform: scale(1.2) rotate(180deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotate(360deg);
            }
        }

        /* The checkmark itself */
        .checkmark {
            font-size: 40px;
            animation: fadeInCheckmark 2s ease forwards;
        }

        @keyframes fadeInCheckmark {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <header>
        <!-- Place your navbar here -->
    </header>
    <main class="container mt-5">
        <!-- Thanh toán thành công -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="card shadow-lg" style="max-width: 600px; margin: auto; margin-top: 100px;">
            <div class="card-body text-center">
                <!-- Dấu tích check -->
                <div class="check-icon-container">
                    <div class="check-icon">
                        <!-- Checkmark icon that appears after the animation -->
                        <span class="checkmark"><i class="fas fa-check"></i></span>
                    </div>
                </div>

                <h2 class="card-title text-success">Thanh toán thành công!</h2>
                <p class="card-text">Cảm ơn bạn đã thanh toán. Đơn hàng của bạn sẽ được xử lý sớm.</p>
                <div class="mt-4">
                    <a href="/" class="btn btn-primary btn-animation">Quay lại trang chủ</a>
                    <a href="" class="btn btn-secondary btn-animation">Xem lịch sử đơn hàng</a>
                </div>
            </div>
        </div>
        @endif
    </main>
    <footer>
        <!-- Footer content here -->
    </footer>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script>
        // Auto-hide alert after 5 seconds
        window.addEventListener('DOMContentLoaded', (event) => {
            var successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 5000); // 5 seconds
            }
        });
    </script>
</body>

</html>
