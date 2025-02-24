// Deklarasi variabel global
const maxRowsSelect = document.getElementById('max-rows');
const searchForm = document.getElementById('search-form');
const tableBody = document.querySelector('#user-table tbody');

let maxRows = maxRowsSelect.value;
let keyword = document.getElementById('keyword-input').value;

searchForm.addEventListener('submit', function (event) {
    event.preventDefault();
    maxRows = maxRowsSelect.value;
    keyword = document.getElementById('keyword-input').value;

    const url = window.location.origin + `/admin/usermanagement?keyword=${keyword}&maxrows=${maxRows}`;
    fetchUsers(url);
});

// Max Rows
maxRowsSelect.addEventListener('change', function () {
    maxRows = this.value;
    keyword = document.getElementById('keyword-input').value;
    const url = window.location.origin + `/admin/usermanagement?keyword=${keyword}&maxrows=${maxRows}`;

    fetchUsers(url);
});

// Pagination Links
const paginationContainer = document.getElementById('pagination-container');

paginationContainer.addEventListener('click', function (event) {
    event.preventDefault();

    let target = event.target;
    if (target.tagName === 'SPAN') {
        target = target.parentElement;
    }

    if (target.tagName === 'A') {
        const url = target.href + `&keyword=${keyword}&maxrows=${maxRows}`;
        fetchUsers(url);
    }
});

const alert = document.querySelector('[role="alert"]');

tableBody.addEventListener('change', function (event) {
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
                showAlert('User role has been changed');
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
                showAlert('User activation has been changed');
            })
    }

});

function showAlert(message) {
    alert.style.display = 'block';
    alert.innerHTML = message;
    setTimeout(() => {
        alert.style.display = 'none';
    }, 1200);
}

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

            // Perbarui pagination link setelah data baru dimuat
            const paginationElement = document.querySelector('.pagination');
            paginationElement.innerHTML = data.pager;
        })
}

function getRows(data, tableBody) {
    tableBody.innerHTML = '';
    let i = (data.currentPage - 1) * data.maxRows + 1;
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