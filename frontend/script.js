const tableBody = document.querySelector('#deviceTable tbody');
const form = document.getElementById('deviceForm');

let isEditing = false;
let editId = null;

// Load all devices
function fetchDevices() {
    fetch('../index.php')
        .then(res => res.json())
        .then(data => {
            console.log("Fetched devices:", data);
            tableBody.innerHTML = '';
            data.forEach(device => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${device.name}</td>
                    <td>${device.type}</td>
                    <td>${device.price}</td>
                    <td>
                        <button class="edit" 
                            data-id="${device.id}" 
                            data-name="${device.name}" 
                            data-type="${device.type}" 
                            data-price="${device.price}">
                            Edit
                        </button>
                        <button class="delete" data-id="${device.id}">Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(err => {
            console.error("Error fetching devices:", err);
        });
}

// Handle form submission (Add or Update)
form.addEventListener('submit', (e) => {
    e.preventDefault();
    const name = document.getElementById('name').value;
    const type = document.getElementById('type').value;
    const price = document.getElementById('price').value;

    const deviceData = { name, type, price };

    const url = isEditing ? `../index.php?id=${editId}` : '../index.php';
    const method = isEditing ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(deviceData)
    })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                form.reset();
                fetchDevices();
                isEditing = false;
                editId = null;
                form.querySelector('button[type="submit"]').textContent = "Add Device";
            } else {
                alert("Failed to submit device.");
            }
        })
        .catch(err => {
            console.error("Error submitting device:", err);
        });
});

// Handle delete and edit buttons
tableBody.addEventListener('click', (e) => {
    if (e.target.classList.contains('delete')) {
        const id = e.target.getAttribute('data-id');

        fetch(`../index.php?id=${id}`, {
            method: 'DELETE'
        })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    fetchDevices();
                } else {
                    alert("Failed to delete.");
                }
            })
            .catch(err => {
                console.error("Error deleting device:", err);
            });
    }

    if (e.target.classList.contains('edit')) {
        isEditing = true;
        editId = e.target.getAttribute('data-id');

        document.getElementById('name').value = e.target.getAttribute('data-name');
        document.getElementById('type').value = e.target.getAttribute('data-type');
        document.getElementById('price').value = e.target.getAttribute('data-price');

        form.querySelector('button[type="submit"]').textContent = "Update Device";
    }
});

// Initial load
fetchDevices();
