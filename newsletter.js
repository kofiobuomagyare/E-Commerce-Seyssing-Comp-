document.getElementById('newsletter-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('email').value;
    const messageDiv = document.getElementById('message');

    fetch('subscribe.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        messageDiv.textContent = data.message;
        messageDiv.style.color = data.success ? 'green' : 'red';
    })
    .catch(error => {
        messageDiv.textContent = 'An error occurred. Please try again.';
        messageDiv.style.color = 'red';
    });

    document.getElementById('email').value = '';
});
