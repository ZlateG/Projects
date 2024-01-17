<?php

    //source: https://www.youtube.com/watch?v=z3pZdmJ64jo&list=PL0eyrZgxdwhypQiZnYXM7z7-OTkcMgGPh&index=9

    spl_autoload_register('myAutoLoader');
    function myAutoLoader($className) {
        $classPath = "../resourses/classes/";
        $interfacePath = 'interfaces/';
        $extensionClass = ".php";
        $extensionInterface = ".php";
        $classFile = $classPath . $className . $extensionClass;
        $interfaceFile = $interfacePath . $className . $extensionInterface;
        if (file_exists($classFile)) {
            include_once $classFile;
        } elseif (file_exists($interfaceFile)) {
            include_once $interfaceFile;
        }
    }

?>