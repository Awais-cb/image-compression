<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$input_ext = "jpg";
$output_postfix = "_compressed.webp";
$qualityLevel = 20;


if (!function_exists('dd')) {
    function dd($d)
    {
        die('<pre>' . print_r($d, 1));
    }
}

if (!function_exists('p')) {
    function p($d, $log=true)
    {
        if ($log) {
            error_log(print_r($d, 1));
        }
        echo '<pre>';
        print_r($d);
        echo '</pre>';
    }
}


// Get a list of all image files in the current folder
$imageFiles = glob("*.{$input_ext}");
// dd($imageFiles);
// Iterate through the image files and run FFmpeg command
foreach ($imageFiles as $imageFile) {
    $inputFileName = $imageFile;
    $outputFileName = str_replace(".{$input_ext}", $output_postfix, $imageFile);

    // Construct and execute the FFmpeg command
    $ffmpegCommand = "ffmpeg -y -i {$inputFileName} -c:v libwebp -q:v {$qualityLevel} {$outputFileName}";
   
    p($ffmpegCommand);
    $output = shell_exec($ffmpegCommand);
    p($output);
    p("Converted $inputFileName to $outputFileName");
    p("------------------------------------------------");
}

?>
