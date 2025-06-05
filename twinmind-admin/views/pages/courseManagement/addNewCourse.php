<div id="kt_app_content" class="app-content flex-column-fluid">
  <!--begin::Content container-->
  <div id="kt_app_content_container" class="app-container container-xxl">
    <div class="container mt-5 mb-5">
      <h3 class="mb-4">Add New Course</h3>
      <form method="POST" enctype="multipart/form-data" id="add-course-form">
        <div class="row">
          <!-- Title -->
          <div class="col-md-12 mb-3">
            <label class="form-label">Course Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>

          <!-- Description -->
          <div class="col-md-12 mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
          </div>

          <!-- Category Selector (with modal) -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Categories</label><br>
            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
              data-bs-target="#categoryModal">
              Select Categories
            </button>
            <div id="selectedCategoriesDisplay" class="mt-2 text-muted"></div>
            <!-- Hidden input for selected categories -->
            <div id="selectedCategoriesInputs"></div>
          </div>

          <!-- Instructor -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Instructor</label>
            <p class="text-uppercase"><?= $_SESSION["user"]["name"] ?></p>
            <input type="hidden" name="instructer" class="form-control"
              value="<?= $_SESSION["user"]["user_id"] ?>">
          </div>

          <!-- Price -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Price ($)</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
          </div>

          <!-- Thumbnail -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Course Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control" accept="image/*" required>
          </div>

          <!-- Sections & Lessons -->
          <div class="col-md-12 mb-4">
            <label class="form-label">Course Structure</label>
            <div id="sectionsContainer">
              <div class="card border p-3 mb-3">
                <div class="mb-3">
                  <input type="text" name="sections[0][title]" class="form-control"
                    placeholder="Section Title">
                </div>
                <div class="lessonsContainer">
                  <div class="border rounded p-2 mb-2">
                    <input type="text" name="sections[0][lessons][0][title]"
                      class="form-control mb-2" placeholder="Lesson Title">
                    <input type="file" name="sections[0][lessons][0][video]" class="form-control"
                      accept="video/mp4" required>
                  </div>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm mt-2"
                  onclick="addLesson(this, 0)">+ Add Lesson</button>
              </div>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-3" onclick="addSection()">+ Add
              Another Section</button>
          </div>

          <!-- Status -->
          <div class="col-md-6 mb-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
              <option value="draft">Draft</option>
              <option value="published">Published</option>
            </select>
          </div>

          <!-- Submit -->
          <div class="col-12 text-end">
            <button type="button" class="btn btn-primary" id="kt_add_course_btn"
              onclick="App.SubmitAddCourseForm();">Create Course</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Category Selection Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Select Categories</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body"><?= $Categories; ?>
            <!-- Category List -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="applyCategories()"
              data-bs-dismiss="modal">Apply</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script>
      let sectionIndex = 1;

      function addSection() {
        const container = document.getElementById('sectionsContainer');
        const card = document.createElement('div');
        card.className = 'card border p-3 mb-3';
        card.innerHTML = `
    <div class="mb-3">
      <input type="text" name="sections[${sectionIndex}][title]" class="form-control" placeholder="Section Title">
    </div>
    <div class="lessonsContainer">
      <div class="border rounded p-2 mb-2">
        <input type="text" name="sections[${sectionIndex}][lessons][0][title]" class="form-control mb-2" placeholder="Lesson Title">
        <input type="file" name="sections[${sectionIndex}][lessons][0][video]" class="form-control" accept="video/mp4" required>
      </div>
    </div>
    <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addLesson(this, ${sectionIndex})">+ Add Lesson</button>
  `;
        container.appendChild(card);
        sectionIndex++;
      }

      function addLesson(button, sectionIdx) {
        const lessonsContainer = button.parentElement.querySelector('.lessonsContainer');
        const lessonCount = lessonsContainer.children.length;
        const lessonDiv = document.createElement('div');
        lessonDiv.className = 'border rounded p-2 mb-2';
        lessonDiv.innerHTML = `
    <input type="text" name="sections[${sectionIdx}][lessons][${lessonCount}][title]" class="form-control mb-2" placeholder="Lesson Title">
    <input type="file" name="sections[${sectionIdx}][lessons][${lessonCount}][video]" class="form-control" accept="video/mp4" required>
    <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeLesson(this)">Remove Lesson</button>
  `;
        lessonsContainer.appendChild(lessonDiv);
      }

      function removeLesson(button) {
        button.parentElement.remove();
      }

      function applyCategories() {
        const checked = document.querySelectorAll('#categoryModal input[type="checkbox"]:checked');
        const selectedDisplay = document.getElementById('selectedCategoriesDisplay');
        const hiddenInputs = document.getElementById('selectedCategoriesInputs');

        selectedDisplay.innerHTML = '';
        hiddenInputs.innerHTML = '';

        checked.forEach((item) => {
          const cat = item.value;
          selectedDisplay.innerHTML += `
      <span class="badge bg-secondary me-1 mb-1">
        ${cat}
        <button type="button" class="btn-close btn-close-black ms-1" style="font-size: 0.5rem;" 
          onclick="removeCategory('${cat}')" aria-label="Remove"></button>
      </span>`;
          hiddenInputs.innerHTML += `<input type="hidden" name="categories[]" value="${cat}">`;
        });
      }

      function removeCategory(category) {
        // Uncheck the checkbox in the modal
        const checkbox = document.querySelector(`#categoryModal input[value="${category}"]`);
        if (checkbox) {
          checkbox.checked = false;
        }

        // Remove the category from display and hidden inputs
        const selectedDisplay = document.getElementById('selectedCategoriesDisplay');
        const hiddenInputs = document.getElementById('selectedCategoriesInputs');

        // Remove the hidden input
        const hiddenInput = hiddenInputs.querySelector(`input[value="${category}"]`);
        if (hiddenInput) {
          hiddenInput.remove();
        }

        // Remove the badge
        const badges = selectedDisplay.querySelectorAll('.badge');
        badges.forEach(badge => {
          if (badge.textContent.trim().startsWith(category)) {
            badge.remove();
          }
        });
      }

      // Prevent form submission on file input change
      document.addEventListener('DOMContentLoaded', function() {
        const fileInputs = document.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
          input.addEventListener('change', function(e) {
            e.preventDefault();
            // You can add file validation or preview logic here if needed
          });
        });
      });
    </script>

  </div>
  <!--end::Content container-->
</div>