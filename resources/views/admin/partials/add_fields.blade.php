<form id="dynamicForm">
  @csrf
  <div id="fieldWrapper">
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="transferable" id="transferableField">
      <label class="form-check-label" for="transferableField">
        Transferable field <br>
        <small class="text-muted">
          Transferable custom fields allow your data to appear in multiple places and follow you through your workflow
        </small>
      </label>
    </div>
    <input type="hidden" name="page_value" id="pageValue">
    <div class="mb-2 fieldGroup">
      <div class="mb-3">
        <input type="text" name="labelName[]" class="form-control" placeholder="Label Name">
      </div>
      <div class="mb-3">
        <select name="fieldType[]" id="fieldTypemain" class="form-control fieldType">
          <option value="text">Text</option>
          <option value="number">Number</option>
          <option value="select">Select</option>
          <option value="checkbox">Checkbox</option>
          <option value="radio">Radio</option>
        </select>
      </div>
      <div class="mb-3 optionsBox" style="display:none;">
        <input type="text" name="options[]" class="form-control" placeholder="Options (comma separated)">
      </div>
      <div id="exampleBox" class="mb-3 small">
        Example <br>
        Serial Number <span class="badge bg-light text-dark">54A17-HEX</span>
      </div>

      <!-- Default Value -->
      <div class="mb-3">
        <input type="text" name="defaultValue" class="form-control" placeholder="Default value">
      </div>
      {{-- <div class="col-md-2">
        <button type="button" class="btn btn-success addBtn">+</button>
      </div> --}}
    </div>
  </div>
  {{-- <button type="submit" class="btn btn-primary mt-3">Save</button> --}}
</form>

<div id="responseMsg" class="mt-3"></div>




<script>
  document.addEventListener("DOMContentLoaded", function () {
    const fieldType = document.getElementById("fieldTypemain");
    const exampleBox = document.getElementById("exampleBox");
    const examples = {
      text: 'Serial Number <span class="badge bg-light text-dark">54A17-HEX</span>',
      number: 'Invoice No <span class="badge bg-light text-dark">12345</span>',
      select: 'Choose: <span class="badge bg-light text-dark">Option1, Option2</span>',
      checkbox: '<span class="badge bg-light text-dark">✓ Agree to Terms</span>',
      radio: '<span class="badge bg-light text-dark">○ Male &nbsp;&nbsp; ○ Female</span>'
    };
    fieldType.addEventListener("change", function () {
      const selected = this.value;
      exampleBox.innerHTML = "Example <br>" + (examples[selected] || "");
    });
    let fieldWrapper = document.getElementById("fieldWrapper");

    // 1️⃣ Add / Remove Field Groups
    fieldWrapper.addEventListener("click", function (e) {
      // Add button
      if (e.target.classList.contains("addBtn")) {
        let fieldGroup = e.target.closest(".fieldGroup");
        let newFieldGroup = fieldGroup.cloneNode(true);

        // Reset input values
        newFieldGroup.querySelectorAll("input").forEach(input => input.value = "");
        newFieldGroup.querySelectorAll("select").forEach(select => select.value = "text");
        newFieldGroup.querySelector(".optionsBox").style.display = "none";

        // Change + to - button
        let btn = newFieldGroup.querySelector(".addBtn");
        btn.classList.remove("btn-success", "addBtn");
        btn.classList.add("btn-danger", "removeBtn");
        btn.textContent = "-";

        fieldWrapper.appendChild(newFieldGroup);
      }

      // Remove button
      if (e.target.classList.contains("removeBtn")) {
        e.target.closest(".fieldGroup").remove();
      }
    });

    // 2️⃣ Show/Hide options input based on field type
    fieldWrapper.addEventListener("change", function (e) {
      if (e.target.classList.contains("fieldType")) {
        let optionsBox = e.target.closest(".fieldGroup").querySelector(".optionsBox");
        if (["select", "checkbox", "radio"].includes(e.target.value)) {
          optionsBox.style.display = "block";
        } else {
          optionsBox.style.display = "none";
        }
      }
    });

    // 3️⃣ Ajax Form Submit
    document.getElementById("dynamicForm").addEventListener("submit", function (e) {
      e.preventDefault();

      let formData = new FormData(this);

      fetch("{{ route('form-fields.store') }}", {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        },
        body: formData
      })
        .then(res => {
          if (!res.ok) throw new Error("Network response was not ok");
          return res.json();
        })
        .then(data => {
          if (data.status) {
            document.getElementById("responseMsg").innerHTML =
              `<div class="alert alert-success">${data.message}</div>`;
            this.reset();
            // Hide all optionsBox after reset
            fieldWrapper.querySelectorAll(".optionsBox").forEach(box => box.style.display = "none");
            setTimeout(() => {
              location.reload();
            }, 1000);
          } else {
            document.getElementById("responseMsg").innerHTML =
              `<div class="alert alert-danger">Something went wrong!</div>`;
          }
        })
        .catch(err => {
          document.getElementById("responseMsg").innerHTML =
            `<div class="alert alert-danger">Error: ${err.message}</div>`;
        });
    });
    document.querySelectorAll(".openModalBtn").forEach(btn => {
      btn.addEventListener("click", function () {
        let value = this.getAttribute("data-page-value");
        document.getElementById("pageValue").value = value;
      });
    });
  });
</script>