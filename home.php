<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: signin.php");
    exit();
}

$userId = $_SESSION['id'];
$school = null;
$isadmin = 'false';
$isteacher = 'false';
$isstudent = 'false';

if ($userId) {
    $stmt = $conn->prepare("SELECT school, isadmin, isteacher, isstudent FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($userRow) {
        $school = $userRow['school'];
        $isadmin = $userRow['isadmin'];
        $isteacher = $userRow['isteacher'];
        $isstudent = $userRow['isstudent'];
    }
}



$stmt = $conn->prepare("SELECT school, isadmin, isteacher, isstudent FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


$isadmin = $user['isadmin'] ?? 'false';
$isteacher = $user['isteacher'] ?? 'false';
$isstudent = $user['isstudent'] ?? 'false';


$schools = [
    'Xhevdet Doda' => [
        'file' => 'xhevdetdoda.php',
        'image' => 'images/xhevdetdoda.jpeg'
    ],
    'Sami Frasheri' => [
        'file' => 'samifrasheri.php',
        'image' => 'images/samifrasheri.jpg'
    ],
    'Ahmet Gashi' => [
        'file' => 'ahmetgashi.php',
        'image' => 'images/ahmetgashi.jpg'
    ]
];


if ($user['isstudent'] || $user['isteacher']) {
    $schools = array_filter($schools, function ($key) use ($user) {
        return strtolower(str_replace(' ', '', $key)) === strtolower($user['school']);
    }, ARRAY_FILTER_USE_KEY);
}

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

    .card-section {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
        padding: 40px 20px;
        background-color: #e9eff6;
    }
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        width: 280px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: scale(1.03);
    }
    .card img {
        width: 60px;
        height: 60px;
        margin-bottom: 15px;
    }
    .card h3 {
        color: #003366;
        margin-bottom: 10px;
    }
    .card p {
        color: #555;
        font-size: 14px;
        margin-bottom: 15px;
    }
    .card a {
        display: inline-block;
        padding: 10px 18px;
        background-color: #003366;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
    }
    .card a:hover {
        background-color: #002244;
    }



  </style>
</head>
<body>
  <div class="navbar">
    <h1>EduPrishtina</h1>
    <?php if (isset($isadmin) && $isadmin === 'true'): ?>
    <a href="manageUsers.php" style="margin-left: 20px; background-color:rgb(251, 251, 252); color: blue; padding: 8px 12px; border-radius: 5px; text-decoration: none;">
        Manage Users
    </a>
<?php endif; ?>

    <div class="user-menu">
      <div class="user-icon"></div>
      <div class="dropdown">
        <a href="signout.php">Sign Out</a>
      </div>
    </div>
  </div>


  <?php if ($isadmin !== 'true' && $isteacher !== 'true' && $isstudent !== 'true'): ?>
    

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

<?php endif; ?>

  


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
      <h2>Prishtina Schools Begin Digital Transformation Ahead of 2025 Academic Year</h2>
      <p>In a move to modernize education, several schools in Prishtina have begun implementing digital platforms to improve communication between students, teachers, and parents. As part of a municipal initiative supported by the Ministry of Education, platforms like EduPrishtina are being introduced to allow students to check grades, schedules, and communicate more easily with educators.

Additionally, schools are preparing for the national standardized testing scheduled for late spring 2025. Teachers are undergoing professional development sessions to adapt to new teaching methodologies and technology integration in classrooms.

The initiative reflects Prishtina’s growing commitment to innovation in education, aiming to enhance student performance, transparency, and academic support across all grade levels.

</p>
    </div>

    <div class="access-warning">
  <strong>⚠️ Access Restricted:</strong> Only students or teachers of the selected school can access that school’s page.
</div>


    <div class="school-container">
  <?php if ($isadmin === 'true' || $school === 'xhevdetdoda'): ?>
    <a href="xhevdetdoda.php" class="school-card">
      <img src="images/xhevdetdoda.jpeg" alt="Xhevdet Doda">
      <h3>Xhevdet Doda</h3>
    </a>
  <?php endif; ?>

  <?php if ($isadmin === 'true' || $school === 'samifrasheri'): ?>
    <a href="samifrasheri.php" class="school-card">
      <img src="images/samifrasheri.jpg" alt="Sami Frasheri">
      <h3>Sami Frasheri</h3>
    </a>
  <?php endif; ?>

  <?php if ($isadmin === 'true' || $school === 'ahmetgashi'): ?>
    <a href="ahmetgashi.php" class="school-card">
      <img src="images/ahmetgashi.jpg" alt="Ahmet Gashi">
      <h3>Ahmet Gashi</h3>
    </a>
  <?php endif; ?>
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


  



  <div class="card-section">
    <div class="card">
        <img src="images/checkmark.png" alt="Verification">
        <h3>Verification Notice</h3>
        <p>Check how user verification works and what it means for your account.</p>
        <a href="verificationNotice.php">Go to Page</a>
    </div>

    <div class="card">
        <img src="images/calculator.png" alt="Calculator">
        <h3>Online Calculator</h3>
        <p>Use our integrated calculator for schoolwork and quick math.</p>
        <a href="calculator.php">Try It</a>
    </div>

    <div class="card">
        <img src="images/lightbulb.png" alt="Project Idea">
        <h3>About the Project</h3>
        <p>Understand the idea and motivation behind EduPrishtina's creation.</p>
        <a href="projectIdea.php">Learn More</a>
    </div>
    <div class="card">
        <img src="images/calendar.png" alt="Project Idea">
        <h3>Calendar</h3>
        <p>Take a look and dont miss a day of this year's school official calendar. 2024/2025</p>
        <a href="schoolCalendar.php">Take a Peek</a>
    </div>
</div>



  

   
  <footer class="footer">
    <p>Contact: info@eduprishtina.com | +383 44 123 456</p>
    <p>&copy; 2025 EduPrishtina. All rights reserved.</p>
  </footer>

 
<button id="scrollToTopBtn" title="Go to top">↑</button>

<script>
  
  const scrollToTopBtn = document.getElementById("scrollToTopBtn");

  
  window.addEventListener("scroll", () => {
    if (window.scrollY > 300) {
      scrollToTopBtn.style.display = "block";
    } else {
      scrollToTopBtn.style.display = "none";
    }
  });

  
  scrollToTopBtn.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
</body>
</html>
