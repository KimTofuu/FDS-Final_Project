<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <section>
            <h2>Welcome, Admin!</h2>
            <p>You have access to the following features:</p>
            <ul>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="view_reports.php">View Reports</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </section>

        <section>
            <h2>Create Account</h2>
            <form id="createAccountForm">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <label for="subscriptionStat">Subscription Status:</label>
                <input type="text" id="subscriptionStat" name="subscriptionStat" required>
                
                <label for="subPlan">Subscription Plan:</label>
                <input type="text" id="subPlan" name="subPlan" required>
                
                <button type="submit">Create Account</button>
            </form>
            <div id="responseMessage"></div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Olympus System. All rights reserved.</p>
    </footer>

    <script src="adminDashboard.js"></script>
</body>
</html>
