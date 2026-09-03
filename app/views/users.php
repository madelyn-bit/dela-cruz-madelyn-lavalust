<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>


<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #000;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>
```

</head>

<body>

<h1>Welcome to Users View</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>FIRST NAME</th>
            <th>LAST NAME</th>
            <th>EMAIL</th>
            <th>USERNAME</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['First_Name'] ?></td>
                <td><?= $user['Last_Name'] ?></td>
                <td><?= $user['Email'] ?></td>
                <td><?= $user['Username'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


</body>
</html>
