<div class="wrapper">
	<nav id="sidebar" class="sidebar js-sidebar">
		<div class="sidebar-content js-simplebar">
			<a class="sidebar-brand" href="">
				<div class="align-middle">Letsgob<i class="align-middle" data-feather="aperture"></i>is Web</div>
			</a>
			
			<!-- Query Menu -->
			<?php foreach ($menu as $m) : ?>
			<ul class="sidebar-nav">
				<li class="sidebar-header">
					<?= $m['menu'] ?>
				</li>
			
				<?php foreach ($m['sub_menu'] as $sm) : ?>
				<li class="sidebar-item <?= ($sm['title'] == $title) ? 'active' : '' ?>">
					<a class="sidebar-link" href="<?= base_url($sm['url']) ?>">
						<i class="align-middle" data-feather="<?= $sm['icon'] ?>"></i> <span class="align-middle"><?= $sm['title'] ?></span>
					</a>
				</li>
				<?php endforeach ?>
			</ul>

			<?php endforeach; ?>

			<ul class="sidebar-nav">
				<li class="sidebar-item">
					<a class="sidebar-link" href="<?= base_url('/logout') ?>">
						<i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Logout</span>
					</a>
				</li>
			</ul>
			
		</div>
	</nav>

	<div class="main">
		<nav class="navbar navbar-expand navbar-light navbar-bg">
			<a class="sidebar-toggle js-sidebar-toggle">
				<i class="hamburger align-self-center"></i>
			</a>

			<div class="navbar-collapse collapse">
				<ul class="navbar-nav navbar-align">
					<li class="nav-item dropdown">
						<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
							<i class="align-middle" data-feather="settings"></i>
						</a>
						
						<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
							<img src="<?= base_url() ?>img/photos/<?= $user['image'] ?>" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark"><?= $user['name'] ?></span>
						</a>
						<div class="dropdown-menu dropdown-menu-end">
							<a class="dropdown-item" href="<?= base_url('/user') ?>"><i class="align-middle me-1" data-feather="user"></i>My Profile</a>
							<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
							<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?= base_url('/logout')?>">Log out</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>