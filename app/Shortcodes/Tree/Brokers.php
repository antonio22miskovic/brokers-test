<?php

namespace App\Shortcodes\Tree;

use App\Helpers\Shortcode\ShortcodeHelper;

class Brokers
{
    public static function render($params=[])
    {
        $data = [
            ['id' => 1, 'name' => 'Yo'],
            ['id' => 2, 'pid' => 1, 'name' => 'Broker 1'],
            ['id' => 3, 'pid' => 1, 'name' => 'Broker 2'],
            ['id' => 4, 'pid' => 2, 'name' => 'Subbroker 1'],
            ['id' => 5, 'pid' => 2, 'name' => 'Subbroker 2'],
        ];

        $treeId = $params['id'] ?? 'tree-brokers-' . uniqid();

        return "
            <div id=\"$treeId\" style=\"width: 100%; height: 500px;\"></div>
            <script src=\"https://cdnjs.cloudflare.com/ajax/libs/gojs/2.4.4/go-debug.js\"></script>
            <script>
                const \$ = go.GraphObject.make;

                const myDiagram = \$.Diagram(document.getElementById('$treeId'), {
                    initialContentAlignment: go.Spot.Center,
                    layout: \$.TreeLayout({ angle: 90, layerSpacing: 35 }),
                    'undoManager.isEnabled': true
                });

                myDiagram.nodeTemplate = \$.Node('Auto',
                    \$.Shape('RoundedRectangle', { strokeWidth: 0 }, new go.Binding('fill', 'color')),
                    \$.TextBlock({ margin: 8, editable: true }, new go.Binding('text', 'name'))
                );

                myDiagram.model = new go.TreeModel(" . json_encode($data) . ");
            </script>
        ";
    }
}
