<?php $this->extend('layout/template') ?>

<?php $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Role Management</h1>

        <?= session()->getFlashdata('message') ?: '' ?>

        <div class="row">
            <div class="col-12">
                <div class="card flex-fill">
                    <div class="card-header">
                        <a href="" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addNewRole">New Role</a>
                    </div>
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1 ?>
                            <?php foreach ($roles as $role) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $role['role'] ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/roleaccess/') . $role['id'] ?>" class="btn btn-secondary btn-sm me-2">Access</a>
                                        <a href="" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editRole" data-role="<?= $role['role'] ?>" data-id="<?= $role['id'] ?>">Edit</a>
                                        <a href="" class="btn btn-primary btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteRole" data-role="<?= $role['role'] ?>" data-id="<?= $role['id'] ?>">Delete</a>
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


<!-- deleteRole Modal -->
<div class="modal fade" id="deleteRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Role</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure want to delete <span id="roleName"></span> role?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" action="" method="post" class="d-inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- addNewRole Modal -->
<div class="modal fade" id="addNewRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Menu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/role') ?>" method="post">

                <div class="modal-body">
                    <input type="text" class="form-control" id="role" name="role" placeholder="Insert role name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Role</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <input type="text" class="form-control" id="role" name="role" placeholder="Insert role name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const deleteRoleModal = document.getElementById('deleteRole');
    deleteRoleModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const roleName = button.getAttribute('data-role');
        const roleId = button.getAttribute('data-id');

        const modalBodySpan = deleteRoleModal.querySelector('.modal-body #roleName');
        const deleteForm = deleteRoleModal.querySelector('.modal-footer #deleteForm');

        modalBodySpan.textContent = roleName;
        deleteForm.action = '<?= base_url() ?>admin/deleteRole/' + roleId;
    });

    const editRoleModal = document.getElementById('editRole');
    editRoleModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const roleName = button.getAttribute('data-role');
        const roleId = button.getAttribute('data-id');

        const roleNameModal = editRoleModal.querySelector('input#role');
        const editForm = roleNameModal.parentElement.parentElement;

        roleNameModal.value = roleName;

        editForm.action = '<?= base_url() ?>admin/role/' + roleId;
    });
</script>

<?php $this->endSection() ?>