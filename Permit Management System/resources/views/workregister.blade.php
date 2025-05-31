<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Immigration Services</title>
    <link rel="stylesheet" href="{{ url('CSS/registerstyle.css') }}">
</head>
<body>
    <header>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px;">
          <div>
            <h1>ImmigrationBW</h1>
          </div>
          <div style="display: flex; gap: 20px;">
            <a href="/studentpermitinfo" style="text-decoration: none; color: white;">Student Permit Application</a>
            <a href="/" style="text-decoration: none; color: white;">Home</a>
            <a href="/workpermitinfo" style="text-decoration: none; color: white;">Work Permit Application</a>
            <a href="/register" style="text-decoration: none; color: white;">Register</a>
          </div>
          <div>
            <a href="/login" style="text-decoration: none; color: white;">Login</a>
          </div>
        </div>
    </header>
    
    <div class="xmad">
        <div class="container">
            <h2>Create an Account</h2>
            <form action='/workregister' method="POST">
                @csrf
            
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter your full name" value="{{ old('name') }}">
                @error('name')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
                @error('email')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            
                <label for="password">Password :</br> <p style="color: rgba(21, 0, 88, 0.646);">(must contain atleast 1 uppercase letter, 1 lower case letter and one symbol)</p></label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
                @error('password')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Re-type your password">
                @error('password_confirmation')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            
                <button class="btn">Register</button>
            </form>
            
            <div class="footer">
                <p>Already have an account? <a href="{{ route('home') }}">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
