<?php

namespace App\Controllers;
use App\Shortcodes\DateTable\Brokers as BrokerTable;
use App\Shortcodes\Tree\Brokers as BrokerTree;
use App\Models\Broker as ModelBrokers;
use Flight;

class BrokerController {

    public function index () { 
        
        // llamamos al modelo con los datos
        $data = ModelBrokers::getReferer(1);
        
        // llamamos el shortcode de la tabla de brokers
        $shortcodeTable = BrokerTable::render($data);

        $shortcodeTree = BrokerTree::render($data);

        $html = '
            <div>' . $shortcodeTable . '</div> 
            <br> 
            <div>' . $shortcodeTree . '</div> 
        ';

        echo $html;
        // Flight::render('hello', ['users' => $data]);
    
    }

}