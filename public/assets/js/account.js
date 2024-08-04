const sendCodeButton = document.getElementById('sendCodeButton');
sendCodeButton.addEventListener('click', () => {
    fetch('/sendemail', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({   
email: document.getElementById('email').value })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            sendCodeButton.disabled = true;
            setTimeout(() => {
                sendCodeButton.disabled = false;
            }, 30000);
        }
    });
});