<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <style>
        /* Add your styles here */
        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
        }

        th, td {
            border: 2px solid #3498db;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        button {
            padding: 8px;
            background-color: #f1c40f;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>
    <h2>Category Management</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Categories</th>
                <th>Quantite</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Sample row, replace with PHP loop generating rows -->
            <tr>
                <td>1</td>
                <td>Category 1</td>
                <td>10</td>
                <td>
                    <button onclick='updateQuantity(1, "min")'>Min</button>
                    <button onclick='updateQuantity(1, "max")'>Max</button>
                    <button onclick='removeCategory(1)'>Remove</button>
                </td>
            </tr>
            <!-- Repeat the above row structure for each category -->
        </tbody>
    </table>

    <script>
        function updateQuantity(categoryId, action) {
            // Implement your logic to update quantity (min or max) using AJAX or form submission
            alert(`Update quantity for category ID ${categoryId} - ${action}`);
        }

        function removeCategory(categoryId) {
            // Implement your logic to remove the category using AJAX or form submission
            alert(`Remove category ID ${categoryId}`);
        }
    </script>
</body>
</html>
