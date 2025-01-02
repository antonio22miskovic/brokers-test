<?php

namespace App\Models;

use Flight;

class Broker
{   
    // Método para obtener los datos de la consulta
    public static function getReferer($refererId)
    {
        // Consulta SQL
       
        $query = "
            SELECT 
                u.id AS 'id', 
                u.name AS 'name', 
                u.email AS 'email', 
                u.role AS 'role',
                u.registration_date AS 'created_at',
                IFNULL(r.name, 'No Referer') AS 'referer',
                t.purchase_volume AS 'purchase_volume',
                t.client_volume AS 'client_volume',
                t.broker_volume AS 'broker_volume',
                bp.client_volume AS 'broker_client_volume',
                bp.broker_volume AS 'broker_volume',
                bp.total_volume AS 'broker_total_volume'
            FROM users u
            LEFT JOIN users r ON u.referer_id = r.id
            LEFT JOIN transactions t ON u.id = t.user_id
            LEFT JOIN broker_performance bp ON u.id = bp.user_id
            WHERE u.referer_id = $refererId 
            ORDER BY u.registration_date DESC
        ";

        // Ejecutar la consulta
        $stmt = Flight::db()->runQuery($query);

        // Obtener los resultados
        $referidosDirectos = $stmt->fetchAll();

        foreach ($referidosDirectos as &$referido) {
            $referido['referidos'] = self::getReferer($referido['id']);
        }
    
        // Devolver los resultados
        return $referidosDirectos;
    }

}
