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
            <h3>Your Profile</h3>
        </section>
        <section>
            <form id="editInfoForm">
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name" required><br><br>
                
                <label for="conNum">Contact Number:</label><br>
                <input type="text" id="conNum" name="conNum" required><br><br>
                
                <label for="eConNum">Emergency Contact Number:</label><br>
                <input type="text" id="eConNum" name="eConNum" required><br><br>
                
                <label for="address">Address:</label><br>
                <input type="text" id="address" name="address" required><br><br>
                
                <label for="age">Age:</label><br>
                <input type="number" id="age" name="age" required><br><br>
                
                <label for="sex">Sex:</label><br>
                <input type="text" id="sex" name="sex" required><br><br>
                
                <label for="gender">Gender:</label><br>
                <input type="text" id="gender" name="gender" required><br><br>
                
                <label for="weight">Weight (kg):</label><br>
                <input type="number" id="weight" name="weight" required><br><br>
                
                <label for="height">Height (cm):</label><br>
                <input type="number" id="height" name="height" required><br><br>
                
                <button type="submit">Submit</button>
            </form>

            <div id="responseMessage"></div>
        </section>
    </main>
    <script src="memberprofile.js"></script>
</body>
</html>