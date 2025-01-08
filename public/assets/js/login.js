// login.js

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('form');

    loginForm.addEventListener('submit', function(event) {

        // Get input values
        const emailInput = loginForm.querySelector('input[type="email"]');
        const passwordInput = loginForm.querySelector('input[type="password"]');

        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let isValid = true;

        // Reset previous error states
        emailInput.classList.remove('input-error');
        passwordInput.classList.remove('input-error');

        // Email validation
        if (!emailRegex.test(emailInput.value.trim())) {
            emailInput.classList.add('input-error');
            isValid = false;
        }

        // Password validation
        if (!passwordInput.value.trim()) {
            passwordInput.classList.add('input-error');
            isValid = false;
        }

        // If validation passes, you would typically send to backend
        if (isValid) {
            // Simulated login (replace with actual login logic)
            console.log('Login attempt with:', {
                email: emailInput.value,
                password: passwordInput.value
            });

            // Example: You might use fetch or axios to send login request
            // fetch('/login', {
            //     method: 'POST',
            //     body: JSON.stringify({
            //         email: emailInput.value,
            //         password: passwordInput.value
            //     })
            // })
            // .then(response => response.json())
            // .then(data => {
            //     // Handle login response
            // });
        } else {
            alert('Please enter a valid email and password.');
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.querySelector('input[type="password"]');
        const togglePasswordBtn = document.createElement('button');
    
        togglePasswordBtn.innerHTML = '<i class="fas fa-eye"></i>';
        togglePasswordBtn.classList.add('toggle-password');
        passwordInput.parentNode.insertBefore(togglePasswordBtn, passwordInput.nextSibling);
    
        togglePasswordBtn.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                togglePasswordBtn.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    });
    
});

// document.addEventListener("DOMContentLoaded", function () {
//     const successMessage = "{{ Session::get('success') }}";
//     const errorMessage = "{{ Session::get('error') }}";

//     if (successMessage) {
//         Toastify({
//             text: successMessage,
//             duration: 3000,
//             gravity: "top",
//             position: "right",
//             backgroundColor: "#dc3545",
//             stopOnFocus: true,
//         }).showToast();
//     }

//     if (errorMessage) {
//         Toastify({
//             text: errorMessage,
//             duration: 3000,
//             gravity: "top",
//             position: "right",
//             backgroundColor: "#28a745",
//             stopOnFocus: true,
//         }).showToast();
//     }
// });

