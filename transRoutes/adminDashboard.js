document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('createAccountForm').addEventListener('submit', async function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = {
            Email: document.getElementById('email').value,
            Username: document.getElementById('username').value,
            Password: document.getElementById('password').value,
            SubscriptionStat: document.getElementById('subscriptionStat').value,
            subPlan: document.getElementById('subPlan').value
        };

        const response = await fetch('http://localhost/Olympus/Backend/Create', { // Adjust the path to your actual API endpoint
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        });

        const result = await response.json();
        console.log(result)
    });
});
