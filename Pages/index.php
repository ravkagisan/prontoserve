<?php
$current_page = 'beranda';

$script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
if (preg_match('#^(.*?)/(Pages|api|Components)#', $script_name, $matches)) {
    $base_url = $matches[1];
} else {
    $base_url = rtrim(dirname($script_name), '/\\');
    if ($base_url === '/' || $base_url === '\\') {
        $base_url = '';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - JTI NOVA</title>
    <link rel="stylesheet" href="<?= $base_url ?>/Style/style.css">
</head>
<body>

<?php require_once __DIR__ . '/../Components/navbar.php'; ?>

<?php require_once __DIR__ . '/../Components/carousel.php'; ?>

<?php require_once __DIR__ . '/../Components/footer.php'; ?>

</body>
</html>
