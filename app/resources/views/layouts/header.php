<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="/app/resources/css/style.css" rel="stylesheet">
</head>
<body class="text-center">
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">TestTask1</h5>
    <?php if (\testTask1\app\models\User::isGuest()) : ?>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="/register">Register</a>
    </nav>
    <a class="btn btn-outline-primary" href="/">Enter</a>
    <?php else : ?>
        <a class="btn btn-outline-danger" href="/logout">Exit</a>
    <?php endif; ?>
</div>