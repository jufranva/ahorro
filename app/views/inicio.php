<?php include __DIR__ . '/layout/header.php'; ?>

    <!-- Breadcrumb Section Start -->
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Ingreso al sistema</h1>
                    <ul>
                        <li>
                            <a href="index.php">inicio </a>
                        </li>
                        <li class="active"> Ingreso al sistema</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <!-- Login | Register Section Start -->
    <div class="section section-margin">
        <div class="container">

            <div class="row mb-n10">
                <!--
                    Login Wrapper Start -->
                <div class="col-lg-6 col-md-8 m-auto pb-10">
                    <div class="login-wrapper">

                        <!-- Login Title & Content Start -->
                        <div class="section-content text-center mb-5">
                            <h2 class="title mb-2">Ingresar al sistema</h2>
                            <p class="desc-content">Por favor ingrese sus credenciales de acceso.</p>
                            <?php if (!empty($error)): ?>
                                <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>
                        </div>
                        <!-- Login Title & Content End -->

                        <!-- Form Action Start -->
                        <form action="" method="post">

                            <!-- Input Email Start -->
                            <div class="single-input-item mb-3">
                                <input type="text" name="username" placeholder="Nombre de usuario" required>
                            </div>
                            <!-- Input Email End -->

                            <!-- Input Password Start -->
                            <div class="single-input-item mb-3">
                                <input type="password" name="password" placeholder="Contraseña" required>
                            </div>
                            <!-- Input Password End -->

                            <!-- Checkbox/Forget Password Start -->
                            <div class="single-input-item mb-3">
                                <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                    <div class="remember-meta mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="rememberMe">
                                            <label class="custom-control-label" for="rememberMe">Recuardame</label>
                                        </div>
                                    </div>
                                    <a href="#" class="forget-pwd mb-3">olvidó la contraseña?</a>
                                </div>
                            </div>
                            <!-- Checkbox/Forget Password End -->

                            <!-- Login Button Start -->
                            <div class="single-input-item mb-3">
                                <button class="btn btn btn-dark btn-hover-primary rounded-0" type="submit">Iniciar Sesión</button>
                            </div>
                            <!-- Login Button End -->

                        </form>
                        <!-- Form Action End -->

                    </div>
                </div>
                <!-- Login Wrapper End
                -->

            </div>

        </div>
    </div>
    <!-- Login | Register Section End -->

<?php include __DIR__ . '/layout/footer.php'; ?>
