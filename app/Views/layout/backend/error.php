<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Minton - <?= $this->renderSection('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?= $this->renderSection('isLink'); ?>

    <?= view('layout/backend/head') ?>

</head>

<body>

    <?= $this->renderSection('showError'); ?>

    <?= view('layout/backend/script') ?>

    <?= $this->renderSection('isScript'); ?>

</body>

</html>