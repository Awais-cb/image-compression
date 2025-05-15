<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$inputExtentions = ['jpg', 'jpeg', 'JPEG', 'png', 'PNG', 'webp'];
$outputPostfix = "_compressed.webp";
$qualityLevel = 80;
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
        
        // $ffmpegCommand = "ffmpeg -y -noautorotate -i {$inputFileName} -c:v libwebp -q:v {$qualityLevel} {$outputPath}{$outputFileName}";
        // forcing roating to specific angle
        // Value	Rotation
        // 0	90° clockwise
        // 1	90° counter-clockwise
        // 2	90° clockwise and flip
        // 3	90° counter + flip
        $ffmpegCommand = "ffmpeg -y -i {$inputFileName} -vf \"transpose=1\" -c:v libwebp -q:v {$qualityLevel} {$outputPath}{$outputFileName}";

    
        p($ffmpegCommand);
        $output = shell_exec($ffmpegCommand);
        p($output);
        p("Converted $inputFileName to {$outputPath}{$outputFileName}");
        p("------------------------------------------------");
    }
}
?>
