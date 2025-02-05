<?= $this->extend('layout/auth_template') ?>

<?= $this->section('content') ?>

<main class="d-flex w-100">
	<div class="container d-flex flex-column">
		<div class="row vh-100">
			<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
				<div class="d-table-cell align-middle">

					<div class="text-center mt-4">
						<h1 class="h2">Login Page</h1>
						<p class="lead">
							Sign in to your account to continue
						</p>
					</div>

					<div class="card">
						
						<div class="card-body">
							
							<div class="m-sm-3">
								<?php if(session()->getFlashdata('message')): ?>
									<?= session()->getFlashdata('message') ?>
								<?php endif ?>
								<form method="post" action="<?= base_url('/') ?>">
									<div class="mb-3">
										<label class="form-label">Email</label>
										<input class="form-control form-control-lg <?= (session('errors.email')) ? 'is-invalid' : '' ?>" type="text" id="email" name="email" value="<?= old('email') ?>" placeholder="Enter your email" />
										<div class="invalid-feedback"><?= session('errors.email') ?></div>
									</div>
									<div class="mb-3">
										<label class="form-label">Password</label>
										<input class="form-control form-control-lg <?= (session('errors.password')) ? 'is-invalid' : '' ?>" type="password" id="password" name="password" placeholder="Enter your password" />
										<div class="invalid-feedback"><?= session('errors.password') ?></div>
									</div>
									<div class="d-grid gap-2 mt-3">
										<button type="submit" class="btn btn-lg btn-primary">Login</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="text-center mb-3">
						Don't have an account? <a href="<?= base_url('/registration') ?>">Registration</a>
						<a class="ms-4" href="<?= base_url('/forgotpassword')?>">Forgot Password?</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?= $this->endSection() ?>