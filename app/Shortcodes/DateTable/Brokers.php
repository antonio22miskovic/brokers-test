<?php

namespace App\Shortcodes\DateTable;

use Flight;

class Brokers
{   
    public static function render ($params=[])
    {   
        // llamamos el shartcode
        return self::shortcode($params);
    }

    private static function generarTablaReferidos($params)
    {
        $html = '';

        $count = 1;
        foreach ($params as $row) {
            $html .= '<tr class="parent-row">';
            $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['role']) . '</td>';
        
            // Formateamos la fecha al español
            $fecha = strftime("%d de %B de %Y", strtotime($row['created_at']));
            $html .= '<td>' . ucfirst($fecha) . '</td>'; // Convertimos la primera letra de la fecha a mayúscula
        
            // Traducir "Referer" a "Referido"
            $html .= '<td>' . htmlspecialchars($row['referer']) . '</td>';
        
            // Formateamos los volúmenes en euros
            $html .= '<td>' . _formatCurrency($row['purchase_volume']) . '</td>';
            $html .= '<td>' . _formatCurrency($row['client_volume']) . '</td>';
            $html .= '<td>' . _formatCurrency($row['broker_volume']) . '</td>';
            $html .= '<td>' . _formatCurrency($row['broker_total_volume']) . '</td>';
        
            // Verificar si el usuario tiene referidos
            if (!empty($row['referidos'])) {
                // Mostrar botón para referidos si tiene
                $html .= '<td><button class="btn-show" onclick="showReferidos(' . $count . ')">
                            <i class="fas fa-users"></i> Mostrar Referidos
                          </button></td>';
            } else {
                // Mostrar un ícono indicando que no tiene referidos
                $html .= '<td>
                            <span class="no-referidos" title="No tiene referidos">
                                <i class="fas fa-user-slash" style="color: #ccc;"></i>
                            </span>
                          </td>';
            }
        
            $html .= '</tr>';
        
            // Si tiene referidos, generar filas ocultas para mostrarlos
            if (!empty($row['referidos'])) {
                $html .= '<tr class="hidden-row" id="referidos-' . $count . '">
                            <td colspan="10">
                                <div class="nested-table">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>Role</th>
                                                <th>Fecha de Registro</th>
                                                <th>Referido</th>
                                                <th>Purchase Volume</th>
                                                <th>Client Volume</th>
                                                <th>Broker Volume</th>
                                                <th>Broker Total Volume</th>
                                                <th>Actiones</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                
                $countRef = 101;
                foreach ($row['referidos'] as $referido) {
                    // Verificar si el referido tiene más referidos
                    $hasReferidos = isset($referido['referidos']) && count($referido['referidos']) > 0;
                
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($referido['name']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($referido['email']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($referido['role']) . '</td>';
                    $html .= '<td>' . ucfirst(strftime("%d de %B de %Y", strtotime($referido['created_at']))) . '</td>';
                    $html .= '<td>' . htmlspecialchars($referido['referer']) . '</td>';
                    $html .= '<td>' . _formatCurrency($referido['purchase_volume']) . '</td>';
                    $html .= '<td>' . _formatCurrency($referido['client_volume']) . '</td>';
                    $html .= '<td>' . _formatCurrency($referido['broker_volume']) . '</td>';
                    $html .= '<td>' . _formatCurrency($referido['broker_total_volume']) . '</td>';
                
                    // Verificar si tiene más referidos
                    if ($hasReferidos) {
                        // Si tiene referidos, agregar el botón para verlos
                        $html .= '<td><button class="btn-show" onclick="showReferidos(' . $countRef . ')"><i class="fas fa-users"></i> Mostrar Referidos</button></td>';
                    } else {
                        // Si no tiene referidos, mostrar el mensaje de que no tiene
                        $html .= '<td>
                            <span class="no-referidos" title="No tiene referidos">
                                <i class="fas fa-user-slash" style="color: #ccc;"></i>
                            </span>
                          </td>';
                    }
                
                    $html .= '</tr>';
                
                    // Aquí se podría agregar la fila oculta para los referidos si el referido tiene referidos
                    if ($hasReferidos) {
                        // Aquí puedes agregar el código que muestra los referidos del referido
                        $html .= '<tr class="hidden-row" id="referidos-' . $countRef . '">
                                    <td colspan="10">
                                        <!-- Aquí puedes agregar el contenido de los referidos del referido -->
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>User Name</th>
                                                    <th>User Email</th>
                                                    <th>Role</th>
                                                    <th>Fecha de Registro</th>
                                                    <th>Referido</th>
                                                    <th>Purchase Volume</th>
                                                    <th>Client Volume</th>
                                                    <th>Broker Volume</th>
                                                    <th>Broker Total Volume</th>
                                                    <th>Actiones</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                        
                        // Iterar sobre los referidos del referido
                        foreach ($referido['referidos'] as $subReferido) {
                            $hasReferidosSud = isset($referido['referidos']) && count($referido['referidos']) > 0;
                            $html .= '<tr>';
                            $html .= '<td>' . htmlspecialchars($subReferido['name']) . '</td>';
                            $html .= '<td>' . htmlspecialchars($subReferido['email']) . '</td>';
                            $html .= '<td>' . htmlspecialchars($subReferido['role']) . '</td>';
                            $html .= '<td>' . ucfirst(strftime("%d de %B de %Y", strtotime($subReferido['created_at']))) . '</td>';
                            $html .= '<td>' . htmlspecialchars($subReferido['referer']) . '</td>';
                            $html .= '<td>' . _formatCurrency($subReferido['purchase_volume']) . '</td>';
                            $html .= '<td>' . _formatCurrency($subReferido['client_volume']) . '</td>';
                            $html .= '<td>' . _formatCurrency($subReferido['broker_volume']) . '</td>';
                            $html .= '<td>' . _formatCurrency($subReferido['broker_total_volume']) . '</td>';
                        
                            if ($hasReferidosSud) {
                                // Si tiene referidos, agregar el botón para verlos
                                $html .= '<td><button class="btn-show" onclick="showReferidos(' . $countRef . ')"><i class="fas fa-users"></i> Mostrar Referidos</button></td>';
                            } else {
                                // Si no tiene referidos, mostrar el mensaje de que no tiene
                                $html .= '<td>
                                    <span class="no-referidos" title="No tiene referidos">
                                        <i class="fas fa-user-slash" style="color: #ccc;"></i>
                                    </span>
                                  </td>';
                            }
                        
                            $html .= '</tr>';
                        }
                        
                        $html .= '</tbody></table></td></tr>';
                    }
                    $countRef++;
                }
                                        
        
                $html .= '</tbody></table></div></td></tr>';
            }
            $count++;
        }        
        return $html;
    }

    public static function shortcode($params = [])
    {
        $html = '';
    
        // Estilos mejorados
        $html .= '<style>
            .datatable-container {
                width: 90%;         
                max-width: 1200px;   
                margin: 0 auto;      
                padding: 20px;
                box-sizing: border-box;
            }
    
            table {
                width: 100%;         
                border-collapse: collapse;
                margin-bottom: 20px;
            }
    
            table th, table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
    
            table th {
                background-color: #f4f4f4;
            }
    
            .dataTables_wrapper {
                width: 100%;
                overflow-x: auto;    
            }
    
            .hidden-row {
                display: none;
            }
    
            .btn-show {
                cursor: pointer;
                color: #007bff;
                border: none;
                background-color: transparent;
                text-decoration: underline;
                font-size: 16px;
            }
    
            .btn-show i {
                margin-right: 5px;
            }
    
            .nested-table {
                background-color: #f9f9f9;
                margin-top: 15px;
                padding: 10px;
            }
    
            .nested-table th, .nested-table td {
                border: 1px solid #ccc;
            }
    
            .btn-toggle-referidos {
                color: #28a745;
                cursor: pointer;
                font-weight: bold;
            }
    
            .btn-toggle-referidos i {
                margin-right: 5px;
            }
    
            .referidos-toggle {
                display: none;
                margin-top: 10px;
                background-color: #f9f9f9;
                padding: 10px;
                border-radius: 5px;
            }
        </style>';
    
        // Contenedor principal
        $html .= '<div class="datatable-container">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
                <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
                <table id="dataTable" class="display">';
    
        // Cabecera de la tabla
        $html .= '<thead>
                    <tr>
                        <th> Name</th>
                        <th> Email</th>
                        <th>Role</th>
                        <th>Fecha de Registro</th>
                        <th>Referido</th>
                        <th>Purchase Volume</th>
                        <th>Client Volume</th>
                        <th>Broker Volume</th>
                        <th>Broker Total Volume</th>
                        <th>Actiones</th>
                    </tr>
                  </thead>';
    
        // Generar contenido dinámico
        $html .= '<tbody>';
        $html .= self::generarTablaReferidos($params); // Usa la función para generar contenido recursivo
        $html .= '</tbody>';
    
        // Cierre de la tabla
        $html .= '</table>';
    
        // Scripts para DataTables y funcionalidad
        $html .= '<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>';
        $html .= '<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>';
        $html .= '<script>
                    $(document).ready(function() {
                        $("#dataTable").DataTable({
                            "paging": true,           
                            "searching": true,        
                            "ordering": true,         
                            "lengthChange": false,    
                            "pageLength": 10,         
                            "language": {
                                "lengthMenu": "Mostrar _MENU_ registros por página",
                                "zeroRecords": "No se encontraron resultados",
                                "info": "Mostrando página _PAGE_ de _PAGES_",
                                "infoEmpty": "No hay registros disponibles",
                                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                                "search": "Buscar:"
                            }
                        });
                    });
    
                    function showReferidos(userId) {
                        var referidosRow = $("#referidos-" + userId);
                        referidosRow.toggleClass("hidden-row");
                    }

                    $(document).on("click", ".btn-show", function() {
                        var userId = $(this).data("user-id");
                        var referidosRow = $("#referidos-" + userId);
                        referidosRow.toggleClass("hidden-row");
                    });
                  </script>';
    
        // Cierre del contenedor
        $html .= '</div>';
    
        return $html;
    }
    



    // private static function shortcode($params=[])
    // {   
      
    //     // Definimos el shortcode
    //     $html = '';

    //     // Estilos mejorados
    //     $html .= '<style>
    //         .datatable-container {
    //             width: 90%;         
    //             max-width: 1200px;   
    //             margin: 0 auto;      
    //             padding: 20px;
    //             box-sizing: border-box;
    //         }

    //         table {
    //             width: 100%;         
    //             border-collapse: collapse;
    //             margin-bottom: 20px;
    //         }

    //         table th, table td {
    //             border: 1px solid #ddd;
    //             padding: 8px;
    //             text-align: left;
    //         }

    //         table th {
    //             background-color: #f4f4f4;
    //         }

    //         .dataTables_wrapper {
    //             width: 100%;
    //             overflow-x: auto;    
    //         }

    //         .hidden-row {
    //             display: none;
    //         }

    //         .btn-show {
    //             cursor: pointer;
    //             color: #007bff;
    //             border: none;
    //             background-color: transparent;
    //             text-decoration: underline;
    //             font-size: 16px;
    //         }

    //         .btn-show i {
    //             margin-right: 5px;
    //         }

    //         .nested-table {
    //             background-color: #f9f9f9;
    //             margin-top: 15px;
    //             padding: 10px;
    //         }

    //         .nested-table th, .nested-table td {
    //             border: 1px solid #ccc;
    //         }

    //         .btn-toggle-referidos {
    //             color: #28a745;
    //             cursor: pointer;
    //             font-weight: bold;
    //         }

    //         .btn-toggle-referidos i {
    //             margin-right: 5px;
    //         }

    //         .referidos-toggle {
    //             display: none;
    //             margin-top: 10px;
    //             background-color: #f9f9f9;
    //             padding: 10px;
    //             border-radius: 5px;
    //         }
    //     </style>';

    //     $html .= '<div class="datatable-container">
    //             <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    //             <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    //             <table id="dataTable" class="display">
    //                 <thead>
    //                     <tr>
    //                         <th>User Name</th>
    //                         <th>User Email</th>
    //                         <th>Role</th>
    //                         <th>Fecha de Registro</th>
    //                         <th>Referido</th>
    //                         <th>Purchase Volume</th>
    //                         <th>Client Volume</th>
    //                         <th>Broker Volume</th>
    //                         <th>Broker Total Volume</th>
    //                         <th>Actions</th>
    //                     </tr>
    //                 </thead>
    //                 <tbody>';

    //     foreach ($params as $row) {
    //         $html .= '<tr class="parent-row">';
    //         $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
    //         $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
    //         $html .= '<td>' . htmlspecialchars($row['role']) . '</td>';
           
    //         // Formateamos la fecha al español
    //         $fecha = strftime("%d de %B de %Y", strtotime($row['created_at']));
    //         $html .= '<td>' . ucfirst($fecha) . '</td>';  // Convertimos la primera letra de la fecha a mayúscula

    //         // Traducir "Referer" a "Referido"
    //         $html .= '<td>' . htmlspecialchars($row['referer']) . '</td>';

    //         // Formateamos los volúmenes en euros
    //         $html .= '<td>' . _formatCurrency($row['purchase_volume']) . '</td>';
    //         $html .= '<td>' . _formatCurrency($row['client_volume']) . '</td>';
    //         $html .= '<td>' . _formatCurrency($row['broker_volume']) . '</td>';
    //         $html .= '<td>' . _formatCurrency($row['broker_total_volume']) . '</td>';
    //         $html .= '<td><button class="btn-show" onclick="showReferidos(' . $row['id'] . ')"><i class="fas fa-users"></i> Mostrar Referidos</button></td>';
    //         $html .= '</tr>';

    //         // Fila oculta para los referidos
    //         $html .= '<tr class="hidden-row" id="referidos-' . $row['id'] . '">
    //                     <td colspan="10">
    //                         <div class="nested-table">
    //                             <table class="table table-bordered">
    //                                 <thead>
    //                                     <tr>
    //                                         <th>User Name</th>
    //                                         <th>User Email</th>
    //                                         <th>Role</th>
    //                                         <th>Fecha de Registro</th>
    //                                         <th>Referido</th>
    //                                         <th>Purchase Volume</th>
    //                                         <th>Client Volume</th>
    //                                         <th>Broker Volume</th>
    //                                         <th>Broker Total Volume</th>
    //                                     </tr>
    //                                 </thead>
    //                                 <tbody>';

    //         // Simulamos los referidos para este ejemplo
    //         $html .= '<tr>
    //                     <td>Referido de ' . htmlspecialchars($row['name']) . '</td>
    //                     <td>referido' . htmlspecialchars($row['id'] + 1) . '@example.com</td>
    //                     <td>Cliente</td>
    //                     <td>' . strftime("%d de %B de %Y") . '</td>
    //                     <td>' . htmlspecialchars($row['name']) . '</td>
    //                     <td>' . _formatCurrency(100) . '</td>
    //                     <td>' . _formatCurrency(50) . '</td>
    //                     <td>' . _formatCurrency(30) . '</td>
    //                     <td>' . _formatCurrency(200) . '</td>
    //                 </tr>';

    //         // Fila oculta para los referidos de los referidos
    //         $html .= '<tr class="hidden-row" id="referidos-referidos-' . $row['id'] . '">
    //                     <td colspan="10">
    //                         <div class="nested-table">
    //                             <table class="table table-bordered">
    //                                 <thead>
    //                                     <tr>
    //                                         <th>User Name</th>
    //                                         <th>User Email</th>
    //                                         <th>Role</th>
    //                                         <th>Fecha de Registro</th>
    //                                         <th>Referido</th>
    //                                         <th>Purchase Volume</th>
    //                                         <th>Client Volume</th>
    //                                         <th>Broker Volume</th>
    //                                         <th>Broker Total Volume</th>
    //                                     </tr>
    //                                 </thead>
    //                                 <tbody>';

    //         // Simulamos los referidos de los referidos para este ejemplo
    //         $html .= '<tr>
    //                     <td>Referido de Referido de ' . htmlspecialchars($row['name']) . '</td>
    //                     <td>referido-referido' . htmlspecialchars($row['id'] + 2) . '@example.com</td>
    //                     <td>Cliente</td>
    //                     <td>' . strftime("%d de %B de %Y") . '</td>
    //                     <td>' . htmlspecialchars($row['name']) . '</td>
    //                     <td>' . _formatCurrency(50) . '</td>
    //                     <td>' . _formatCurrency(25) . '</td>
    //                     <td>' . _formatCurrency(15) . '</td>
    //                     <td>' . _formatCurrency(105) . '</td>
    //                 </tr>';

    //         $html .= '</tbody></table></td></tr>';
    //         $html .= '</tbody></table></td></tr>';
    //     }

    //     $html .= '</tbody>';
    //     $html .= '</table>';

    //     $html .= '<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>';
    //     $html .= '<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>';
    //     $html .= '<script>
    //             $(document).ready(function() {
    //                 $("#dataTable").DataTable({
    //                     "paging": true,           
    //                     "searching": true,        
    //                     "ordering": true,         
    //                     "lengthChange": false,    
    //                     "pageLength": 10,         
    //                     "language": {
    //                         "lengthMenu": "Mostrar _MENU_ registros por página",
    //                         "zeroRecords": "No se encontraron resultados",
    //                         "info": "Mostrando página _PAGE_ de _PAGES_",
    //                         "infoEmpty": "No hay registros disponibles",
    //                         "infoFiltered": "(filtrado de _MAX_ registros totales)",
    //                         "search": "Buscar:"
    //                     }
    //                 });
    //             });

    //             // Función para mostrar los referidos
    //             function showReferidos(userId) {
    //                 var referidosRow = $("#referidos-" + userId);
    //                 referidosRow.toggleClass("hidden-row"); // Alternar visibilidad de los referidos
    //             }

    //             // Función para mostrar los referidos de los referidos
    //             function showReferidosReferidos(userId) {
    //                 var referidosRow = $("#referidos-referidos-" + userId);
    //                 referidosRow.toggleClass("hidden-row"); // Alternar visibilidad de los referidos
    //             }
    //         </script>';

    //     return $html; // Retornamos el HTML generado
        
    // }

}
