<!--begin::Card-->
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h2 class="fw-bold">Add Category (Hierarchical)</h2>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0">
        <form id="kt_add_category_form">
            
            <!--begin::Category Level-->
            <div class="mb-7">
                <label class="required fw-semibold fs-6 mb-2">Category Level</label>
                <select class="form-select form-select-solid" name="category_level" id="category_level">
                    <option value="main">Main Category</option>
                    <option value="sub">Subcategory</option>
                    <option value="subsub">Sub-Subcategory</option>
                </select>
            </div>

            <!--begin::Parent Selector (conditionally shown)-->
            <div class="mb-7 d-none" id="parent_main_category_wrapper">
                <label class="fw-semibold fs-6 mb-2">Select Parent Category</label>
                <select class="form-select form-select-solid" name="parent_main_category">
                    <option value="">Select Main Category</option>
                    <option value="1">Software</option>
                    <option value="2">Music</option>
                </select>
            </div>

            <div class="mb-7 d-none" id="parent_sub_category_wrapper">
                <label class="fw-semibold fs-6 mb-2">Select Subcategory</label>
                <select class="form-select form-select-solid" name="parent_sub_category">
                    <option value="">Select Subcategory</option>
                    <option value="3">Web (under Software)</option>
                    <option value="4">Guitar (under Music)</option>
                </select>
            </div>

            <!--begin::New Category Name-->
            <div class="mb-7">
                <label class="required fw-semibold fs-6 mb-2">Category Name</label>
                <input type="text" class="form-control form-control-solid" name="category_name" placeholder="e.g. PHP or Piano" />
            </div>

            <!--begin::Slug (optional)-->
            <div class="mb-7">
                <label class="fw-semibold fs-6 mb-2">Slug</label>
                <input type="text" class="form-control form-control-solid" name="slug" placeholder="e.g. php or piano" />
            </div>

            <!--begin::Submit-->
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Save Category</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            <!--end::Submit-->
        </form>
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

<script>
    // Show/hide parent selectors based on level
    document.getElementById('category_level').addEventListener('change', function () {
        const level = this.value;
        document.getElementById('parent_main_category_wrapper').classList.add('d-none');
        document.getElementById('parent_sub_category_wrapper').classList.add('d-none');

        if (level === 'sub') {
            document.getElementById('parent_main_category_wrapper').classList.remove('d-none');
        } else if (level === 'subsub') {
            document.getElementById('parent_sub_category_wrapper').classList.remove('d-none');
        }
    });
</script>
