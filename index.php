<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$inputExtentions = ['jpg', 'jpeg', 'png', 'PNG'];
$outputPostfix = "_compressed.webp";
$qualityLevel = 70;
$inputPath = "original/";
$outputPath = "compressed/";


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

foreach ($inputExtentions as $key => $inputExtention) {
    // Get a list of all image files in the current folder
    $imageFiles = glob("original/*.{$inputExtention}");
    // Iterate through the image files and run FFmpeg command
    foreach ($imageFiles as $imageFile) {
        
        $inputFileName = $imageFile;
        
        $fileName = basename($inputFileName);
        
        $outputFileName = str_replace(".{$inputExtention}", $outputPostfix, $fileName);
        
        $ffmpegCommand = "ffmpeg -y -i {$inputFileName} -c:v libwebp -q:v {$qualityLevel} {$outputPath}{$outputFileName}";
    
        p($ffmpegCommand);
        $output = shell_exec($ffmpegCommand);
        p($output);
        p("Converted $inputFileName to {$outputPath}{$outputFileName}");
        p("------------------------------------------------");
    }
}
?>
