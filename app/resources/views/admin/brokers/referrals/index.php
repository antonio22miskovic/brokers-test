<!-- resources/views/admin/brokers/referrals/index.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referidos de Broker</title>

    <!-- Cargar CSS de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Cargar jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Cargar librería DataTables -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Tabla de Referidos y Volúmenes</h2>
        
        <!-- Tabla de DataTables -->
        <table id="referidosTable" class="display">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>Role</th>
                    <th>Registration Date</th>
                    <th>Referer</th>
                    <th>Purchase Volume</th>
                    <th>Client Volume</th>
                    <th>Broker Volume</th>
                    <th>Broker Client Volume</th>
                    <th>Broker Broker Volume</th>
                    <th>Broker Total Volume</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['User ID']; ?></td>
                        <td><?php echo $user['User Name']; ?></td>
                        <td><?php echo $user['User Email']; ?></td>
                        <td><?php echo $user['Role']; ?></td>
                        <td><?php echo $user['Registration Date']; ?></td>
                        <td><?php echo $user['Referer']; ?></td>
                        <td><?php echo $user['Purchase Volume']; ?></td>
                        <td><?php echo $user['Client Volume']; ?></td>
                        <td><?php echo $user['Broker Volume']; ?></td>
                        <td><?php echo $user['Broker Client Volume']; ?></td>
                        <td><?php echo $user['Broker Broker Volume']; ?></td>
                        <td><?php echo $user['Broker Total Volume']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // Inicializar DataTables
            $('#referidosTable').DataTable();
        });
    </script>
</body>
</html>
