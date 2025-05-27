<?php

require_once 'functions.php';

$inputExtentions = ['jpg', 'jpeg', 'JPEG', 'png', 'PNG', 'webp'];
$outputPostfix = "_compressed.webp";
$qualityLevel = 80;

$inputPath = "images/original/";
$outputPath = "images/converted/";

foreach ($inputExtentions as $key => $inputExtention) {
    // Get a list of all image files in the current folder
    $imageFiles = glob("{$inputPath}*.{$inputExtention}");
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
