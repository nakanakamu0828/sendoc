<?php

return [

    /**
     * Namespaces are being prefixed with the applications base namespace.
     */
    'namespaces' => [
        'contracts'    => 'Repositories\Interfaces',
        'repositories' => 'Repositories',
    ],

    /**
     * Paths will be used with the `app()->basePath().'/app/'` function to reach app directory.
     */
    'paths' => [
        'contracts'    => 'Repositories/Interfaces/',
        'repositories' => 'Repositories/',
    ],

];
