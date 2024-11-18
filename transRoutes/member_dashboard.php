<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <header>
        <h1>Member Dashboard</h1>
        <nav>
            <ul>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <section>
            <h2>Welcome, Member!</h2>
            <p>You have access to the following features:</p>
            <ul>
                <li><a href="#" onclick="viewProfile()">View Profile</a></li> <!-- Call JS function -->
                <li><a href="memberprofile.php">Update Profile</a></li>
                <li><a href="submit_request.html">Submit Request</a></li>
            </ul>
        </section>

        <section id="profile-info" style="display:none;">
            <h2>Your Profile</h2>
            <div id="profile-details">
                <!-- Profile information will be populated here using JavaScript -->
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Olympus System. All rights reserved.</p>
    </footer>
    
    <script src="memberDashboard.js"></script>]
</body>
</html>
