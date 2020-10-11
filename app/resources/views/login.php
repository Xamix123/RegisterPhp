<?php require ROOT . '/app/resources/views/layouts/header.php'; ?>
<section>
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="container alert alert-success">
            <p>User added successfully</p>
        </div>
        <?php unset($_SESSION['success']);?>
    <?php endif; ?>

    <?php if (! empty($this->data['errors']) && is_array($this->data['errors'])) : ?>
        <div class="container alert alert-danger">
                <?php foreach ($this->data['errors'] as $error) : ?>
                  <p>  <?php echo $error; ?> </p>
                <?php endforeach; ?>
        </div>
    <?php endif; ?>
        <div class="block">
            <form class="form-signin" method="post">
                <h1 class="h3 mb-3 font-weight-normal">Enter</h1>
                <label for="login" class="sr-only">Login</label>
                <input type="text" id="login" name="login" class="form-control" placeholder="Login" required autofocus> <br>
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required><br>
                <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Enter"/>
            </form>
        </div>
</section>
<?php require ROOT . '/app/resources/views/layouts/footer.php'; ?>

