<?= $this->extend('layout/auth_template') ?>

<?= $this->section('content') ?>

<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-3">
                        <h1 class="h2">Get started</h1>
                        <p class="lead">
                            Start creating the best possible user experience for you customers.
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-2">
                                <form method="post" action="<?= base_url('/registration') ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Full name</label>
                                        <input class="form-control form-control-lg <?= (session('errors.name')) ? 'is-invalid' : '' ?>" id="name" type="text" name="name" value="<?= old('name') ?>" placeholder="Enter your name" />
                                        <div class="invalid-feedback"><?= session('errors.name') ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input class="form-control form-control-lg <?= (session('errors.email')) ? 'is-invalid' : '' ?>" id="email" type="text" name="email" value="<?= old('email') ?>" placeholder="Enter your email" />
                                        <div class="invalid-feedback"><?= session('errors.email') ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control form-control-lg <?= (session('errors.password1')) ? 'is-invalid' : '' ?>" id="password1" type="password" name="password1" placeholder="Enter password" />
                                            <div class="invalid-feedback"><?= session('errors.password1') ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <input class="form-control form-control-lg <?= (session('errors.password2')) ? 'is-invalid' : '' ?>" id="password2" type="password" name="password2" placeholder="Enter password" />
                                            <div class="invalid-feedback"><?= session('errors.password2') ?></div>
                                    </div>
                                    <div class="d-grid gap-2 mt-2">
                                        <button type="submit" class="btn btn-lg btn-primary">Registration</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-2">
                        Already have account? <a href="<?= base_url() ?>">Log In</a>
                        <a class="ms-4" href="<?= base_url('/forgotpassword')?>">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>