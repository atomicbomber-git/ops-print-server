<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> <?= $title ?? "Website Name" ?> </title>
    <link rel="stylesheet" href="<?= base_url("assets/app.css") ?>">
</head>
<body class="pt-5">
    <?= $this->section('content') ?>

    <script src="<?= base_url("assets/app.js") ?>"></script>
    <?= $this->section('extra-scripts') ?>
</body>
</html>