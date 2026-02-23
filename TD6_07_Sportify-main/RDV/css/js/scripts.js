document.addEventListener('DOMContentLoaded', function() {
    loadAppointments();

    function loadAppointments() {
        fetch('php/appointments.php')
            .then(response => response.json())
            .then(data => {
                const appointmentsDiv = document.getElementById('appointments');
                appointmentsDiv.innerHTML = '';
                data.forEach(appointment => {
                    const appointmentDiv = document.createElement('div');
                    appointmentDiv.className = 'appointment';
                    appointmentDiv.innerHTML = `
                        <h2>Rendez-vous avec ${appointment.coach_name}</h2>
                        <p>Date et Heure: ${appointment.date_rendezvous}</p>
                        <p>Adresse: ${appointment.adresse}</p>
                        <p>Informations: ${appointment.informations}</p>
                        <button class="cancel-button" data-id="${appointment.rendezvous_id}">Annulation de RDV</button>
                    `;
                    appointmentsDiv.appendChild(appointmentDiv);
                });

                document.querySelectorAll('.cancel-button').forEach(button => {
                    button.addEventListener('click', function() {
                        const rendezvousId = this.getAttribute('data-id');
                        cancelAppointment(rendezvousId);
                    });
                });
            });
    }

    function cancelAppointment(rendezvousId) {
        fetch('php/cancel_appointment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ rendezvous_id: rendezvousId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadAppointments();
            } else {
                alert('Échec de l\'annulation du rendez-vous.');
            }
        });
    }
});
