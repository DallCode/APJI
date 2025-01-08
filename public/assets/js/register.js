document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('multi-step-form');
    const steps = document.querySelectorAll('.step');
    const progressSteps = document.querySelectorAll('.progress-step');
    let currentStep = 0;

    // Fungsi untuk menampilkan toast dengan pesan kustom
    function showToast(message, type = 'error') {
        const backgroundColor = type === 'success' 
            ? "linear-gradient(to right, #00b09b, #96c93d)" 
            : "linear-gradient(to right, #ff5f6d, #ffc371)";

        Toastify({
            text: message,
            duration: 3000,
            gravity: "top",
            position: "center",
            backgroundColor: backgroundColor,
            stopOnFocus: true,
        }).showToast();
    }

    // Tambahkan toggle password visibility
    function addPasswordVisibilityToggle() {
        const passwordInputs = document.querySelectorAll('input[name="password"], input[name="password_confirmation"]');
        
        passwordInputs.forEach(passwordInput => {
            // Buat wrapper untuk input
            const wrapper = document.createElement('div');
            wrapper.classList.add('password-wrapper');
            passwordInput.parentNode.insertBefore(wrapper, passwordInput);
            wrapper.appendChild(passwordInput);

            // Buat tombol toggle visibility
            const toggleButton = document.createElement('button');
            toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
            toggleButton.type = 'button';
            toggleButton.classList.add('password-toggle');
            
            // Tambahkan event listener untuk toggle
            toggleButton.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                } else {
                    passwordInput.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                }
                passwordInput.focus();
            });

            // Masukkan tombol toggle setelah input
            wrapper.appendChild(toggleButton);
        });
    }

    // Validasi langkah saat ini
    function validateStep(step) {
        const inputs = step.querySelectorAll('input, select');
        let isValid = true;

        // Reset kesalahan sebelumnya
        inputs.forEach(input => {
            input.classList.remove('input-error');
        });

        inputs.forEach(input => {
            const value = input.value.trim();

            // Periksa apakah input kosong
            if (!value) {
                input.classList.add('input-error');
                isValid = false;
                showToast(`Kolom ${input.placeholder} harus diisi`);
                return;
            }

            // Validasi email
            if (input.name === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    input.classList.add('input-error');
                    isValid = false;
                    showToast('Format email tidak valid');
                }
            }

            // Validasi password
            if (input.name === 'password') {
                if (value.length < 8) {
                    input.classList.add('input-error');
                    isValid = false;
                    showToast('Password minimal 6 karakter');
                }
            }

            // Validasi konfirmasi password
            if (input.name === 'password_confirmation') {
                const passwordInput = document.querySelector('input[name="password"]');
                if (value !== passwordInput.value) {
                    input.classList.add('input-error');
                    passwordInput.classList.add('input-error');
                    isValid = false;
                    showToast('Konfirmasi password tidak cocok');
                }
            }

            // Validasi telepon (hanya angka)
            if (input.name === 'no_telp') {
                const phoneRegex = /^[0-9]+$/;
                if (!phoneRegex.test(value)) {
                    input.classList.add('input-error');
                    isValid = false;
                    showToast('Nomor telepon hanya boleh berisi angka');
                }
            }

            // Validasi KTP/NIK (hanya angka)
            if (input.name === 'no_ktp') {
                const ktpRegex = /^[0-9]+$/;
                if (!ktpRegex.test(value)) {
                    input.classList.add('input-error');
                    isValid = false;
                    showToast('KTP/NIK hanya boleh berisi angka');
                }
            }
        });

        return isValid;
    }

    // Pindah ke langkah berikutnya
    function nextStep() {
        const currentStepElement = steps[currentStep];
        if (validateStep(currentStepElement)) {
            steps[currentStep].classList.remove('active');
            currentStep++;
            if (currentStep < steps.length) {
                steps[currentStep].classList.add('active');
                updateProgressBar();
            } else {
                form.submit();
            }
        }
    }

    // Kembali ke langkah sebelumnya
    function prevStep() {
        if (currentStep > 0) {
            steps[currentStep].classList.remove('active');
            currentStep--;
            steps[currentStep].classList.add('active');
            updateProgressBar();
        }
    }

    // Perbarui progress bar
    function updateProgressBar() {
        progressSteps.forEach((step, index) => {
            if (index <= currentStep) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });
    }

    // Hilangkan error saat pengguna mengetik ulang
    const allInputs = document.querySelectorAll('input, select');
    allInputs.forEach(input => {
        input.addEventListener('input', function () {
            if (this.value.trim()) {
                this.classList.remove('input-error');
            }
        });
    });

    // Pasang event listener untuk tombol
    const nextButtons = document.querySelectorAll('button[onclick="nextStep()"]');
    const backButtons = document.querySelectorAll('button[onclick="prevStep()"]');

    nextButtons.forEach(button => button.addEventListener('click', nextStep));
    backButtons.forEach(button => button.addEventListener('click', prevStep));

    // Tambahkan toggle password visibility saat dokumen dimuat
    addPasswordVisibilityToggle();
});