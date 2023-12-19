<?php
function doOCR($imagePath)
{
    // Lokasi Tesseract OCR di server
    $tesseractPath = 'C:\\Program Files\\Tesseract-OCR\\tesseract.exe'; // Sesuaikan dengan lokasi Tesseract OCR di server Anda

    // Lokasi output teks dari OCR
    $outputPath = 'C:\\Users\\arify\\OneDrive\\Desktop\\ml\\output'; // Sesuaikan lokasi dan nama file output (tanpa ekstensi .txt)

    // Perintah untuk menjalankan Tesseract OCR
    $command = "\"{$tesseractPath}\" \"{$imagePath}\" \"{$outputPath}\"";

    // Jalankan perintah shell
    shell_exec($command);

    // Baca isi file output teks
    $text = file_get_contents($outputPath . '.txt');

    // Hapus file output teks setelah digunakan
    unlink($outputPath . '.txt');

    return $text;
}

// Ambil data gambar dari request POST
$imageData = $_POST['imageData'];

// Decode data gambar dari format base64
$imageData = str_replace('data:image/png;base64,', '', $imageData);
$imageData = str_replace(' ', '+', $imageData);
$imageData = base64_decode($imageData);

// Simpan gambar ke file
$imagePath = 'C:\\Users\\arify\\OneDrive\\Desktop\\ml\\captured_image.png';
file_put_contents($imagePath, $imageData);

// Include file yang berisi definisi fungsi doOCR
include 'C:\\xampp\\htdocs\\ml\\ocr.php'; // Sesuaikan path sesuai dengan struktur direktori Anda

// Lakukan OCR pada gambar
$hasilOCR = doOCR($imagePath);

// Tampilkan hasil OCR
echo $hasilOCR;
?>
