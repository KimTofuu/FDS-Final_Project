document.getElementById('adminLoginForm').addEventListener('submit', async function (event) {
    event.preventDefault();
    const adminUsername = document.getElementById('adminUsername').value;
    const adminPassword = document.getElementById('adminPassword').value;

    const response = await fetch('http://localhost/Olympus/Backend/Login/Admin', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ Username: adminUsername, Password: adminPassword })
    });

    const result = await response.json();
    console.log(result);  // This will log the entire response from the backend

    // Check login status and redirect accordingly
    if (result.status.remarks === 'success') {
        if (result.payload.user_type === 'admin') {
            window.location.href = 'http://localhost/Olympus/transRoutes/admin_dashboard.php';
        }
    } else {
        document.getElementById('error-message').textContent = result.message;  // Display error message
    }
});

document.getElementById('memberLoginForm').addEventListener('submit', async function (event) {
    event.preventDefault();
    const memberUsername = document.getElementById('memberUsername').value;
    const memberPassword = document.getElementById('memberPassword').value;

    const response = await fetch('http://localhost/Olympus/Backend/Login/Member', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ Username: memberUsername, Password: memberPassword })
    });

    const result = await response.json();
    
    // Check login status and redirect accordingly
    if (result.status.remarks === 'success') {
        if (result.payload.user_type === 'member' || result.payload.user_type === 'admin') {
            window.location.href = 'http://localhost/Olympus/transRoutes/member_dashboard.php';
        }
    } else {
        document.getElementById('error-message').textContent = result.message;  // Display error message
    }
});
// document.getElementById('memberLoginForm').addEventListener('submit', async function (event) {
//     event.preventDefault();
//     const memberUsername = document.getElementById('memberUsername').value;
//     const memberPassword = document.getElementById('memberPassword').value;

//     const response = await fetch('http://localhost/Olympus/Backend/Login/Member', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({ Username: memberUsername, Password: memberPassword })
//     });

//     const result = await response.json();
//     console.log(result);

//     if (result.status === 'success') {
//         if (result.payload.user_type === 'member') {
//             window.location.href = '/transRoutes/member_dashboard.php';
//         }
//     } else {
//         console.log('Login failed:', result.status.message);
//     }
    
// });

// document.getElementById('adminLoginForm').addEventListener('submit', async function (event) {
//     event.preventDefault();
//     const adminUsername = document.getElementById('adminUsername').value;
//     const adminPassword = document.getElementById('adminPassword').value;

//     const response = await fetch('http://localhost/Olympus/Backend/Login/Admin', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({ Username: adminUsername, Password: adminPassword })
//     });

//     const result = await response.json();
//     console.log(result);

//     if (result.status === 'success') {
//         if (result.payload.user_type === 'admin') {
//             window.location.href = '/transRoutes/admin_dashboard.php';
//         }
//     } else {
//         console.log('Login failed:', result.status.message);
//     }
    
// });

document.getElementById('adminRegForm').addEventListener('submit', async function (event) {
    event.preventDefault();
    const newAdminUsername = document.getElementById('newAdminUsername').value;
    const newAdminPassword = document.getElementById('newAdminPassword').value;

    const response = await fetch('http://localhost/Olympus/Backend/Create/Admin', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ Username: newAdminUsername, Password: newAdminPassword })
    });

    const result = await response.json();
    console.log(result);
});
