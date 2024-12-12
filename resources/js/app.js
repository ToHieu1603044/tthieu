import './bootstrap';
import axios from 'axios';

window.axios = axios;

const token = localStorage.getItem('token'); // Kiểm tra nếu token đã có trong localStorage

if (token) {
    // Cấu hình token nếu có
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

document.addEventListener('DOMContentLoaded', function () {
    // Lắng nghe sự kiện gửi form login
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault();

        // Lấy thông tin form
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Gửi yêu cầu login qua API
        axios.post('/api/login', {
            email: email,
            password: password
        })
        .then(response => {
            // Lưu token vào localStorage
            localStorage.setItem('token', response.data.token);

            // Chuyển hướng người dùng sau khi login thành công
            window.location.href = '/dashboard';  // Hoặc trang bạn muốn điều hướng
        })
        .catch(error => {
            // Hiển thị thông báo lỗi nếu có
            const errorMessage = error.response ? error.response.data.message || 'Đăng nhập thất bại' : 'Có lỗi xảy ra';
            document.getElementById('error-message').textContent = errorMessage;
        });
    });
});
