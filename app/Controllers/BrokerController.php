<?php

namespace App\Controllers;
use App\Shortcodes\DateTable\Brokers as BrokerTable;
use App\Shortcodes\Tree\Brokers as BrokerTree;
use App\Models\Broker as ModelBrokers;
use Flight;

class BrokerController {

    public function index () { 
        
        // llamamos al modelo con los datos
        $data = ModelBrokers::getAll();
        
        // llamamos el shortcode de la tabla de brokers
        $shortcodeTable = BrokerTable::render($data);

        // // Llamamos el shorcode de el arbol
        $treeData = array_map(function ($row) {
            return [
                'key'    => $row['User ID'],
                'name'   => $row['User Name'],
                'parent' => $row['Referer']
            ];
        }, $data);
        // return "hola";
        $shortcodeTree = BrokerTree::render(['treeData' => $treeData ]);

        $html = '
            <div>' . $shortcodeTable . '</div> 
            <br> 
            <div>' . $shortcodeTree . '</div> 
        ';

        echo $html;
        // Flight::render('hello', ['users' => $data]);
    
    }

}