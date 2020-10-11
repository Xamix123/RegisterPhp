<?php require ROOT . '/app/resources/views/layouts/header.php'; ?>
<section>

            <div class ="row justify-content-center">

                <div class ="col-md-6">
                    <?php if (! empty($this->data['errors']) && is_array($this->data['errors'])) : ?>
                    <div class="alert alert-danger">
                        <ul class="text-left">
                            <?php foreach ($this->data['errors'] as $error) : ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                        <h2>Регистрация</h2>
                        <form action ="#" method="post">
                            <label for="login" class="sr-only">Login</label>
                            <input type="text" name="login" id="login" class="form-control" placeholder="Login" required autofocus>
                            <label for="password" class="sr-only">Password</label><br>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required><br>
                            <input name="submit" class="btn btn-lg btn-primary btn-block" type="submit"/>
                        </form>
                </div>
            </div>

</section>
<?php require ROOT . '/app/resources/views/layouts/footer.php'; ?>