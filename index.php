<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compressor de Imagens Base64</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            color: #333;
            text-align: center;
            padding: 50px;
            margin: 0;
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #6c63ff;
            text-transform: uppercase;
            animation: slideIn 1.5s ease-in-out;
        }

        textarea {
            width: 80%;
            height: 150px;
            border: 2px solid #6c63ff;
            background-color: #fff;
            color: #333;
            padding: 15px;
            font-size: 1.1em;
            resize: none;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(108, 99, 255, 0.2);
            transition: all 0.3s;
        }

        textarea:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 15px rgba(108, 99, 255, 0.4);
            outline: none;
        }

        button {
            background-color: #6c63ff;
            color: #fff;
            font-size: 1.2em;
            padding: 15px 25px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(108, 99, 255, 0.3);
        }

        button:hover {
            transform: scale(1.05);
        }

        .result {
            margin-top: 30px;
            animation: fadeIn 1.5s ease-in-out;
        }

        .result img {
            max-width: 100%;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(108, 99, 255, 0.3);
            animation: fadeInUp 1s ease-in-out;
        }

        .result textarea {
            width: 80%;
            height: 200px;
            margin-top: 20px;
        }

        p {
            font-size: 1.2em;
            color: #333;
        }

        /* Animações */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

    </style>
</head>
<body>

    <h2>Comprimir Imagem Base64 🖼️</h2>
    <form method="POST">
        <textarea name="base64_input" placeholder="Cole aqui a string Base64 da imagem"></textarea>
        <br><br>
        <button type="submit">Comprimir Agora 🚀</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["base64_input"])) {
        $base64Input = trim($_POST["base64_input"]);

        if (preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $base64Input)) {
            $base64Input = preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $base64Input);
        }

        function compressImageBase64($base64String, $quality = 65) {
            $imageData = base64_decode($base64String);
            $image = imagecreatefromstring($imageData);
            if (!$image) return false;

            ob_start();
            imagejpeg($image, null, $quality);
            $compressedImageData = ob_get_clean();
            imagedestroy($image);

            return base64_encode($compressedImageData);
        }

        $compressedBase64 = compressImageBase64($base64Input, 70);

        if ($compressedBase64) {
            echo "<div class='result'>";
            echo "<h3>Imagem Comprimida! 🎉</h3>";
            //echo "<img src='data:image/jpeg;base64," . $compressedBase64 . "' alt='Imagem Comprimida'>";
            echo "<p><strong>Base64 Comprimida:</strong></p>";
            echo "<textarea readonly>data:image/jpeg;base64," . $compressedBase64 . "</textarea>";
            echo "</div>";
        } else {
            echo "<p style='color: #e74c3c;'>Erro ao processar a imagem. Tente novamente! 😞</p>";
        }
    }
    ?>

</body>
</html>
