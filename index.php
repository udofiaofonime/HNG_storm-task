<?php
// $file = 'echo.php';

// if (file_exists($file)) {
//     $file = dirname(__DIR__) . '/test/' . $file;
//     shell_exec("node " . $file);
// }

// $output = shell_exec('ls');

// $output = explode(" ", $output);

// var_dump($output);
// $file = dirname(__DIR__) . '/test/' . $file;

// include 'script.js';

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// $read = exec("node script.js");

// echo $read;
// $log_directory = dirname(__FILE__);
// $files = [];

// foreach (glob($log_directory . '/*.*') as $file) {
//     $files[] = $file;
// }

// foreach ($files as $file) {
//     $ext = pathinfo($file, PATHINFO_EXTENSION);
//     if ($ext === 'js') {
//         $read = exec("node {$file}");
//         echo $read . "\n";
//     }
// }


// code start here

// Get scripts (from yanmifeakeju)
$files = scandir('scripts');
$content = [];


function getScripts($files)
{
    // add extensions here
    $extensions = [
        'js' => 'node',
        'php' => 'php',
        'py' => 'python',
        'javac' => 'java',
        'dart' => 'dart',
    ];    
    
    foreach ($files as $file) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        // var_dump($ext);
        if (array_key_exists($ext, $extensions)) {
            $scripts[] = [ 
                'name' => 'scripts/' . $file, 
                'command' => $extensions[$ext], 
                'filename' => $file,
        ];  
     }
    }   
    
    return $scripts;

};
    
    $scripts = getScripts($files);

   
    // format output data
    
    foreach ($scripts as $key => $script) {
    if (file_exists($scripts[$key]['name'])) {
        $read = exec("{$scripts[$key]['command']} {$scripts[$key]['name']}");
        $string_array = explode(" ", $read);
        // print_r($string_array);

        $id = isset($string_array[9]) ? $string_array[9] : '';
        $name =  isset($string_array[4]) && isset($string_array[5]) ? $string_array[4].' '.$string_array[5] : '';
        $email = isset($string_array[12]) ? $string_array[12]  :'';
        $language = isset($string_array[14]) ? $string_array[14] : '';

        $content[] = [
            'file' => $scripts[$key]['filename'],
            'output' => $read,    
            "name"  => $name,    
            'id' => $id,
            'email' => $email,
            'status' => testStringContents($read),
            'language' => $language,

        ];
    }}


     function testStringContents($string){
        if(preg_match('/^Hello\sWorld[,|.|!]?$/i', trim($string))){
            return 'Pass';
        }

        return 'Fail';
    }

    
   echo json_encode($content);
  