<label for="leadSource" class="form-label">Lead source</label>
<div class="dropdown-search">
    <input type="text" class="form-control" id="leadSource" name="leadSource"
        placeholder="Search or select lead source..." autocomplete="off" data-bs-toggle="dropdown"
        aria-expanded="false">
    <ul class="dropdown-menu" id="leadSourceDropdown">
        <li><a class="dropdown-item" href="#" data-value="linkedin">LinkedIn</a></li>
        <li><a class="dropdown-item" href="#" data-value="instagram">Instagram</a></li>
        <li><a class="dropdown-item" href="#" data-value="flyer">Flyer</a></li>
        <li><a class="dropdown-item" href="#" data-value="google">Google</a></li>
        <li><a class="dropdown-item" href="#" data-value="other">Other</a></li>
        <li><a class="dropdown-item" href="#" data-value="wrap">Wrap</a></li>
        <li><a class="dropdown-item" href="#" data-value="vehicle wrap">Vehicle Wrap</a>
        </li>
    </ul>
</div>

@push('styles')
    <style>
        .dropdown-search {
            position: relative;
        }

        .dropdown-search .form-control {
            cursor: pointer;
        }

        .dropdown-search .dropdown-menu {
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
        }

        .dropdown-item.active {
            background-color: #0d6efd;
            color: white;
        }

        .dropdown-item:hover {
            background-color: #e9ecef;
        }

        .dropdown-item.active:hover {
            background-color: #0b5ed7;
        }

        .no-results {
            padding: 0.5rem 1rem;
            color: #6c757d;
            font-style: italic;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const leadSourceInput = document.getElementById('leadSource');
            const dropdown = document.getElementById('leadSourceDropdown');
            const dropdownItems = dropdown.querySelectorAll('.dropdown-item');
            const originalItems = Array.from(dropdownItems).map(item => ({
                element: item,
                text: item.textContent.toLowerCase(),
                value: item.dataset.value
            }));
            leadSourceInput.addEventListener('focus', function () {
                showDropdown();
            });
            leadSourceInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                filterDropdownItems(searchTerm);
                showDropdown();
            });
            dropdownItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    leadSourceInput.value = this.textContent;
                    hideDropdown();
                });
            });
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.dropdown-search')) {
                    hideDropdown();
                }
            });
            function showDropdown() {
                const bootstrapDropdown = new bootstrap.Dropdown(leadSourceInput);
                dropdown.classList.add('show');
                leadSourceInput.setAttribute('aria-expanded', 'true');
            }
            function hideDropdown() {
                dropdown.classList.remove('show');
                leadSourceInput.setAttribute('aria-expanded', 'false');
            }
            function filterDropdownItems(searchTerm) {
                let hasVisibleItems = false;
                originalItems.forEach(item => {
                    if (item.text.includes(searchTerm)) {
                        item.element.style.display = 'block';
                        hasVisibleItems = true;
                    } else {
                        item.element.style.display = 'none';
                    }
                });
                let noResultsItem = dropdown.querySelector('.no-results');
                if (!hasVisibleItems && searchTerm) {
                    if (!noResultsItem) {
                        noResultsItem = document.createElement('li');
                        noResultsItem.innerHTML = '<span class="no-results">No results found</span>';
                        dropdown.appendChild(noResultsItem);
                    }
                    noResultsItem.style.display = 'block';
                } else if (noResultsItem) {
                    noResultsItem.style.display = 'none';
                }
            }
        });
    </script>
@endpush