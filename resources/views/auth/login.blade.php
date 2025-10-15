<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - WARYUL Restaurant</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-container {
      background: white;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }
    .logo {
      text-align: center;
      margin-bottom: 30px;
    }
    .logo h1 {
      color: #333;
      font-size: 28px;
      margin: 0;
    }
    .form-control {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 12px;
      margin-bottom: 15px;
    }
    .btn-login {
      background-color: #007bff;
      border: none;
      color: white;
      padding: 12px;
      width: 100%;
      border-radius: 4px;
      font-size: 16px;
    }
    .btn-login:hover {
      background-color: #0056b3;
    }
    .alert {
      border-radius: 4px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="logo">
      <h1>WARYUL</h1>
      <p>Restaurant System</p>
    </div>

    @if($errors->any())
      <div class="alert alert-danger">
        @foreach($errors->all() as $error)
          {{ $error }}<br>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      
      <div class="mb-3">
        <label for="namauser" class="form-label">Username</label>
        <input id="namauser" type="text" class="form-control" name="namauser" 
               value="{{ old('namauser') }}" required autofocus>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" class="form-control" name="password" required>
      </div>

      <button type="submit" class="btn btn-login">Masuk</button>
    </form>
  </div>
</body>
</html>
