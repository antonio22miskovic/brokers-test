<?php

namespace App\Models;

use Flight;

class Broker
{   
    // Método para obtener los datos de la consulta
    public static function getAll()
    {
        // Consulta SQL
        $query = "
            SELECT 
                u.id AS 'User ID', 
                u.name AS 'User Name', 
                u.email AS 'User Email', 
                u.role AS 'Role',
                u.registration_date AS 'Registration Date',
                IFNULL(r.name, 'No Referer') AS 'Referer',
                t.purchase_volume AS 'Purchase Volume',
                t.client_volume AS 'Client Volume',
                t.broker_volume AS 'Broker Volume',
                bp.client_volume AS 'Broker Client Volume',
                bp.broker_volume AS 'Broker Broker Volume',
                bp.total_volume AS 'Broker Total Volume'
            FROM users u
            LEFT JOIN users r ON u.referer_id = r.id
            LEFT JOIN transactions t ON u.id = t.user_id
            LEFT JOIN broker_performance bp ON u.id = bp.broker_id
            ORDER BY u.registration_date DESC
        ";

        // Ejecutar la consulta
        $stmt = Flight::db()->runQuery($query);

        // Obtener los resultados
        $results = $stmt->fetchAll();

        // Devolver los resultados
        return $results;
    }

}
