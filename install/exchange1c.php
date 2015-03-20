<?php
return [
    'module'    => [
        'class' => 'application.modules.exchange1c.Exchange1cModule',
    ],
    'import'    => [],
    'component' => [],
    'rules'     => [
        '/exchange/index'=>'exchange1c/default/index',
        '/exchange/test-read/<size:\d+>'=>'exchange1c/default/testRead',
        '/exchange/<action:\w+>'=>'exchange1c/default/<action>',
    ],
];

?>