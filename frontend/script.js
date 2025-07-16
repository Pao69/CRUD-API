// script.js

document.addEventListener('DOMContentLoaded', () => {
    loadCars();
    document.getElementById('carForm').addEventListener('submit', handleSubmit);
    document.getElementById('cancelBtn').addEventListener('click', resetForm);
});

const api = "http://localhost/Coding/CRUD/backend/";

function loadCars() {
    fetch(api)
        .then(response => response.json())
        .then(data => {
            const carTableBody = document.getElementById('carTableBody');
            carTableBody.innerHTML = '';

            data.forEach(car => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${car.make}</td>
                    <td>${car.model}</td>
                    <td>${car.year}</td>
                    <td>$${parseFloat(car.price).toLocaleString()}</td>
                    <td>${car.description}</td>
                    <td>
                        <button class="action-btn edit-btn" onclick="editCar(${car.id})">Edit</button>
                        <button class="action-btn delete-btn" onclick="deleteCar(${car.id})">Delete</button>
                    </td>
                `;
                carTableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error:', error));
}

async function handleSubmit(e) {
    e.preventDefault();

    const carId = document.getElementById('carId').value;
    const make = document.getElementById('make').value;
    const model = document.getElementById('model').value;
    const year = document.getElementById('year').value;
    const price = document.getElementById('price').value;
    const description = document.getElementById('description').value;

    const data = { make, model, year, price, description };

    const method = carId ? 'PUT' : 'POST';
    const url = carId ? `${api}/${carId}` : 'php/index.php';

    try {
        const response = await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        if (result.success) {
            resetForm();
            loadCars();
        } else {
            alert(result.message || 'An error occurred');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred');
    }
}

function editCar(id) {
    fetch(`${api}/${carId}`)
        .then(response => response.json())
        .then(car => {
            document.getElementById('carId').value = car.id;
            document.getElementById('make').value = car.make;
            document.getElementById('model').value = car.model;
            document.getElementById('year').value = car.year;
            document.getElementById('price').value = car.price;
            document.getElementById('description').value = car.description;
            document.getElementById('submitBtn').textContent = 'Update Car';
            document.getElementById('cancelBtn').style.display = 'inline-block';
        })
        .catch(error => console.error('Error:', error));
}

function deleteCar(id) {
    if (confirm('Are you sure you want to delete this car?')) {
        fetch(`${api}/${carId}}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadCars();
                } else {
                    alert(data.message || 'An error occurred');
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

function resetForm() {
    document.getElementById('carForm').reset();
    document.getElementById('carId').value = '';
    document.getElementById('submitBtn').textContent = 'Add Car';
    document.getElementById('cancelBtn').style.display = 'none';
}