<?php $this->extend('layout/template') ?>

<?php $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Menu Management</h1>

        <?= session()->getFlashdata('message') ?: '' ?>

        <div class="row">
            <div class="col-12">
                <div class="card flex-fill">
                    <div class="card-header">
                        <a href="" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addNewModal">New Menu</a>
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
                            <?php foreach ($all_menu as $m) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $m['menu'] ?></td>
                                    <td>
                                        <a href="" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editMenu" data-menu="<?= $m['menu'] ?>" data-id="<?= $m['id'] ?>">Edit</a>
                                        <a href="" class="btn btn-primary btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteMenu" data-menu="<?= $m['menu'] ?>" data-id="<?= $m['id'] ?>">Delete</a>
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

<!-- addNewModal -->
<div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Menu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('menu') ?>" method="post">

                <div class="modal-body">
                    <input type="text" class="form-control" id="menu" name="menu" placeholder="Insert menu name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EditMenuModal -->
<div class="modal fade" id="editMenu" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Menu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <input type="text" class="form-control" id="menu" name="menu" placeholder="Insert menu name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- deleteMenu Modal -->
<div class="modal fade" id="deleteMenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure want to delete <span id="menuName"></span> menu?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="" method="post" id="deleteForm" class="d-inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
    const editMenuModal = document.getElementById('editMenu');
    editMenuModal.addEventListener('show.bs.modal', function (event) {
        // Autofocus
        const menuNameModal = editMenuModal.querySelector('input#menu');

        const button = event.relatedTarget;
        const menuName = button.getAttribute('data-menu');
        const menuId = button.getAttribute('data-id');
        
        const editForm = menuNameModal.parentElement.parentElement;

        menuNameModal.value = menuName;

        editForm.action = '<?= base_url() ?>menu/' + menuId;
    });

    const deleteMenuModal = document.getElementById('deleteMenu');
    deleteMenuModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const menuName = button.getAttribute('data-menu');
        const menuId = button.getAttribute('data-id');
        
        const modalBodySpan = deleteMenuModal.querySelector('.modal-body #menuName');
        const deleteForm = deleteMenuModal.querySelector('.modal-footer #deleteForm');
        
        modalBodySpan.textContent = menuName;
        deleteForm.action = '<?= base_url() ?>menu/' + menuId;
    });
</script>

<?php $this->endSection() ?>