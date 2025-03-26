<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="card shadow p-4">
            <h2 class="text-center">Reset Password via WhatsApp</h2>
            <form action="{{ route('password.sendOtp') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Kirim OTP</button>
            </form>
        </div>
    </div>
</body>
</html>
