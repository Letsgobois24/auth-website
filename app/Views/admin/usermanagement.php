<?php $this->extend('layout/template') ?>

<?php $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">User Management</h1>

        <?= session()->getFlashdata('message') ?: '' ?>

        <div class="row mb-3">
            <div class="col-12 col-sm-6">
                <form method="post" action="<?= base_url('admin/usermanagement') ?>" class="d-flex" role="search">
                    <input class="form-control" name="keyword" type="search" placeholder="Search" aria-label="Search" value="<?= $keyword ?>">
                    <input type="hidden" name="max-rows" value="<?= $maxRows ?>">
                    <button class="btn btn-outline-info" type="submit">
                        <i class="align-middle" data-feather="search"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="row mb-3 d-flex justify-content-between">
            <div class="col-12 col-sm-2 d-flex align-items-center">
                <label for="max-rows" class="me-2">Rows</label>
                <select class="form-select max-rows-select" name="max-rows" id="max-rows">
                    <option value="2">2</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <div class="col-12 col-lg col-xxl-9 d-flex">
            <div class="card flex-fill">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th class="d-none d-xl-table-cell">Email</th>
                            <th>Role</th>
                            <th>Active</th>
                            <th class="d-none d-xl-table-cell">Created At</th>
                            <th class="d-none d-xl-table-cell">Updated At</th>
                        </tr>
                    </thead>
                    <?php $i = $currentPage * $maxRows - 1 ?>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $user['name'] ?></td>
                                <td class="d-none d-xl-table-cell"><?= $user['email'] ?></td>
                                <td>
                                    <select class="form-select role-select" id="role_id" name="role_id" data-id="<?= $user['id'] ?>">
                                        <?php foreach ($roles as $role) : ?>
                                            <option <?= selected_option($role['role'], $user['role']) ?> value="<?= $role['id'] ?>">
                                                <?= $role['role'] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td>
                                <input class="form-check-input" type="checkbox" value="1" <?= ($user['is_active'] == 1) ? 'checked' : ''  ?> data-id="<?= $user['id'] ?>">
                                </td>
                                <td class="d-none d-xl-table-cell"><?= time_parsing($user['created_at']) ?></td>
                                <td class="d-none d-xl-table-cell"><?= time_parsing($user['updated_at']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <?= $pager->links('user', 'user_pagination') ?>
            </div>
        </div>

    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
    $('#max-rows').val(<?= $maxRows ?>);
    
    $('#max-rows').on('change', function() {
        const maxRows = $(this).val();
        const keyword = $('input[name="keyword"]').val();

        $.ajax({
            url: "<?= base_url('admin/usermanagement') ?>",
            type: "get",
            data: {
                maxRows: maxRows,
                keyword: keyword
            },
            
            success: function(response) {
                window.location.reload();
            },
            
        })

    })

    $('.form-check-input').on('change', function() {
        const id = $(this).data('id');
        const checked = $(this).is(':checked');

        $.ajax({
            url: "<?= base_url('admin/changeactivation') ?>",
            type: "post",
            data: {
                id: id,
                checked: checked
            },
            success: function() {
                window.location.reload();
            }
        })
    })

    $('.role-select').on('change', function() {
        const selectedOption = $(this).val();
        const id = $(this).data('id');

        if (selectedOption) {
            $.ajax({
                url: "<?= base_url('admin/changerole') ?>",
                type: "post",
                data: {
                    id: id,
                    role_id: selectedOption
                },
                success: function() {
                    window.location.reload();
                }
            });
        }
    });
</script>

<?= $this->endSection() ?>