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
 
    public static function shortcode($params=[])
    {   
        // var_dump(json_encode($params['treeData']));
        $treeData = json_encode($params['treeData']);
       
        $html = '<div id="myDiagramDiv"></div>';
        
        $html .= '<script src="https://unpkg.com/gojs/release/go.js"></script>"></script>';
        $html .= '<style>
            #myDiagramDiv {
                width: 100%; 
                height: 600px; 
                border: 1px solid black;
                margin: 0 auto; /* Centra el contenedor horizontalmente */
                background-color: #f9f9f9; /* Fondo claro */
            }
        </style>';

        $html .= '<script>
          const myDiagram = new go.Diagram("myDiagramDiv",
        {
            "undoManager.isEnabled": true,
            layout: new go.TreeLayout({ angle: 90, layerSpacing: 35 })
        });

        myDiagram.nodeTemplate =
        new go.Node("Horizontal",
            { background: "#44CCFF" })
            .add(
            new go.Picture({ margin: 10, width: 50, height: 50, background: "red" })
                .bind("source"),
            new go.TextBlock("Default Text",
                { margin: 12, stroke: "white", font: "bold 16px sans-serif" })
                .bind("text", "name")
            );

        // define a Link template that routes orthogonally, with no arrowhead
        myDiagram.linkTemplate =
        new go.Link(
            // default routing is go.Routing.Normal
            // default corner is 0
            { routing: go.Routing.Orthogonal, corner: 5 })
            .add(
            // the link path, a Shape
            new go.Shape({ strokeWidth: 3, stroke: "#555" }),
            // if we wanted an arrowhead we would also add another Shape with toArrow defined:
            //new go.Shape({  toArrow: "Standard", stroke: null  })
            );

            myDiagram.model = new go.TreeModel(' . $treeData . ');
        </script>';

        return $html;
    
    }
}
