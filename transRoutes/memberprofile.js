// document.addEventListener('DOMContentLoaded', function() {
//     document.getElementById('editInfoForm').addEventListener('submit', async function(event) {
//         event.preventDefault();
        
//         const formData = {
//             name: document.getElementById('name').value,
//             conNum: document.getElementById('conNum').value,
//             eConNum: document.getElementById('eConNum').value,
//             address: document.getElementById('address').value,
//             age: document.getElementById('age').value,
//             sex: document.getElementById('sex').value,
//             gender: document.getElementById('gender').value,
//             weight: document.getElementById('weight').value,
//             height: document.getElementById('height').value,
//         };

//         const response = await fetch('http://localhost/Olympus/Backend/Member/UpdateInfo', {
//             method: 'PUT',
//             headers: {
//                 'Content-Type': 'application/json',
//             },
//             body: JSON.stringify(formData)
//         });
        
//         const result = await response.json();
//         console.log(result)
//     });
// });

// function getUserID() {
//     fetch('http://localhost/Olympus/Backend/getID', {
//         method: 'POST',  // Change this to GET if needed
//         headers: {
//             'Content-Type': 'application/json',
//             'Authorization': 'Bearer ' + getCookie('Authorization')
//         },
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.status === 'success') {
//             document.getElementById('userID').textContent = 'User ID: ' + data.payload;
//         } else {
//             document.getElementById('userID').textContent = 'Error: ' + data.message;
//         }
//     })
//     .catch(error => {
//         console.error('Error:', error);
//         document.getElementById('userID').textContent = 'An error occurred';
//     });
// }

// // Helper function to retrieve a cookie by name
// function getCookie(name) {
//     let cookieArr = document.cookie.split(";");

//     for(let i = 0; i < cookieArr.length; i++) {
//         let cookiePair = cookieArr[i].split("=");

//         if(name == cookiePair[0].trim()) {
//             return decodeURIComponent(cookiePair[1]);
//         }
//     }
//     return null;
// }

document.addEventListener('DOMContentLoaded', function() {
    // Attach event listener to the "Get User ID" button
    document.getElementById('getID').addEventListener('button', async function(event) {
        event.preventDefault();

        const respo = await fetch('http://localhost/Olympus/Backend/getID', {
            method: 'GET',  // Use GET if the API is read-only
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + getCookie('Authorization') // Ensure valid JWT token
            },
        }) 
        const result = await respo.json();
            console.log(result);
    });

    // Attach event listener for the editInfoForm submission
    document.getElementById('editInfoForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        // Collect form data
        const formData = {
            name: document.getElementById('name').value,
            conNum: document.getElementById('conNum').value,
            eConNum: document.getElementById('eConNum').value,
            address: document.getElementById('address').value,
            age: document.getElementById('age').value,
            sex: document.getElementById('sex').value,
            gender: document.getElementById('gender').value,
            weight: document.getElementById('weight').value,
            height: document.getElementById('height').value,
        };

        try {
            // Send data to backend
            const response = await fetch('http://localhost/Olympus/Backend/Member/UpdateInfo', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();
            console.log(result);
        } catch (error) {
            console.error('Error during form submission:', error);
        }
    });
});

// Function to get User ID
function getUserID() {
    fetch('http://localhost/Olympus/Backend/getID', {
        method: 'POST',  // Use GET if the API is read-only
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + getCookie('Authorization') // Ensure valid JWT token
        },
    })
    .then(response => response.json())
    .then(data => {
        console.log('API Response:', data);
        if (data.status === 'success') {
            document.getElementById('userID').textContent = 'User ID: ' + data.payload;
        } else {
            document.getElementById('userID').textContent = 'Error: ' + data.message;
        }
    })
    .catch(error => {
        console.error('Error fetching user ID:', error);
        document.getElementById('userID').textContent = 'An error occurred while fetching the user ID';
    });
}

// Helper function to retrieve a cookie by name
function getCookie(name) {
    let cookieArr = document.cookie.split(";");

    for (let i = 0; i < cookieArr.length; i++) {
        let cookiePair = cookieArr[i].split("=");

        if (name === cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }
    return null;
}
