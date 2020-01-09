<?php
spl_autoload_register(function($class) {
    if(strpos($class, PREFIX) === 0) {
        $className = substr($class, strlen(PREFIX));
        $classFilePath = APP_PATH . str_replace('\\', '/', $className) . '.php';
        if(file_exists($classFilePath)) {
            require $classFilePath;
        }
    }
});
// spl_autoload_register(function($class) {
//     if(strpos($class, PREFIX) === 0) {
//         $path = substr($class, strlen(PREFIX));
//         $bundle = explode('\\', $path);
//         $className = implode('\Controller\\', $bundle);
//         $classFilePath = './app/' . str_replace('\\', '/', $className) . '.php';
//         if(file_exists($classFilePath)) {
//             require $classFilePath;
//         }
//     }
// });
