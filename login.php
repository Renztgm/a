<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <style>
    body {
      background-color: #f2f2f2;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-box {
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 300px;
    }

    .login-box h2 {
      margin-bottom: 20px;
      text-align: center;
    }

    .login-box label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .login-box input[type="email"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .login-box button {
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
    }

    .login-box button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

  <div class="login-box">
    <h2>Login</h2>
    <form id="loginForm">
      <label for="email">Email</label>
      <input type="email" id="email" required>

      <label for="password">Password</label>
      <input type="password" id="password" required>

      <button type="submit">Login</button>
    </form>
  </div>

  <script>
    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      // Dummy check
      if (email === 'admin@example.com' && password === 'password123') {
        alert('Login successful!');
        // You can redirect or load another page here
      } else {
        alert('Invalid email or password');
      }
    });
  </script>

</body>
</html>
