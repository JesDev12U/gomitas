<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      background-color: #f4f4f7;
      font-family: "Segoe UI", Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 480px;
      margin: 40px auto;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
      padding: 32px 24px;
    }

    h2 {
      color: #333;
      text-align: center;
      margin-bottom: 16px;
    }

    p {
      color: #555;
      font-size: 16px;
      line-height: 1.5;
      text-align: center;
    }

    .footer {
      text-align: center;
      color: #aaa;
      font-size: 13px;
      margin-top: 32px;
    }

    <?= $css ?>
  </style>
</head>

<body>
  <div class="container">
    <?= $content ?>
    <div class="footer">
      © 2025 GomiBike. Todos los derechos reservados.
    </div>
  </div>
</body>

</html>