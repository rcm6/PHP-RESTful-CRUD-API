<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD API INTERFACE</title>
</head>
<body>
    <h1>CRUD API INTERFACE</h1>

    <!-- Read Section -->
    <h2>Read Items</h2>
    <!--button id="loadItemsButton">Load Items</button-->

    <div id="readItems"></div>

    <!-- Create Section -->
    <h2>Create Items</h2>
        <form id="createForm">
            <input type="text" id="createName" placeholder="Name" required>
            <input type="text" id="createDescription" placeholder="Description" required>
            <button type="submit">Create</button>
        </form>
    <div id="createMessage" class="message"></div>
    <!-- Update Section -->
    <h2>Update Items</h2>
    <!-- Delete Section -->
    <h2>Delete Items</h2>

    <script>
        // Create Item
        document.getElementById('createForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const name = document.getElementById('createName').value;
            const description = document.getElementById('createDescription').value;

            fetch('/api/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ name, description }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('createMessage').textContent = data.message;
                    document.getElementById('createMessage').classList.add('success');
                    // Clear the form
                    document.getElementById('createName').value = '';
                    document.getElementById('createDescription').value = '';
                    // Reload items
                    loadItems(); // call loadItems function
                } else {
                    document.getElementById('createMessage').textContent = 'An error occurred.';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('createMessage').textContent = 'An error occurred.';
            });
        });

        // Load Items
        function loadItems() {
            fetch('/api/read')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const items = data.data;
                    const table = document.createElement('table');
                    table.innerHTML = `
                        <thead>
                            <tr>
                                <th style="width: 50px;">ID</th>
                                <th style="width: 150px;">Name</th>
                                <th style="width: 250px;">Description</th>
                                <th style="width: 150px;">Created At</th>
                                <th style="width: 150px;">Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    `;

                    const tbody = table.querySelector('tbody');
                    items.forEach(item => {
                        const createdAt = new Date(item.created_at);
                        const updatedAt = new Date(item.updated_at);

                        // Format date as "DD/MM/YYYY"
                        const createdAtFormatted = `${createdAt.getDate().toString().padStart(2, '0')}/${(createdAt.getMonth() + 1).toString().padStart(2, '0')}/${createdAt.getFullYear()}`;
                        const updatedAtFormatted = `${updatedAt.getDate().toString().padStart(2, '0')}/${(updatedAt.getMonth() + 1).toString().padStart(2, '0')}/${updatedAt.getFullYear()}`;

                        // Format time as "HH:MM"
                        const createdAtTimeFormatted = `${createdAt.getHours().toString().padStart(2, '0')}:${createdAt.getMinutes().toString().padStart(2, '0')}`;
                        const updatedAtTimeFormatted = `${updatedAt.getHours().toString().padStart(2, '0')}:${updatedAt.getMinutes().toString().padStart(2, '0')}`;

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td style="width: 50px;">${item.id}</td>
                            <td style="width: 150px;">${item.name}</td>
                            <td style="width: 250px;">${item.description}</td>
                            <td style="width: 150px;">${createdAtFormatted} ${createdAtTimeFormatted}</td>
                            <td style="width: 150px;">${updatedAtFormatted} ${updatedAtTimeFormatted}</td>
                        `;
                        tbody.appendChild(row);
                    });

                    document.getElementById('readItems').innerHTML = '';
                    document.getElementById('readItems').appendChild(table);
                } else {
                    document.getElementById('readItems').textContent = 'An error occurred.';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('readItems').textContent = 'An error occurred.';
            });
        }

        /*
        // Load items when the "Load Items" button is clicked
        document.getElementById('loadItemsButton').addEventListener('click', function () {
            loadItems();
        });
        */

        // Load items on page load
        loadItems();
    </script>

    
</body>
</html>