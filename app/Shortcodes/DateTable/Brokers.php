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

    private static function shortcode($params=[])
    {   
      
        // Definimos el shortcode
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

        $html .= '<div class="datatable-container">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
                <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
                <table id="dataTable" class="display">
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($params as $row) {
            $html .= '<tr class="parent-row">';
            $html .= '<td>' . htmlspecialchars($row['User Name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['User Email']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['Role']) . '</td>';
           
            // Formateamos la fecha al español
            $fecha = strftime("%d de %B de %Y", strtotime($row['Registration Date']));
            $html .= '<td>' . ucfirst($fecha) . '</td>';  // Convertimos la primera letra de la fecha a mayúscula

            // Traducir "Referer" a "Referido"
            $html .= '<td>' . htmlspecialchars($row['Referer']) . '</td>';

            // Formateamos los volúmenes en euros
            $html .= '<td>' . _formatCurrency($row['Purchase Volume']) . '</td>';
            $html .= '<td>' . _formatCurrency($row['Client Volume']) . '</td>';
            $html .= '<td>' . _formatCurrency($row['Broker Volume']) . '</td>';
            $html .= '<td>' . _formatCurrency($row['Broker Total Volume']) . '</td>';
            $html .= '<td><button class="btn-show" onclick="showReferidos(' . $row['User ID'] . ')"><i class="fas fa-users"></i> Mostrar Referidos</button></td>';
            $html .= '</tr>';

            // Fila oculta para los referidos
            $html .= '<tr class="hidden-row" id="referidos-' . $row['User ID'] . '">
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
                                        </tr>
                                    </thead>
                                    <tbody>';

            // Simulamos los referidos para este ejemplo
            $html .= '<tr>
                        <td>Referido de ' . htmlspecialchars($row['User Name']) . '</td>
                        <td>referido' . htmlspecialchars($row['User ID'] + 1) . '@example.com</td>
                        <td>Cliente</td>
                        <td>' . strftime("%d de %B de %Y") . '</td>
                        <td>' . htmlspecialchars($row['User Name']) . '</td>
                        <td>' . _formatCurrency(100) . '</td>
                        <td>' . _formatCurrency(50) . '</td>
                        <td>' . _formatCurrency(30) . '</td>
                        <td>' . _formatCurrency(200) . '</td>
                    </tr>';

            // Fila oculta para los referidos de los referidos
            $html .= '<tr class="hidden-row" id="referidos-referidos-' . $row['User ID'] . '">
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
                                        </tr>
                                    </thead>
                                    <tbody>';

            // Simulamos los referidos de los referidos para este ejemplo
            $html .= '<tr>
                        <td>Referido de Referido de ' . htmlspecialchars($row['User Name']) . '</td>
                        <td>referido-referido' . htmlspecialchars($row['User ID'] + 2) . '@example.com</td>
                        <td>Cliente</td>
                        <td>' . strftime("%d de %B de %Y") . '</td>
                        <td>' . htmlspecialchars($row['User Name']) . '</td>
                        <td>' . _formatCurrency(50) . '</td>
                        <td>' . _formatCurrency(25) . '</td>
                        <td>' . _formatCurrency(15) . '</td>
                        <td>' . _formatCurrency(105) . '</td>
                    </tr>';

            $html .= '</tbody></table></td></tr>';
            $html .= '</tbody></table></td></tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

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

                // Función para mostrar los referidos
                function showReferidos(userId) {
                    var referidosRow = $("#referidos-" + userId);
                    referidosRow.toggleClass("hidden-row"); // Alternar visibilidad de los referidos
                }

                // Función para mostrar los referidos de los referidos
                function showReferidosReferidos(userId) {
                    var referidosRow = $("#referidos-referidos-" + userId);
                    referidosRow.toggleClass("hidden-row"); // Alternar visibilidad de los referidos
                }
            </script>';

        return $html; // Retornamos el HTML generado
        
    }

}
