<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{ url('CSS/homestyle.css') }}">
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="#home">Home</a>
        <a href="#services">Services</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
    </div>

    <!-- Login Form -->
    <div class="container">
        <h1>Login</h1>

        <form action="/login" method="POST">
            @csrf
            <!-- Email Field -->
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email">

            <!-- Password Field -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password">

            <!-- Login Button -->
            <button class="btn-login">Login</button>
        </form>

        <!-- Footer with Registration Link -->
        <div class="footer">
            <p>Haven't registered? <a href="{{ route('register') }}">Create an account</a></p>
        </div>
    </div>

</body>
</html>
