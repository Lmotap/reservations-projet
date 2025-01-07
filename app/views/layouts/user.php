<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Authentication' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="/public/css/styles.css" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat" 
      style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.pexels.com/photos/763097/pexels-photo-763097.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');">
    <?= $content ?>
</body>
</html>