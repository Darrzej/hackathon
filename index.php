<?php

   session_start()

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>EduPrishtina</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <!-- Navigation Bar -->
  <header class="navbar">
    <div class="logo">EduPrishtina</div>
    <div class="nav-buttons">
      <a href="signin.php" class="btn">Sign In</a>
      <a href="signup.php" class="btn primary">Sign Up</a>
    </div>
  </header>

  <!-- Hero Banner -->
  <section class="hero">
    <div class="hero-content">
      <h1>Welcome to EduPrishtina</h1>
      <p>Empowering education in Kosovo with transparency and technology.</p>
    </div>
  </section>

  <!-- Features -->
  <!-- Features with Background -->
<section class="features-background">
  <div class="features-overlay">
    <div class="features">
      <div class="feature-card blue-bg">
        <h2>📘 Transparency</h2>
        <p>Students and teachers stay connected with real-time updates, feedback, and visibility into progress.</p>
      </div>
      <div class="feature-card yellow-bg">
        <h2>🗓️ Easy Access</h2>
        <p>Check your school calendar, see grades instantly, and stay up to date—all in one place.</p>
      </div>
      <div class="feature-card lightblue-bg">
        <h2>📊 Teacher Tools</h2>
        <p>Teachers can update grades and monitor progress through powerful, visual statistical tools.</p>
      </div>
    </div>
  </div>
</section>


  <!-- Footer -->
  <footer class="footer">
    <p>Contact: info@eduprishtina.com | +383 44 123 456</p>
    <p>&copy; 2025 EduPrishtina. All rights reserved.</p>
  </footer>

  <!-- Scroll to Top Button -->
<button id="scrollToTopBtn" title="Go to top">↑</button>

<script>
  // Get the button
  const scrollToTopBtn = document.getElementById("scrollToTopBtn");

  // Show the button when scrolled down
  window.addEventListener("scroll", () => {
    if (window.scrollY > 300) {
      scrollToTopBtn.style.display = "block";
    } else {
      scrollToTopBtn.style.display = "none";
    }
  });

  // Scroll to top when clicked
  scrollToTopBtn.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>


</body>
</html>




