<?php $this->extend('layout/template') ?>

<?php $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">User Management</h1>

        <div class="alert alert-warning mt-2" role="alert" style="display: none;"></div>

        <div class="row mb-3">
            <div class="col-12 col-sm-6">
                <form id="search-form" class="d-flex" role="search">
                    <input class="form-control" name="keyword" type="search" placeholder="Search" aria-label="Search">

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
                    <option selected value="2">2</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <div class="col-12 col-lg col-xxl-9 d-flex">
            <div class="card flex-fill">
                <table class="table table-hover my-0" id="user-table">
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
                    <?php $i = 1 ?>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $user['name'] ?></td>
                                <td class="d-none d-xl-table-cell"><?= $user['email'] ?></td>
                                <td>
                                    <select class="form-select role-select" id="role_id" name="role_id" data-id="<?= $user['id'] ?>">
                                        <?php foreach ($roles as $role) : ?>
                                            <option <?= selected_option($role['id'], $user['role_id']) ?> value="<?= $role['id'] ?>">
                                                <?= $role['role'] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-check-input user-activation" type="checkbox" value="1" <?= ($user['is_active'] == 1) ? 'checked' : ''  ?> data-id="<?= $user['id'] ?>">
                                </td>
                                <td class="d-none d-xl-table-cell"><?= $user['created_at'] ?></td>
                                <td class="d-none d-xl-table-cell updated-at"><?= $user['updated_at'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <div class="pagination-links">
                    <?= $pager ?>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
    const searchForm = document.getElementById('search-form');
    const tableBody = document.querySelector('#user-table tbody');
    const maxRowsSelect = document.getElementById('max-rows');

    searchForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const maxRows = maxRowsSelect.value;
        const keyword = document.getElementsByTagName('input')[0].value;

        const url = window.location.origin + `/admin/usermanagement?keyword=${keyword}&maxrows=${maxRows}`;
        fetchUsers(url);
    });

    // Max Rows
    maxRowsSelect.addEventListener('change', function() {
        const maxRows = this.value;
        const keyword = document.getElementsByTagName('input')[0].value;
        const url = window.location.origin + `/admin/usermanagement?keyword=${keyword}&maxrows=${maxRows}`;

        fetchUsers(url);
    });

    function fetchUsers(url) {
        fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                getRows(data, tableBody);
                // updatePagination(data.pager);
            })
    }

    function getRows(data, tableBody) {
        tableBody.innerHTML = '';
        let i = 1;
        data['users'].forEach(user => {
            let row = `<tr>
                            <td>${i++}</td>
                            <td>${user.name}</td>
                            <td class="d-none d-xl-table-cell">${user.email}</td>
                            <td>
                                <select class="form-select role-select" id="role_id" name="role_id" data-id="${user.id}">
                                    ${data["roles"].map(role => `
                                        <option ${role.id == user.role_id ? 'selected' : ''} value="${role.id}">
                                            ${role.role}
                                        </option>
                                    `).join('')}
                                </select>
                            </td>
                            <td>
                                <input class="form-check-input user-activation" type="checkbox" value="1" ${user.is_active == 1 ? 'checked' : ''} data-id="${user.id}">
                            </td>
                            <td class="d-none d-xl-table-cell">${user.created_at}</td>
                            <td class="d-none d-xl-table-cell updated-at">${user.updated_at}</td>
                        </tr>
                    `;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    }

    const alert = document.querySelector('[role="alert"]');

    tableBody.addEventListener('change', function(event) {
        // Change Role
        if (event.target.classList.contains('role-select')) {
            const role_id = event.target.value;
            const id = event.target.dataset.id;

            const parentRow = event.target.closest('tr');
            const updated_at = parentRow.querySelector('.updated-at');

            const url = window.location.origin + '/admin/changeuserdata';

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        id: id,
                        role_id: role_id
                    })
                })
                .then(response => response.json())
                .then((data) => {
                    updated_at.innerHTML = data['updated_at'];
                    alert.style.display = 'block';
                    alert.innerHTML = 'User role has been changed';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 1200);
                })
        }

        // Change Activation
        if (event.target.classList.contains('user-activation')) {
            const is_active = event.target.checked ? 1 : 0;
            const id = event.target.dataset.id;

            const parentRow = event.target.closest('tr');
            const updated_at = parentRow.querySelector('.updated-at');

            const url = window.location.origin + '/admin/changeuserdata';

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        id: id,
                        is_active: is_active
                    })
                })
                .then(response => response.json())
                .then(data => {
                    updated_at.innerHTML = data['updated_at'];
                    alert.style.display = 'block';
                    alert.innerHTML = 'User activation has been changed';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 1200);
                })
        }

    });
</script>

<?= $this->endSection() ?>