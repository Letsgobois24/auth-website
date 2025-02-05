<?php $this->extend('layout/template') ?>

<?php $this->section('content') ?>

<main class="content">
    <a class="btn btn-primary mb-3" href="<?= base_url('/admin/role') ?>"><i class="align-middle me-2" data-feather="arrow-left"></i>Back</a>
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Role Access Management</h1>
        <h5 class="h5 mb-3">Role : <?= $role['role'] ?></h5>

        <?= session()->getFlashdata('message') ?: '' ?>
        
        <div class="row">
            <div class="col-12">
                <div class="card flex-fill">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1 ?>
                            <?php foreach (array_slice($all_menu, 1) as $m) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $m['menu'] ?></td>
                                    <td>
                                        <input class="form-check-input" type="checkbox" <?= check_access($role['id'], $m['id']) ?>
                                            data-role="<?= $role['id'] ?>" data-menu="<?= $m['id'] ?>">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.form-check-input').on('click', function(){
		const menuId = $(this).data('menu');
		const roleId = $(this).data('role');

		$.ajax({
			url: "<?= base_url('admin/changeaccess') ?>",
			type: "post",
			data: {
				menuId: menuId,
				roleId: roleId
			},
			success: function(){
				document.location.href = "<?= base_url('admin/roleaccess/') ?>" + roleId
			}
		})
	})
</script>

<?php $this->endSection() ?>