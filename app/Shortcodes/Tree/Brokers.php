<?php

namespace App\Shortcodes\Tree;
use Flight;

class Brokers
{   
    // llamamos el shartcode
    public static function render ($params=[])
    {   
        // llamamos el shartcode
        return self::shortcode($params);
    }
 
    // public static function shortcode($params=[])
    // {   
    //     // var_dump(json_encode($params['treeData']));
    //     $treeData = json_encode($params['treeData']);
    
        
    //     $html = '<script src="https://cdn.jsdelivr.net/npm/gojs/release/go-debug.js"></script>';
    //     $html .= '<style>
    //         #myDiagramDiv {
    //             width: 100%; 
    //             height: 600px; 
    //             border: 1px solid black;
    //             margin: 0 auto; /* Centra el contenedor horizontalmente */
    //             background-color: #f9f9f9; /* Fondo claro */
    //         }
    //     </style>';

    //     $html .= '<script>
    //       const myDiagram = new go.Diagram("myDiagramDiv",
    //     {
    //         "undoManager.isEnabled": true,
    //         layout: new go.TreeLayout({ angle: 90, layerSpacing: 35 })
    //     });

    //     myDiagram.nodeTemplate =
    //     new go.Node("Horizontal",
    //         { background: "#44CCFF" })
    //         .add(
    //         new go.Picture({ margin: 10, width: 50, height: 50, background: "red" })
    //             .bind("source"),
    //         new go.TextBlock("Default Text",
    //             { margin: 12, stroke: "white", font: "bold 16px sans-serif" })
    //             .bind("text", "name")
    //         );

    //     // define a Link template that routes orthogonally, with no arrowhead
    //     myDiagram.linkTemplate =
    //     new go.Link(
    //         // default routing is go.Routing.Normal
    //         // default corner is 0
    //         { routing: go.Routing.Orthogonal, corner: 5 })
    //         .add(
    //         // the link path, a Shape
    //         new go.Shape({ strokeWidth: 3, stroke: "#555" }),
    //         // if we wanted an arrowhead we would also add another Shape with toArrow defined:
    //         //new go.Shape({  toArrow: "Standard", stroke: null  })
    //         );

    //         myDiagram.model = new go.TreeModel(' . $treeData . ');
    //     </script>';
    //     $html .= '<div id="myDiagramDiv"></div>';       
    //     return $html;
    
    // }

    public static function shortcode($params=[])
    {

        $formattedData = self::formatData($params, null);

        // Convertimos los nodos y enlaces a JSON
        $nodeDataArrayJson = json_encode($formattedData['nodes']);
        $linkDataArrayJson = json_encode($formattedData['links']);

    
        $html = '<script src="https://cdn.jsdelivr.net/npm/gojs/release/go-debug.js"></script>';
        $html .= '<style>
            #myDiagramDiv {
                width: 100%; 
                height: 600px; 
                border: 1px solid black;
                margin: 0 auto; /* Centra el contenedor horizontalmente */
                background-color: #f9f9f9; /* Fondo claro */
            }
        </style>';

        $html .= '
        <script>
            function init() {
                var $ = go.GraphObject.make;
                myDiagram = $(go.Diagram, "myDiagramDiv");
                var nodeDataArray = [
                    {key: "Alpha"},
                    {key: "Beta"}
                ];
                var linkDataArray = [
                    { to: "Beta", from: "Alpha"}
                ];
                
                var nodeDataArray = ' . $nodeDataArrayJson . ';
                var linkDataArray = ' . $linkDataArrayJson . ';


                myDiagram.model = new go.GraphLinksModel(nodeDataArray, linkDataArray);

               myDiagram.nodeTemplate = $(go.Node, "Auto",
                $(go.Shape, "RoundedRectangle", { fill: "white" }),
                $(go.TextBlock, { margin: 5 }, new go.Binding("text", "key"))
                );
            }
            // Corrected line to ensure the function runs on page load
            window.onload = init;
        </script>';

         $html .= ' <div id="myDiagramDiv"></div> ';

        return $html;

    }

     // Función recursiva para formatear los datos en nodos y enlaces
    public static function formatData($referidos, $parentName = null)
    {
        $nodes = [];
        $links = [];

        foreach ($referidos as $referido) {
            // Crear nodo para el referido
            $node = [
                'key' => $referido['name'],
                'parent' => $parentName,  // Establecer el nombre del referente
            ];

            $nodes[] = $node;

            // Si el referido tiene referidos (es decir, nodos hijos)
            if (!empty($referido['referidos'])) {
                // Agregar enlaces de este nodo hacia sus referidos
                foreach ($referido['referidos'] as $subReferido) {
                    $links[] = [
                        'from' => $referido['name'],  // El nombre del referente
                        'to' => $subReferido['name'], // El nombre del subreferido
                    ];
                }

                // Llamada recursiva para procesar los referidos del referido
                $result = self::formatData($referido['referidos'], $referido['name']);
                $nodes = array_merge($nodes, $result['nodes']);
                $links = array_merge($links, $result['links']);
            }
        }

        return ['nodes' => $nodes, 'links' => $links];
    }


}
