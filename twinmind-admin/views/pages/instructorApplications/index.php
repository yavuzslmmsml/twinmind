<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h2 class="fw-bold">Review Instructor Applications</h2>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <input type="text" class="form-control form-control-solid w-250px" placeholder="Search Instructor..." />
                    </div>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0 bg-light">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_instructor_applications_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                        data-kt-check-target="#kt_instructor_applications_table .form-check-input" value="1" />
                                </div>
                            </th>
                            <th class="min-w-150px">Full Name</th>
                            <th class="min-w-150px">Email</th>
                            <th class="min-w-125px">Applied On</th>
                            <th class="min-w-200px">Motivation</th>
                            <th class="text-end min-w-100px pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-700">
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </td>
                            <td>Emily Johnson</td>
                            <td>emily.johnson@example.com</td>
                            <td>May 6, 2025</td>
                            <td>I want to share my 10 years of teaching experience in data science.</td>
                            <td class="text-end pe-4">
                                <!--begin::Dropdown-->
                                <div class="dropdown">
                                    <button class="btn btn-light-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">View</a></li>
                                        <li><a class="dropdown-item text-success" href="#">Approve</a></li>
                                        <li><a class="dropdown-item text-danger" href="#">Reject</a></li>
                                    </ul>
                                </div>
                                <!--end::Dropdown-->
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="2" />
                                </div>
                            </td>
                            <td>Michael Lee</td>
                            <td>michael.lee@example.com</td>
                            <td>May 5, 2025</td>
                            <td>I specialize in front-end development and want to create React courses.</td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-light-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">View</a></li>
                                        <li><a class="dropdown-item text-success" href="#">Approve</a></li>
                                        <li><a class="dropdown-item text-danger" href="#">Reject</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content container-->
</div>
