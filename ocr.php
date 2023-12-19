<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webcam OCR</title>
    <script>
        // Ambil gambar dari kamera dan kirim ke server PHP
        function captureAndOCR() {
            var video = document.getElementById("video");
            var canvas = document.createElement("canvas");
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);

            var dataURL = canvas.toDataURL("image/png");
            
            // Kirim data gambar ke server PHP
            fetch("process_image.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "imageData=" + encodeURIComponent(dataURL),
            })
            .then(response => response.text())
            .then(result => {
                // Tampilkan hasil OCR
                document.getElementById("hasilOCR").innerText = "Hasil OCR: \n" + result;
                
                // Buka halaman lain dengan hasil OCR
                window.location.href = "hasil_ocr.html?result=" + encodeURIComponent(result);
            })
            .catch(error => console.error("Error:", error));
        }
    </script>
</head>
<body>
    <video id="video" width="640" height="480" autoplay></video>
    <button onclick="captureAndOCR()">Ambil Gambar dan Lakukan OCR</button>
    <div id="hasilOCR"></div>

    <script>
        // Mengakses kamera menggunakan HTML5
        navigator.mediaDevices.getUserMedia({ video: true })
        .then(function (stream) {
            var video = document.getElementById("video");
            video.srcObject = stream;
        })
        .catch(function (error) {
            console.error("Error accessing webcam:", error);
        });
    </script>
</body>
</html>
