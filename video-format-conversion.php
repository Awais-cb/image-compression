<?php

require_once 'functions.php';

$inputExtensions = ['avi', 'mov', 'mkv', 'webm', 'flv', 'wmv', 'mpeg', 'mpg'];
$outputExtension = 'mp4';

$inputPath = 'videos/original/';
$outputPath = 'videos/converted/';

if (!is_dir($outputPath)) {
    mkdir($outputPath, 0755, true);
}

foreach ($inputExtensions as $ext) {
    $videoFiles = glob($inputPath . "*.$ext");

    foreach ($videoFiles as $videoFile) {
        $inputFileName = $videoFile;
        $baseName = pathinfo($inputFileName, PATHINFO_FILENAME);
        $outputFileName = $baseName . '.' . $outputExtension;
        $outputFullPath = $outputPath . $outputFileName;

        $cmd = "ffmpeg -y -i " . escapeshellarg($inputFileName) .
               " -vf \"scale=trunc(iw/2)*2:trunc(ih/2)*2\" -c:v libx264 -preset medium -crf 23 -c:a aac -b:a 128k " .
               escapeshellarg($outputFullPath) . " 2>&1";

        p("Running: $cmd");

        $output = shell_exec($cmd);
        p($output);

        if (file_exists($outputFullPath) && filesize($outputFullPath) > 1024) {
            p("✅ Converted: $inputFileName -> $outputFullPath");
        } else {
            p("❌ Failed to convert: $inputFileName");
        }

        p("--------------------------------------------------------");
    }
}
