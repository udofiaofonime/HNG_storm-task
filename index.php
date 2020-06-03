<?php

$json_request = $_SERVER["QUERY_STRING"] ?? '';
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
$testPassed = 0;
$testFailed = 0;
$htmlOutput = [];


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
        
        // get values from string array
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
            'status' => testStringContentsMatch($read),
            'language' => $language,

        ];

        $htmlOutput[] = [$read, testStringContentsMatch($read), $name];
    }}


     function testStringContentsMatch($string){
        if(preg_match('/^Hello\sWorld[,|.|!]?\sthis\sis\s[a-zA-Z]{2,}\s[a-zA-Z]{2,}\swith\sHNGi7\sID\s(HNG-\d{3,})\sand\semail\s([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})\susing\s[a-zA-Z|#]{2,}\sfor\sstage\s2\stask.?$/i', trim($string))){
            return 'Pass';
        }

        return 'Fail';
    }


foreach ($htmlOutput as $test) {
    if ($test[1] == 'Pass') {
        $testPassed++;
    } elseif ($test[1] == 'Fail') {
        $testFailed++;
    }
}

    
   

//    echo $testFailed.''.$testPassed;

   if(isset($json_request) && $json_request == 'json'){
        echo json_encode($content);
   }else {

    ?>

<!-- FRONTEND CODE HERE -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> HNGi7 task 1| Team storm</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand text-light" href="#">HNGi7 Team Storm</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId"
            aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <!-- links here -->
                <!-- <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li> -->
            </ul>
        </div>
    </nav>

    <div class="container">
        <table class="table table-striped">
            <thead class="thead-inverse">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Output</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>


                <!-- // number of rows for loop counting
                // $rows = 0;

                // foreach($htmlOutput as $test=>$index){
                // echo <<<EOD // <tr>
                    // <td scope="row">$rows</td>
                    // <td></td>
                    // <td></td>
                    // <td></td>
                    // </tr>
                    // EOD;
                    // } -->



                <!-- // <tr>
                    // <td scope="row"></td>
                    // <td></td>
                    // <td></td>
                    // <td></td>
                    // </tr> -->
            </tbody>
            <thead class="thead-inverse">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Output</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>
</body>

</html>
<?php } ?>