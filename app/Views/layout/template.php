<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="<?= base_url() ?>/img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

	<title><?= $title ?></title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="<?= base_url() ?>/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>

	<?= $this->include('layout/navbar') ?>
	<?= $this->renderSection('content') ?>
	<?= $this->include('layout/footer') ?>

	<!-- <script>
		document.addEventListener('DOMContentLoaded', function() {
			const sidebarLink = document.querySelectorAll('a.sidebar-link');
			sidebarLink.forEach(function(link) {
				link.addEventListener('click', function(event) {

					const url = link.href;
					event.preventDefault();

					const containerLink = link.parentElement;

					const sidebar = document.getElementById('sidebar');
					const activeContainerLink = sidebar.querySelector('.active');

					activeContainerLink.classList.remove('active');
					containerLink.classList.add('active');

					fetch(url, {
							headers: {
								'X-Requested-With': 'XMLHttpRequest'
							}
						})
						.then(response => response.text())
						.then(data => {
							const parser = new DOMParser();
							const doc = parser.parseFromString(data, 'text/html');
							const mainContent = doc.querySelector('main').innerHTML;

							document.querySelector('main').innerHTML = mainContent;
							const scripts = doc.querySelectorAll('script');

							scripts.forEach(oldScript => {
								const newScript = document.createElement('script');
								if (oldScript.src) {
									newScript.src = oldScript.src;
								} else {
									newScript.textContent = oldScript.textContent;
								}
								document.body.appendChild(newScript);
								// // Hapus script lama jika perlu
								// oldScript.parentNode.removeChild(oldScript);
							});
						})
						.catch(error => console.log(error))
				})
			})
		})
	</script> -->

</body>

</html>