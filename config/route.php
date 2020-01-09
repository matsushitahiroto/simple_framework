<?php

return [
    '/' => [
        'GET'  => ['Controller', 'welcomeView']
    ],
    '/example' => [
        'GET'  => ['ExampleController', 'exampleView'],
        'POST' => ['ExampleController', 'post']
    ],
    '/reset' => [
        'POST' => ['ExampleController', 'delete']
    ]
];
