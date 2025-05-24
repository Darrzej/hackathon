<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign In - EduPrishtina</title>
  <link rel="stylesheet" href="signup.css" />
</head>
<body>

  <div class="auth-container">
    <div class="form-box">
      <h2>Welcome Back</h2>
      <form action="signinLogic.php" method="POST">
        <div class="input-group">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" required />
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required />
        </div>
        <button type="submit" class="btn">Sign In</button>
      </form>
      <p class="switch-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
  </div>

</body>
</html>
