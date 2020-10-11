<?php require ROOT . '/app/resources/views/layouts/header.php'; ?>
<title>
    Home
</title>
<section>
    <div class="container">
        <h2>
            Hello <?php echo $this->data['login'] ?>!
        </h2>

    </div>
</section>

<?php require ROOT . '/app/resources/views/layouts/footer.php'; ?>