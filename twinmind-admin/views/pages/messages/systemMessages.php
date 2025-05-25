<div class="app-content flex-column-fluid" id="kt_app_content">
    <div class="app-container container-xxl" id="kt_app_content_container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">System-Wide Notifications</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#notificationModal">
                    <i class="ki-duotone ki-plus fs-2"></i> New Notification
                </button>
            </div>

            <div class="card-body">
                <!-- Search and Filter -->
                <div class="d-flex mb-4 gap-3">
                    <input type="text" class="form-control w-250px" id="searchInput"
                        placeholder="Search notifications..." />
                    <select id="filterRole" class="form-select w-200px">
                        <option value="">All Roles</option>
                        <option value="superuser">Superuser</option>
                        <option value="instructor">Instructor</option>
                        <option value="student">Student</option>
                    </select>
                </div>

                <!-- Notification Table -->
                <table class="table table-bordered align-middle" id="notificationsTable">
                    <thead>
                        <tr class="fw-bold text-muted">
                            <th>#</th>
                            <th>Recipient</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Sent At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="notificationsBody">
                        <?php

                        $Messages = mysqli_fetch_all($Result, MYSQLI_ASSOC);
                        global $conn;
                        foreach ($Messages as $MessageDetails) {

                            $sql = "SELECT role_name FROM roles WHERE role_id = '" . $MessageDetails["recipient_role"] . "'";
                            $result = mysqli_query($conn, $sql);

                            $row = mysqli_fetch_assoc($result);
                        ?>
                            <tr>

                                <td>
                                    <a href="apps/ecommerce/customers/details.html"
                                        class="text-gray-800 text-hover-primary mb-1"><?= $MessageDetails["id"] ?> </a>
                                </td>
                                <?php
                                if ($MessageDetails["recipient_role"] == 0) {
                                ?>
                                    <td>
                                        <!--begin::Badges-->
                                        <div class="badge badge-light-danger">All Role</div>
                                        <!--end::Badges-->
                                    </td>
                                <?php
                                } else {


                                    $sql = "SELECT role_name FROM roles WHERE role_id = '" . $MessageDetails["recipient_role"] . "'";
                                    $result = mysqli_query($conn, $sql);

                                    $row = mysqli_fetch_assoc($result);
                                    echo json_encode($row);
                                ?>
                                    <td>
                                        <!--begin::Badges-->
                                        <div class="badge badge-light-danger"><?= $row["role_name"] ?></div>
                                        <!--end::Badges-->
                                    </td>
                                <?php } ?>
                                <td>
                                    <a href="#"
                                        class="text-gray-600 text-hover-primary mb-1"><?= $MessageDetails["title"] ?></a>
                                </td>
                                <td>
                                    <!--begin::Badges-->
                                    <div class="badge badge-light-danger"><?= $MessageDetails["message"] ?></div>
                                    <!--end::Badges-->
                                </td>

                                <td><?= $MessageDetails["sent_at"] ?></td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="apps/customers/view.html" class="menu-link px-3">View</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <button type="button" class="delete-system-message-btn"
                                                data-system-message-id="<?= $MessageDetails['id'] ?>"
                                                onclick="Delete.DeleteSystemMessage(<?= $MessageDetails['id'] ?>)">Delete</button>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                            </tr>
                        <?php

                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal: Create/Edit Notification -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="notificationForm">
                    <input type="hidden" name="id" id="notification_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Send Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Recipient Role</label>
                            <select class="form-select" name="recipient_role" id="recipient_role" required>
                                <option value="0">All Users</option>
                                <option value="1">Superuser</option>
                                <option value="2">Admin</option>
                                <option value="3">Instructor</option>
                                <option value="4">Member</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" id="message" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="AddMessage.SubmitAddMessageForm();">
                            <i class="ki-duotone ki-send fs-2 me-1"></i><span id="submitText">Send</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let editing = false;

    function loadNotifications() {
        fetch('get_notifications.php')
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById("notificationsBody");
                tbody.innerHTML = '';
                data.forEach((item, index) => {
                    const row = `
          <tr data-role="${item.recipient_role}">
            <td>${index + 1}</td>
            <td>${item.title}</td>
            <td>${item.message}</td>
            <td>${item.recipient_role === 'all' ? 'All Users' : item.recipient_role}</td>
            <td>${item.sent_at}</td>
            <td>
              <button class="btn btn-sm btn-warning me-1" onclick='editNotification(${JSON.stringify(item)})'>
                <i class="ki-duotone ki-pencil"></i>
              </button>
              <button class="btn btn-sm btn-danger" onclick='deleteNotification(${item.id})'>
                <i class="ki-duotone ki-trash"></i>
              </button>
            </td>
          </tr>`;
                    tbody.insertAdjacentHTML('beforeend', row);
                });
            });
    }

    document.getElementById("searchInput").addEventListener("keyup", () => {
        const filter = event.target.value.toLowerCase();
        document.querySelectorAll("#notificationsTable tbody tr").forEach(row => {
            row.style.display = [...row.children].some(td => td.textContent.toLowerCase().includes(
                filter)) ? "" : "none";
        });
    });
    document.getElementById("filterRole").addEventListener("change", () => {
        const role = event.target.value;
        document.querySelectorAll("#notificationsTable tbody tr").forEach(row => {
            row.style.display = role === "" || row.dataset.role === role ? "" : "none";
        });
    });

    function editNotification(item) {
        document.getElementById("notification_id").value = item.id;
        document.getElementById("title").value = item.title;
        document.getElementById("message").value = item.message;
        document.getElementById("recipient_role").value = item.recipient_role;
        document.getElementById("submitText").innerText = "Update";
        document.getElementById("modalTitle").innerText = "Update Notification";
        editing = true;
        new bootstrap.Modal(document.getElementById('notificationModal')).show();
    }

    function deleteNotification(id) {
        if (!confirm("Delete this notification?")) return;
        fetch('delete_notification.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + id
        }).then(res => res.text()).then(() => loadNotifications());
    }

    document.getElementById("notificationForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        const url = editing ? 'update_notification.php' : 'send_notification_process.php';

        fetch(url, {
            method: 'POST',
            body: new URLSearchParams(formData)
        }).then(res => res.text()).then(() => {
            e.target.reset();
            editing = false;
            document.getElementById("submitText").innerText = "Send";
            document.getElementById("modalTitle").innerText = "Send Notification";
            bootstrap.Modal.getInstance(document.getElementById('notificationModal')).hide();
            loadNotifications();
        });
    });

    document.addEventListener("DOMContentLoaded", loadNotifications);
</script>