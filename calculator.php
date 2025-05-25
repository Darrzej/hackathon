<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPrishtina Calculator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }
        header {
            background-color: #003366;
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav {
            background-color: #002244;
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 15px;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }
        .calculator {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 20px;
        }
        .display {
            width: 100%;
            height: 80px;
            background-color: #e0e6ed;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: right;
            font-size: 36px;
            line-height: 80px;
            padding: 0 20px;
            box-sizing: border-box;
            overflow: hidden;
        }
        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        .buttons button {
            height: 60px;
            font-size: 20px;
            border: none;
            border-radius: 10px;
            background-color: #003366;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .buttons button:hover {
            background-color: #0055aa;
        }
        .extra-features {
            margin-top: 40px;
            text-align: center;
            max-width: 600px;
        }
        .extra-features h3 {
            color: #003366;
        }
        .extra-features p {
            color: #333;
        }
        footer {
            background-color: #003366;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 60px;
        }
    </style>
</head>
<body>

<header>
    <h1>EduPrishtina Calculator</h1>
</header>

<nav>
    <a href="home.php">Home</a>
    <a href="calculator.php">Calculator</a>
    <a href="verificationNotice.php">Verification</a>
    <a href="aboutProject.php">About</a>
</nav>

<div class="container">
    <div class="calculator">
        <div class="display" id="display">0</div>
        <div class="buttons">
            <button onclick="clearDisplay()">C</button>
            <button onclick="appendValue('(')">(</button>
            <button onclick="appendValue(')')">)</button>
            <button onclick="appendValue('/')">÷</button>
            <button onclick="appendValue('7')">7</button>
            <button onclick="appendValue('8')">8</button>
            <button onclick="appendValue('9')">9</button>
            <button onclick="appendValue('*')">×</button>
            <button onclick="appendValue('4')">4</button>
            <button onclick="appendValue('5')">5</button>
            <button onclick="appendValue('6')">6</button>
            <button onclick="appendValue('-')">−</button>
            <button onclick="appendValue('1')">1</button>
            <button onclick="appendValue('2')">2</button>
            <button onclick="appendValue('3')">3</button>
            <button onclick="appendValue('+')">+</button>
            <button onclick="appendValue('0')">0</button>
            <button onclick="appendValue('.')">.</button>
            <button onclick="deleteLast()">⌫</button>
            <button onclick="calculateResult()">=</button>
        </div>
    </div>

    <div class="extra-features">
        <h3>Smart Features</h3>
        <p>This calculator supports real-time expression evaluation, keyboard input, and smart deletion. Great for fast school-related calculations!</p>
    </div>
</div>

<footer>
    <p>&copy; 2025 EduPrishtina. All rights reserved.</p>
</footer>

<script>
    const display = document.getElementById("display");
    function appendValue(val) {
        if (display.innerText === "0") display.innerText = val;
        else display.innerText += val;
    }
    function clearDisplay() {
        display.innerText = "0";
    }
    function deleteLast() {
        let txt = display.innerText;
        if (txt.length > 1) display.innerText = txt.slice(0, -1);
        else display.innerText = "0";
    }
    function calculateResult() {
        try {
            display.innerText = eval(display.innerText);
        } catch (e) {
            display.innerText = "Error";
        }
    }
    document.addEventListener("keydown", function(e) {
        const keys = "0123456789+-*/().";
        if (keys.includes(e.key)) appendValue(e.key);
        else if (e.key === "Backspace") deleteLast();
        else if (e.key === "Enter") calculateResult();
    });
</script>

</body>
</html>
