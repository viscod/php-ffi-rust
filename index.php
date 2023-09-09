<?php

require_once"./CFFI.php";

use Toknot\CFFI;

$ffi = FFI::cdef("char *merge_pdf(char **files,int len, char *output);", "./libmerge_pdf.so");


$filesToMerge = [
    './order_confirmation_287.pdf',
    './order_confirmation_288.pdf',
    './order_confirmation_287.pdf',
    './order_confirmation_288.pdf',
    './order_confirmation_287.pdf',
    './order_confirmation_288.pdf',
    './order_confirmation_287.pdf',
    './order_confirmation_288.pdf',
    './order_confirmation_287.pdf',
    './order_confirmation_288.pdf',
    './order_confirmation_287.pdf',
    './order_confirmation_288.pdf',
    './order_confirmation_287.pdf',
    './order_confirmation_288.pdf',
    './order_confirmation_287.pdf',
    './order_confirmation_288.pdf',
    './order_confirmation_287.pdf',
    './order_confirmation_288.pdf',
    './order_confirmation_287.pdf',
    './order_confirmation_288.pdf',

];

$arrayType = FFI::arrayType(FFI::type("char*"), [count($filesToMerge)]);

$arrayData = FFI::new($arrayType, false);

for ($i = 0; $i < count($filesToMerge); $i++) {
    $string = $filesToMerge[$i];
    $targetPathPtr = CFFI::newCharPtr($string, false);
    $arrayData[$i] = $targetPathPtr;
}

$path = CFFI::newCharPtr('./test.pdf', false);

$resultString = $ffi->merge_pdf($arrayData,count($filesToMerge), $path);

$phpString =FFI::string($resultString);

if ($phpString === FFI::string($path)) {
    echo 'merge success, file path: '. $phpString.' '. PHP_EOL;
} else {
    echo 'merge failed, message returned: '. $phpString . ' '. PHP_EOL;
}


FFI::free($arrayData);
FFI::free($targetPathPtr);
FFI::free($path);
