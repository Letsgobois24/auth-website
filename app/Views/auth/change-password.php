<?= $this->extend('layout/auth_template') ?>

<?= $this->section('content') ?>

<main class="d-flex w-100">
	<div class="container d-flex flex-column">
		<div class="row vh-100">
			<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
				<div class="d-table-cell align-middle">

					<div class="text-center mt-4">
						<h1 class="h2">Change Password</h1>
                        <p class="lead">
							<?= session('change-password') ?>
						</p>
					</div>

					<div class="card">
						
						<div class="card-body">
							
							<div class="m-sm-3">
								
								<form method="post" action="<?= base_url('changepassword') ?>">
									<div class="mb-3">
										<label class="form-label">Password</label>
										<input class="form-control form-control-lg <?= (session('errors.password1')) ? 'is-invalid' : '' ?>" type="password" id="password1" name="password1" placeholder="Enter new password" />
										<div class="invalid-feedback"><?= session('errors.password1') ?></div>
									</div>
									<div class="mb-3">
										<label class="form-label">Confirm Password</label>
										<input class="form-control form-control-lg <?= (session('errors.password2')) ? 'is-invalid' : '' ?>" type="password" id="password2" name="password2" placeholder="Repeat password" />
										<div class="invalid-feedback"><?= session('errors.password2') ?></div>
									</div>
									<div class="d-grid gap-2 mt-3">
										<button type="submit" class="btn btn-lg btn-primary">Change Password</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?= $this->endSection() ?>