document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('editInfoForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        
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

        const response = await fetch('http://localhost/Olympus/Backend/Member/UpdateInfo', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });
        
        const result = await response.json();
        console.log(result)
    });
});