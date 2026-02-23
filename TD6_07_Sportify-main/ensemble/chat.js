const urlParams = new URLSearchParams(window.location.search);
const toUserId = urlParams.get('to_user_id');
const chatBox = document.getElementById('chat_box');
const messageInput = document.getElementById('message_input');
const status = document.getElementById('status');

function fetchMessages() {
    fetch(`fetch_messages.php?to_user_id=${toUserId}`)
        .then(response => response.json())
        .then(data => {
            chatBox.innerHTML = '';
            data.forEach(message => {
                const messageElement = document.createElement('div');
                messageElement.classList.add('message', message.from_user_id == toUserId ? 'coach' : 'user');
                const messageContent = document.createElement('p');
                messageContent.textContent = message.message;
                messageElement.appendChild(messageContent);
                chatBox.appendChild(messageElement);
            });
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

function sendMessage() {
    const message = messageInput.value;
    if (message.trim() === '') return;

    fetch('send_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `to_user_id=${toUserId}&message=${encodeURIComponent(message)}`
    }).then(response => response.text()).then(data => {
        messageInput.value = '';
        fetchMessages();
    });
}

function checkStatus() {
    fetch(`check_status.php?user_id=${toUserId}`)
        .then(response => response.json())
        .then(data => {
            status.textContent = data.online ? 'En ligne' : 'Hors ligne';
            status.style.color = data.online ? 'green' : 'red';
        });
}

document.getElementById('send_button').addEventListener('click', sendMessage);
messageInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

// Refresh messages every 5 seconds
setInterval(fetchMessages, 5000);
// Check status every 5 seconds
setInterval(checkStatus, 5000);

// Initial fetch
fetchMessages();
checkStatus();
