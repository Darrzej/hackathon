<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Idea - EduPrishtina</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e6f0ff, #ffffff);
            color: #003366;
        }
        header, footer {
            background-color: #003366;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        nav {
            background-color: #002244;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        nav a:hover {
            color: #ffcc00;
        }
        .container {
            padding: 40px 20px;
            max-width: 1000px;
            margin: 0 auto;
        }
        .section {
            background-color: white;
            margin-bottom: 30px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .section h2 {
            color: #003366;
            margin-bottom: 15px;
        }
        .section p {
            line-height: 1.6;
        }
        .highlight {
            color: #ffcc00;
            font-weight: bold;
        }
        .signature {
            text-align: right;
            font-style: italic;
            margin-top: 40px;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <header>
        <h1>EduPrishtina - Project Vision</h1>
    </header>

    <nav>
        <div><a href="home.php">Home</a></div>
        <div>
            <a href="verificationNotice.php">Verification</a>
            <a href="calculator.php">Calculator</a>
            <a href="projectIdea.php">Project Idea</a>
        </div>
    </nav>

    <div class="container">
        <div class="section">
            <h2>Where the Idea Began</h2>
            <p>As an 11th grade student, I often noticed how much class time is spent telling students their grades. I realized this time could be used much more efficiently. That's when I thought of <span class="highlight">EduPrishtina</span>: a platform where students can instantly view their grades online and stay updated on their academic progress.</p>
        </div>

        <div class="section">
            <h2>The Purpose</h2>
            <p>High school is a critical stage before college, and knowing where you stand academically can make a huge difference. By offering easy access to grades, schedules, and statistics, students can prepare more effectively. For teachers, this platform allows secure updates and tracking of student performance.</p>
        </div>

        <div class="section">
            <h2>How It Works</h2>
            <p>EduPrishtina is designed for both <span class="highlight">students</span> and <span class="highlight">teachers</span>. Verified users can access personalized features: students see their grades, while teachers can edit, filter, and view statistics of their students. Teachers only have access to the schools they are associated with, ensuring privacy and organization.</p>
        </div>

        <div class="section">
            <h2>Why Verification Matters</h2>
            <p>Anyone can register on EduPrishtina, but only verified users get full access. If someone logs in but cannot use school-specific features, it means they are pending verification by the admin. To be verified, users must send an email using their sign-up email, attaching birth certificates (theirs and their parents') and provide their school, address, and grade level (10th, 11th, or 12th).</p>
        </div>

        <div class="section">
            <h2>The Future Potential</h2>
            <p>This is just the beginning. EduPrishtina could evolve to include features for parents, specific subject teachers, and even school directors. It could become a national educational tool that transforms how we manage school data — a digital upgrade that could put Kosovo on the map for educational innovation.</p>
        </div>

        <div class="signature">
            This project was created by <strong>Darsej Kastrati</strong>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 EduPrishtina. All rights reserved.</p>
    </footer>
</body>
</html>
