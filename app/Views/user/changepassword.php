<?php $this->extend('layout/template') ?>

<?php $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Change Password</h1>

        <?= session()->getFlashdata('message') ?: '' ?>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <form action="<?= base_url('user/changepassword') ?>" method="post">
                        <input type="hidden" name="_method" value="PUT">
                            <div class="mb-3">
                                <label for="currentPassword" class="col-sm-3 col-form-label">Current Password</label>
                                <div class="col-sm">
                                    <input type="password" class="form-control <?= session('errors.currentPassword') ? 'is-invalid' : '' ?>" id="currentPassword" name="currentPassword">
                                    <div class="invalid-feedback"><?= session('errors.currentPassword') ?></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword1" class="col-sm-3 col-form-label">New Password</label>
                                <div class="col-sm">
                                    <input type="password" class="form-control <?= session('errors.newPassword1') ? 'is-invalid' : '' ?>" id="newPassword1" name="newPassword1">
                                    <div class="invalid-feedback"><?= session('errors.newPassword1') ?></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword2" class="col-sm-3 col-form-label">Repeat Password</label>
                                <div class="col-sm">
                                    <input type="password" class="form-control <?= session('errors.newPassword2') ? 'is-invalid' : '' ?>" id="newPassword2" name="newPassword2">
                                    <div class="invalid-feedback"><?= session('errors.newPassword2') ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php $this->endSection() ?>