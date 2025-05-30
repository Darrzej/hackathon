<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign Up - EduPrishtina</title>
  <link rel="stylesheet" href="signup.css" />
</head>
<body>

  <div class="auth-container">
    <div class="form-box">
      <h2>Create an Account</h2>
      <form action="register.php" method="POST">
        <div class="input-group">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" required />
        </div>
        <div class="input-group">
          <label for="surname">Surname</label>
          <input type="text" id="surname" name="surname" required />
        </div>
        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
        </div>
        <div class="input-group">
          <label for="school">School</label>
          <input type="text" id="school" name="school" required />
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required />
        </div>
        <div class="input-group">
          <label for="confirm_password">Confirm Password</label>
          <input type="password" id="confirm_password" name="confirm_password" required />
        </div>
        <button type="submit" class="btn">Sign Up</button>
      </form>
      <p class="switch-link">Already have an account? <a href="signin.php">Sign In</a></p>
    </div>
  </div>

</body>
</html>
