const toUserId = document.getElementById('to_user_id').value; // ID du destinataire
const chatBox = document.getElementById('chat_box');
const messageInput = document.getElementById('message_input');

function fetchMessages() {
    fetch(`fetch_messages.php?to_user_id=${toUserId}`)
        .then(response => response.json())
        .then(data => {
            chatBox.innerHTML = '';
            data.forEach(message => {
                const messageElement = document.createElement('div');
                messageElement.textContent = `${message.from_user_id}: ${message.message}`;
                chatBox.appendChild(messageElement);
            });
        });
}

function sendMessage() {
    const message = messageInput.value;
    fetch('send_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `to_user_id=${toUserId}&message=${message}`
    }).then(response => response.text()).then(data => {
        messageInput.value = '';
        fetchMessages();
    });
}

document.getElementById('send_button').addEventListener('click', sendMessage);

// Refresh messages every 5 seconds
setInterval(fetchMessages, 5000);
