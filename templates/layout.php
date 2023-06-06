<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kursy walut</title>
    <link rel="stylesheet" href="/resources/bootstrap.min.css">
    <script src="/resources/bootstrap.bundle.min.js"></script>

</head>
<body class="container">
    <header>
        <h1><a href="/" style="color: black;text-decoration: none;">Kursy walut</a></h1>
    </header>
    <div>

    <?php
        if (!empty($_SESSION)) {
            if ($_SESSION['flash']['type'] == 'error') {
                $alertClass = 'danger';
            } elseif ($_SESSION['flash']['type'] == 'success') {
                $alertClass = 'success';
            }
    
            echo "<div class=\"alert alert-$alertClass\">
                    {$_SESSION['flash']['message']}
                </div>";
        } ?>

    </div>
    
        <?php require_once("templates/pages/$page.php");?>

    <footer class="mt-5">
        <?php if ($_SERVER['REQUEST_URI'] !== '/'): ?>
            <a href="/" class="btn btn-primary btn-sm">Powrót do strony głównej</a>
        <?php endif; ?>
    </footer>
</body>
</html>