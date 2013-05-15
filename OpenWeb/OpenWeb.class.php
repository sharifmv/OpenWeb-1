<?php

/**
 * --------------------------------------
 * The OpenWeb Template Engine
 * --------------------------------------
 * Written by Liam Demafelix
 * Copyright (c) 2013
 * Licensed under the MIT license (FOSS)
 * Version 0.1
 * --------------------------------------
 */

if(!defined('LINK')) {
    die();
}

class OpenWeb {

    private static $__ow_Instance;
    private $syntax = "ow";

    private function __construct() {
        // Reserved
    }

    public static function Invoke() {
        if(!self::$__ow_Instance) {
            self::$__ow_Instance = new OpenWeb();
        }
        return self::$__ow_Instance;
    }

    public function start($file, $assign = "") {
        // Read if the file exists
        $template = LINK . "templates/" . $file . ".tpl";
        if( (!is_file($template)) || (filesize($template) == 0) ) {
            throw new Exception("Template file is missing or empty");
            exit();
        }
        $data = $this->read($template);

        // Process everything
        $data = $this->process($data, $assign);

        // Return
        return $data;
    }

    protected function read($file) {
        $fp = fopen($file, "r");
        $out = fread($fp, filesize($file));
        fclose($fp);
        return $out;
    }

    protected function process($data, $assign) {
        // Part 1: Template Inclusions
        preg_match_all('/\<'.$this->syntax.'\:include="(.*)" \/\>/', $data, $match);
        $max = count($match[1]);
        $i = 0;
        while($i != $max) {
            $file = LINK . "templates/" . $match[1][$i] . ".tpl";
            if(!is_file($file)) {
                throw new Exception("Template file is missing or empty");
                exit();
            }
            $data2 = $this->read($file);
            $data = str_replace($match[0][$i], $data2, $data);
            $i++;
        }

        // Part 2: Variable Replacement (Assigned Variables)
        if(!is_array($assign)) {
            return false;
        }
        foreach($assign as $var_name => $var_value) {
            preg_match_all('/\<'.$this->syntax.'\:variable="'.$var_name.'" \/\>/', $data, $match);
            $matches = $match[0];
            $max = count($matches);
            $i = 0;
            while($i != $max) {
                $data = str_replace($matches[$i], $var_value, $data);
                $i++;
            }
        }
        return $data;
    }

}