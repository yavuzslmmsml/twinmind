<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">

        <!--begin::Card body-->
        <div class="card-body pt-0 bg-light">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_pending_courses_table">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                    data-kt-check-target="#kt_pending_courses_table .form-check-input" value="1" />
                            </div>
                        </th>
                        <th class="min-w-150px">Course Title</th>
                        <th class="min-w-150px">Instructor</th>
                        <th class="min-w-100px">Category</th>
                        <th class="min-w-125px">Submitted On</th>
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
                        <td>Intro to Python</td>
                        <td>John Doe</td>
                        <td>Programming</td>
                        <td>May 6, 2025</td>
                        <td class="text-end pe-4">
                            <!--begin::Dropdown-->
                            <div class="dropdown">
                                <button class="btn btn-light-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">View</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#">Delete</a>
                                    </li>
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
                        <td>Data Science Basics</td>
                        <td>Jane Smith</td>
                        <td>Data</td>
                        <td>May 5, 2025</td>
                        <td class="text-end pe-4">
                            <!--begin::Dropdown-->
                            <div class="dropdown">
                                <button class="btn btn-light-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">View</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#">Delete</a>
                                    </li>
                                </ul>
                            </div>
                            <!--end::Dropdown-->
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->

    </div>
    <!--end::Content container-->
</div>
