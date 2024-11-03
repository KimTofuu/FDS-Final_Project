import fetch from 'node-fetch';

const expiry_url = 'http://localhost/Olympus/Backend/Send/Expiry';
const alarm_url = 'http://localhost/Olympus/Backend/Send/Alarm';
const session_url = 'http://localhost/Olympus/Backend/Send/Session';
const p_unp_stat_url = 'http://localhost/Olympus/Backend/ChangeSubStat';

async function sendExpiry() {
    try {
        const response = await fetch(expiry_url, {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json', 
            },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Response data:', data);
    } catch (error) {
        console.error('Error sending expiry:', error);
    }
}

async function sendAlarm() {
    try {
        const response = await fetch(alarm_url, {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json', 
            },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Response data:', data);
    } catch (error) {
        console.error('Error sending alarm  :', error);
    }
}

async function sendSessionRem() {
    try {
        const response = await fetch(session_url, {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json', 
            },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Response data:', data);
    } catch (error) {
        console.error('Error sending session reminder:', error);
    }
}

async function updateP_unPstat() {
    try {
        const response = await fetch(p_unp_stat_url, {
            method: 'PUT', 
            headers: {
                'Content-Type': 'application/json', 
            },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Response data:', data);
    } catch (error) {
        console.error('Updating data:', error);
    }
}

sendExpiry();
sendAlarm();
sendSessionRem();
updateP_unPstat();
