// Admin Login Form
document.getElementById('adminLoginForm').addEventListener('submit', async function (event) {
    event.preventDefault();
    
    const adminUsername = document.getElementById('adminUsername').value;
    const adminPassword = document.getElementById('adminPassword').value;

    try {
        const response = await fetch('http://localhost/Olympus/Backend/Login/Admin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ Username: adminUsername, Password: adminPassword })
        });

        const result = await response.json();
        console.log(result);

        if (result.status.remarks === 'success' && result.payload.user_type === 'admin') {
            window.location.href = 'http://localhost/Olympus/transRoutes/admin_dashboard.php';
        } else {
            document.getElementById('error-message').textContent = result.message;
        }
    } catch (error) {
        document.getElementById('error-message').textContent = 'An error occurred during the login process.';
    }
});

// Member Login Form
document.getElementById('memberLoginForm').addEventListener('submit', async function (event) {
    event.preventDefault();

    const memberUsername = document.getElementById('memberUsername').value;
    const memberPassword = document.getElementById('memberPassword').value;

    try {
        const response = await fetch('http://localhost/Olympus/Backend/Login/Member', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ Username: memberUsername, Password: memberPassword })
        });

        const result = await response.json();
        console.log(result);

        if (result.status.remarks === 'success' && (result.payload.user_type === 'member' || result.payload.user_type === 'admin')) {
            window.location.href = 'http://localhost/Olympus/transRoutes/member_dashboard.php';
        } else {
            document.getElementById('error-message').textContent = result.message;
        }
    } catch (error) {
        document.getElementById('error-message').textContent = 'An error occurred during the login process.';
    }
});

// Coach Login Form
document.getElementById('coachLoginForm').addEventListener('submit', async function (event) {
    event.preventDefault();

    const coachUsername = document.getElementById('coachUsername').value;
    const coachPassword = document.getElementById('coachPassword').value;

    try {
        const response = await fetch('http://localhost/Olympus/Backend/Login/Coach', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ Username: coachUsername, Password: coachPassword })
        });

        const result = await response.json();
        console.log(result);

        if (result.status.remarks === 'success' && result.payload.user_type === 'coach') {
            window.location.href = 'http://localhost/Olympus/transRoutes/coach_dashboard.php';
        } else {
            document.getElementById('error-message').textContent = result.message;
        }
    } catch (error) {
        document.getElementById('error-message').textContent = 'An error occurred during the login process.';
    }
});

// Admin Registration Form
document.getElementById('adminRegForm').addEventListener('submit', async function (event) {
    event.preventDefault();
    
    const newAdminUsername = document.getElementById('newAdminUsername').value;
    const newAdminPassword = document.getElementById('newAdminPassword').value;

    try {
        const response = await fetch('http://localhost/Olympus/Backend/Create/Admin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ Username: newAdminUsername, Password: newAdminPassword })
        });

        const result = await response.json();
        console.log(result);

        if (result.status.remarks === 'success') {
            window.location.href = 'http://localhost/Olympus/transRoutes/admin_dashboard.php';
        } else {
            document.getElementById('error-message').textContent = result.message;
        }
    } catch (error) {
        document.getElementById('error-message').textContent = 'An error occurred during the registration process.';
    }
});
