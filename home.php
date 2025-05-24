<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduPrishtina - Home</title>
  <style>
    :root {
      --primary-blue: #0057b7;
      --kosovo-yellow: #ffd700;
      --light-blue: #e6f0ff;
      --soft-yellow: #fff9e6;
      --background: #edf0f8;
      --card-bg: #ffffff;
      --text-color: #333;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--background);
      color: var(--text-color);
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      background-color: var(--primary-blue);
      color: white;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .navbar h1 {
      margin: 0;
      font-size: 1.8rem;
      font-weight: 600;
    }

    .user-menu {
      position: relative;
    }

    .user-icon {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background-color: white;
      background-image: url('https://cdn-icons-png.flaticon.com/512/847/847969.png');
      background-size: cover;
      background-position: center;
      cursor: pointer;
      border: 2px solid var(--kosovo-yellow);
    }

    .dropdown {
      display: none;
      position: absolute;
      right: 0;
      background-color: white;
      min-width: 140px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      z-index: 100;
      border-radius: 8px;
      overflow: hidden;
      transition: 0.3s;
    }

    .user-menu:hover .dropdown {
      display: block;
    }

    .dropdown a {
      color: var(--primary-blue);
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      font-weight: 500;
    }

    .dropdown a:hover {
      background-color: #f0f4fa;
    }

    .content {
      padding: 2rem;
      max-width: 1200px;
      margin: auto;
    }

    .instructions, .news-section {
      background: white;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      margin-bottom: 2.5rem;
      transition: 0.3s;
    }

    .instructions:hover, .news-section:hover {
      transform: translateY(-5px);
    }

    .instructions h2, .news-section h2 {
      color: var(--primary-blue);
      margin-bottom: 1rem;
    }

    .instructions ul {
      padding-left: 1.5rem;
      line-height: 1.6;
    }

    .school-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
      padding: 2rem 0;
    }

    .school-card {
      background-color: var(--card-bg);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      text-decoration: none;
      color: inherit;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .school-card:hover {
      transform: scale(1.03);
      box-shadow: 0 12px 34px rgba(0, 0, 0, 0.12);
    }

    .school-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .school-card h3 {
      text-align: center;
      padding: 1rem;
      font-size: 1.3rem;
      color: var(--primary-blue);
      background-color: #f0f4fa;
    }

    .statistics-section {
      background: var(--soft-yellow);
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      margin-top: 2.5rem;
    }

    .statistics-section h2 {
      color: var(--primary-blue);
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .statistics-cards {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      gap: 2rem;
    }

    .stat-card {
      background-color: white;
      border-radius: 15px;
      padding: 1.5rem;
      text-align: center;
      width: 280px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      transition: 0.3s;
    }

    .stat-card:hover {
      transform: translateY(-5px);
    }

    .stat-card img {
      width: 80px;
      height: 80px;
      margin-bottom: 1rem;
    }

    .stat-card h4 {
      margin-bottom: 0.5rem;
      color: var(--primary-blue);
    }

    .stat-card p {
      font-size: 0.95rem;
      color: #555;
    }
    .footer {
  background-color: #1e3a8a;
  color: white;
  text-align: center;
  padding: 2rem;
  font-size: 0.9rem;
  margin-bottom: -3%;
}
#scrollToTopBtn {
  position: fixed;
  bottom: 30px;
  right: 30px;
  z-index: 100;
  background-color: #f5cc18;
  color: white;
  border: none;
  border-radius: 50%;
  padding: 15px 20px;
  font-size: 20px;
  cursor: pointer;
  display: none;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  transition: background-color 0.3s ease, transform 0.3s ease;
}

#scrollToTopBtn:hover {
  background-color: #2d039e;
  transform: scale(1.1);
}
.access-warning {
  background-color: var(--soft-yellow);
  border-left: 5px solid var(--kosovo-yellow);
  padding: 1rem 1.5rem;
  margin-bottom: 2rem;
  border-radius: 12px;
  font-size: 1rem;
  box-shadow: 0 4px 14px rgba(0,0,0,0.05);
  color: #665200;
}
.verification-notice {
  background: linear-gradient(135deg, #0057b7, #003f91);
  color: white;
  padding: 2rem;
  text-align: center;
  border-radius: 0 0 20px 20px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  margin-bottom: 2rem;
}

.verification-notice h2 {
  margin-top: 0;
  font-size: 1.8rem;
  margin-bottom: 1rem;
}

.verification-notice p {
  font-size: 1rem;
  line-height: 1.6;
  max-width: 700px;
  margin: 0 auto 1rem;
}

.verification-notice a {
  color: #ffd700;
  text-decoration: underline;
  font-weight: bold;
}


  </style>
</head>
<body>
  <div class="navbar">
    <h1>EduPrishtina</h1>
    <div class="user-menu">
      <div class="user-icon"></div>
      <div class="dropdown">
        <a href="signout.php">Sign Out</a>
      </div>
    </div>
  </div>

  <div class="verification-notice">
  <h2>🔐 Verify Your School Affiliation</h2>
  <p>
    To access your school's page on EduPrishtina, please send an email to 
    <a href="mailto:info@eduprishtina.com">info@eduprishtina.com</a> with proof of your enrollment or employment at your school.
  </p>
  <p>
    Our administrators will review your request and grant access accordingly. This is required to ensure the privacy and integrity of each school’s data.
  </p>
</div>


  <div class="content">
    <div class="instructions">
      <h2>Welcome to EduPrishtina</h2>
      <p>This platform is designed to increase transparency and communication between teachers and students across schools in Prishtina.</p>
      <ul>
        <li><strong>Students:</strong> can view their grades and class schedules.</li>
        <li><strong>Teachers:</strong> can update student grades, modify schedules, and add comments explaining any changes made.</li>
      </ul>
    </div>

    <div class="news-section">
      <h2>Latest News</h2>
      <p>No news at the moment. Stay tuned for upcoming announcements and updates from your schools.</p>
    </div>

    <div class="access-warning">
  <strong>⚠️ Access Restricted:</strong> Only students or teachers of the selected school can access that school’s page.
</div>


    <div class="school-container">
      <a href="xhevdetdoda.php" class="school-card">
        <img src="images/xhevdetdoda.jpeg" alt="Xhevdet Doda">
        <h3>Xhevdet Doda</h3>
      </a>

      <a href="samifrasheri.php" class="school-card">
        <img src="images/samifrasheri.jpg" alt="Sami Frasheri">
        <h3>Sami Frasheri</h3>
      </a>

      <a href="ahmetgashi.php" class="school-card">
        <img src="images/ahmetgashi.jpg" alt="Ahmet Gashi">
        <h3>Ahmet Gashi</h3>
      </a>
    </div>

    <div class="statistics-section">
      <h2>Academic Statistics Overview</h2>
      <div class="statistics-cards">
        <div class="stat-card">
          <img src="https://cdn-icons-png.flaticon.com/512/201/201613.png" alt="Student Stats">
          <h4>Student Stats</h4>
          <p>Students can track their progress and see detailed grade breakdowns by subject.</p>
        </div>
        <div class="stat-card">
          <img src="https://cdn-icons-png.flaticon.com/512/2920/2920022.png" alt="Teacher View">
          <h4>Teacher Access</h4>
          <p>Teachers can view class-wide performance trends and individual student progress.</p>
        </div>
        <div class="stat-card">
          <img src="https://cdn-icons-png.flaticon.com/512/2948/2948035.png" alt="Transparency">
          <h4>Transparency Tools</h4>
          <p>Every grade update is logged with a comment to ensure clear communication.</p>
        </div>
      </div>
    </div>
  </div>

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
