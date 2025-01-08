<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link href="{{ asset('/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    {{-- <link rel="icon" href="{{ asset('img/mobililogoicn1.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('img/mobililogoinc2.ico') }}" type="image/x-icon"> --}}
</head>

<body class="body-login">
    <div class="login-container" style="padding:20px;">
        <div class="login-box">
            <div class="login-left">
                <div class="login-icon" href="#">
                <img src="{{ asset('assets/img/logo/logoapjifix.png') }}" alt="Logo mobili" style="width: 200px; height: auto;">
                </div>
                <h2 class="login-text">Selamat datang di Website APJI</h2>
                <p>Silahkan Masukan Akun Anda</p>
                
                <form action="{{ route('authenticate') }}" method="POST">
                    @csrf
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert" style="background-color: #F8D7DA; color: #721C24; border-color: #F5C6CB; padding: 10px; border-radius: 5px; display: flex; align-items: center;">
                            <i class="bi bi-exclamation-triangle" style="margin-right: 10px;"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="input-group">
                        <i class="bi bi-person"></i>
                        <input type="text" name="email" placeholder="Email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert" style="color: red;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <i class="bi bi-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Password" class="@error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert" style="color: red;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3" style="font-size:14px;">
                        <input type="checkbox" class="form-check-input" id="show-password"> Show Password
                    </div>

                    <button type="submit" class="login-btn">Login</button>

                    <p class="text-center mt-3">Anggota Baru? <a href="{{ route('registerShow') }}">Daftar di sini</a></p>
                </form>

            </div>
            <div class="login-right">
                <img src="{{ asset('assets/img/img1.jpg') }}" alt="Right Image">
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/login.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        var passwordInput = document.getElementById("password");
        var showPasswordCheckbox = document.getElementById("show-password");

        showPasswordCheckbox.addEventListener("change", function() {
            var type = this.checked ? "text" : "password";
            passwordInput.setAttribute("type", type);
        });
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        @if (Session::has('success'))
            Toastify({
                text: "{{ Session::get('success') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#28a745",
                stopOnFocus: true,
            }).showToast();
        @endif
    
        @if (Session::has('error'))
            Toastify({
                text: "{{ Session::get('error') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#dc3545",
                stopOnFocus: true,
            }).showToast();
        @endif
    </script>    
</body>

</html>
