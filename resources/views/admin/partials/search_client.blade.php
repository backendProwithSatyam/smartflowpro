<label for="client" class="form-label">Clients</label>
<div class="dropdown-search">
    <input type="hidden" id="client_id" name="client_id" value="{{ old('client_id', $job->client_id ?? '') }}">
    <input type="text" class="form-control" id="client" name="client"
        placeholder="Search or select lead source..." autocomplete="off" data-bs-toggle="dropdown"
        aria-expanded="false">
    <ul class="dropdown-menu" id="clientDropdown">
        @foreach ($clients as $client)
            <li><a class="dropdown-item" href="#" data-value="{{ $client->id }}">{{ $client->title }} {{ $client->first_name }} {{ $client->last_name }}</a></li>
        @endforeach
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
            const clientInput = document.getElementById('client');
            const dropdown = document.getElementById('clientDropdown');
            const dropdownItems = dropdown.querySelectorAll('.dropdown-item');
            const originalItems = Array.from(dropdownItems).map(item => ({
                element: item,
                text: item.textContent.toLowerCase(),
                value: item.dataset.value
            }));
            clientInput.addEventListener('focus', function () {
                showDropdown();
            });
            clientInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                filterDropdownItems(searchTerm);
                showDropdown();
            });
            dropdownItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    clientInput.value = this.textContent;
                    const hiddenInput = document.getElementById('client_id');
                    if (hiddenInput) {
                        hiddenInput.value = this.dataset.value;
                    }
                    hideDropdown();
                });
            });
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.dropdown-search')) {
                    hideDropdown();
                }
            });
            function showDropdown() {
                const bootstrapDropdown = new bootstrap.Dropdown(clientInput);
                dropdown.classList.add('show');
                clientInput.setAttribute('aria-expanded', 'true');
            }
            function hideDropdown() {
                dropdown.classList.remove('show');
                clientInput.setAttribute('aria-expanded', 'false');
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