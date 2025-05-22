<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Khwaja Yunus Ali Medical College Meal Ordering System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            max-width: 600px;
            text-align: center;
        }
        h1 {
            color: #1e40af;
            margin-bottom: 20px;
        }
        p.description {
            font-size: 18px;
            line-height: 1.5;
            margin-bottom: 30px;
            color: #555;
        }
        .buttons a {
            display: inline-block;
            margin: 10px 20px;
            padding: 15px 30px;
            font-size: 18px;
            text-decoration: none;
            color: white;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        a.admin-btn {
            background-color: #f59e0b; /* amber */
        }
        a.admin-btn:hover {
            background-color: #d97706;
        }
        a.kitchen-btn {
            background-color: #22c55e; /* green */
        }
        a.kitchen-btn:hover {
            background-color: #15803d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Meal Ordering System</h1>
        <p class="description">
            Welcome to the Meal Ordering System — a simple and efficient platform to place and manage daily meal orders for students, teachers, and staff. 
            Order your meals online, track your orders, and enjoy a smooth dining experience.
        </p>
        <div class="buttons">
            <a href="/admin/login" class="admin-btn">Login as Admin</a>
            <a href="/kitchen/login" class="kitchen-btn">Login as Kitchen Manager</a>
        </div>
    </div>
</body>
</html>
