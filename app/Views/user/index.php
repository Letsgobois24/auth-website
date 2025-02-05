<?php $this->extend('layout/template') ?>

<?php $this->section('content') ?>

<main class="content">
	<div class="container-fluid p-0">

		<div class="mb-3">
			<h1 class="h3 d-inline align-middle">My Profile</h1>

			<?= session()->getFlashdata('message') ?: '' ?>
		
		</div>
		<div class="row">
			<div class="col-md-4 col-xl">
				<div class="card mb-3">
					<div class="card-header">
						<h5 class="card-title mb-0">Profile Details</h5>
					</div>
					<div class="card-body text-center">
						<img src="img/photos/<?= $user['image'] ?>" alt="<?= $user['name'] ?> image" class="img-fluid rounded-circle mb-2" width="128" height="128" />
						<h5 class="card-title mb-0"><?= $user['name'] ?> (<?= $role ?>)</h5>
						<div class="text-muted mb-2">Lead Developer</div>

						<div>
							<a class="btn btn-primary btn-sm" href="#">Follow</a>
							<a class="btn btn-primary btn-sm" href="#"><span data-feather="message-square"></span> Message</a>
						</div>
					</div>
					<hr class="my-0" />
					<div class="card-body">
						<h5 class="h6 card-title">Skills</h5>
						<a href="#" class="badge bg-primary me-1 my-1">HTML</a>
						<a href="#" class="badge bg-primary me-1 my-1">JavaScript</a>
						<a href="#" class="badge bg-primary me-1 my-1">Sass</a>
						<a href="#" class="badge bg-primary me-1 my-1">Angular</a>
						<a href="#" class="badge bg-primary me-1 my-1">Vue</a>
						<a href="#" class="badge bg-primary me-1 my-1">React</a>
						<a href="#" class="badge bg-primary me-1 my-1">Redux</a>
						<a href="#" class="badge bg-primary me-1 my-1">UI</a>
						<a href="#" class="badge bg-primary me-1 my-1">UX</a>
					</div>
					<hr class="my-0" />
					<div class="card-body">
						<h5 class="h6 card-title">About</h5>
						<ul class="list-unstyled mb-0">
							<li class="mb-1"><span data-feather="home" class="feather-sm me-1"></span> Lives in <a href="#">San Francisco, SA</a></li>

							<li class="mb-1"><span data-feather="briefcase" class="feather-sm me-1"></span> Works at <a href="#">GitHub</a></li>
							<li class="mb-1"><span data-feather="map-pin" class="feather-sm me-1"></span> From <a href="#">Boston</a></li>
						</ul>
					</div>
					<hr class="my-0" />
					<div class="card-body">
						<h5 class="h6 card-title">Elsewhere</h5>
						<ul class="list-unstyled mb-0">
							<li class="mb-1"><a href="#">staciehall.co</a></li>
							<li class="mb-1"><a href="#">Twitter</a></li>
							<li class="mb-1"><a href="#">Facebook</a></li>
							<li class="mb-1"><a href="#">Instagram</a></li>
							<li class="mb-1"><a href="#">LinkedIn</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

	</div>
</main>

<?php $this->endSection() ?>