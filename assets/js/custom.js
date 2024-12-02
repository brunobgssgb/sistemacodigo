// Real-time customer registration
function registerCustomer() {
    const form = document.getElementById('customerForm');
    const formData = new FormData(form);

    fetch('api/customers/create.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: 'Customer registered successfully',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            form.reset();
            updateCustomerTable();
            $('#kt_modal_add_customer').modal('hide');
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function updateCustomerTable() {
    fetch('api/customers/read.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#customerTable tbody');
            if (tbody) {
                tbody.innerHTML = '';
                data.forEach(customer => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${customer.id}</td>
                            <td>${customer.name}</td>
                            <td>${customer.email}</td>
                            <td>${customer.phone}</td>
                            <td>
                                <button class="btn btn-sm btn-light-primary" onclick="editCustomer(${customer.id})">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-light-danger" onclick="deleteCustomer(${customer.id})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
        });
}

// Real-time app registration
function registerApp() {
    const form = document.getElementById('appForm');
    const formData = new FormData(form);

    fetch('api/apps/create.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: 'App registered successfully',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            form.reset();
            updateAppTable();
            $('#kt_modal_add_app').modal('hide');
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function updateAppTable() {
    fetch('api/apps/read.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#appTable tbody');
            if (tbody) {
                tbody.innerHTML = '';
                data.forEach(app => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${app.id}</td>
                            <td>${app.name}</td>
                            <td>$${parseFloat(app.price).toFixed(2)}</td>
                            <td>
                                <button class="btn btn-sm btn-light-primary" onclick="editApp(${app.id})">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-light-danger" onclick="deleteApp(${app.id})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
        });
}

// Real-time recharge code registration
function registerCode() {
    const form = document.getElementById('codeForm');
    const formData = new FormData(form);

    fetch('api/codes/create.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: 'Recharge code created successfully',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            form.reset();
            updateCodeTable();
            $('#kt_modal_add_code').modal('hide');
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function updateCodeTable() {
    fetch('api/codes/read.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#codeTable tbody');
            if (tbody) {
                tbody.innerHTML = '';
                data.forEach(code => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${code.id}</td>
                            <td>${code.app_name}</td>
                            <td>${code.code}</td>
                            <td>
                                <span class="badge badge-light-${code.is_used ? 'danger' : 'success'}">
                                    ${code.is_used ? 'Used' : 'Available'}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-light-danger" onclick="deleteCode(${code.id})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
        });
}

// Real-time order creation
function createOrder() {
    const form = document.getElementById('orderForm');
    const formData = new FormData(form);

    fetch('api/orders/create.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: 'Order created successfully',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            form.reset();
            updateOrderTable();
            $('#kt_modal_add_order').modal('hide');
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function updateOrderTable() {
    fetch('api/orders/read.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#orderTable tbody');
            if (tbody) {
                tbody.innerHTML = '';
                data.forEach(order => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${order.id}</td>
                            <td>${order.customer_name}</td>
                            <td>${order.app_name}</td>
                            <td>${order.code}</td>
                            <td>${order.order_date}</td>
                            <td>
                                <button class="btn btn-sm btn-light-primary" onclick="viewOrder(${order.id})">
                                    View
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
        });
}

// Load customers into select dropdown
function loadCustomers() {
    fetch('api/customers/read.php')
        .then(response => response.json())
        .then(data => {
            const select = document.querySelector('select[name="customer_id"]');
            if (select) {
                data.forEach(customer => {
                    const option = document.createElement('option');
                    option.value = customer.id;
                    option.textContent = customer.name;
                    select.appendChild(option);
                });
            }
        });
}

// Load apps into select dropdown
function loadApps() {
    fetch('api/apps/read.php')
        .then(response => response.json())
        .then(data => {
            const select = document.querySelector('select[name="app_id"]');
            if (select) {
                data.forEach(app => {
                    const option = document.createElement('option');
                    option.value = app.id;
                    option.textContent = `${app.name} - $${parseFloat(app.price).toFixed(2)}`;
                    select.appendChild(option);
                });
            }
        });
}

// Load available codes for selected app
function loadAvailableCodes(appId) {
    if (!appId) return;

    fetch(`api/codes/available.php?app_id=${appId}`)
        .then(response => response.json())
        .then(data => {
            const select = document.querySelector('select[name="code_id"]');
            select.innerHTML = '<option value="">Select Code</option>';
            data.forEach(code => {
                const option = document.createElement('option');
                option.value = code.id;
                option.textContent = code.code;
                select.appendChild(option);
            });
        });
}

// Initialize tables and forms when available
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('customerTable')) {
        updateCustomerTable();
    }
    if (document.getElementById('appTable')) {
        updateAppTable();
    }
    if (document.getElementById('codeTable')) {
        updateCodeTable();
        loadApps();
    }
    if (document.getElementById('orderTable')) {
        updateOrderTable();
        loadCustomers();
        loadApps();
    }
});