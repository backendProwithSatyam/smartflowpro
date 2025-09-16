@push('styles')
<style>
    
    .notes-area {
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        min-height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .notes-area:hover {
        border-color: #16a34a;
        background-color: #f0fdf4;
    }

    .notes-area:hover .add-note-icon {
        opacity: 1;
    }

    .add-note-icon {
        opacity: 0;
        transition: opacity 0.3s ease;
        font-size: 2rem;
        color: #16a34a;
    }

    .notes-form {
        display: none;
    }

    .notes-form.active {
        display: block;
    }

    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        padding: 1rem;
        text-align: center;
        margin-top: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-upload-area:hover {
        border-color: #16a34a;
        background-color: #f0fdf4;
    }
</style>
@endpush
<div class="form-section">
    <h3 class="section-title">Notes</h3>
    <div class="notes-area" onclick="showNotesForm()">
        <div class="add-note-icon">
            <i class="fas fa-plus"></i>
        </div>
    </div>
    <div class="notes-form" id="notesForm">
        <textarea class="form-control" id="notes" name="notes" rows="4"
            placeholder="Leave an internal note for yourself or a team member"></textarea>
        <div class="file-upload-area" onclick="document.getElementById('fileUpload').click()">
            <i class="fas fa-paperclip me-2"></i>
            Attach files or photos
            <input type="file" id="fileUpload" name="attachments[]" multiple accept="image/*,.pdf,.doc,.docx"
                style="display: none;">
        </div>
        <div id="fileList" class="mt-2"></div>
    </div>
</div>
@push('scripts')
    <script>
        function showNotesForm() {
            const notesForm = document.getElementById('notesForm');
            const notesArea = document.querySelector('.notes-area');

            notesForm.classList.add('active');
            notesArea.style.display = 'none';
        }

        // File upload handling
        document.getElementById('fileUpload').addEventListener('change', function (e) {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = '';

            Array.from(e.target.files).forEach(file => {
                const fileItem = document.createElement('div');
                fileItem.className = 'd-flex align-items-center justify-content-between p-2 border rounded mb-2';
                fileItem.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file me-2"></i>
                            <span>${file.name}</span>
                            <small class="text-muted ms-2">(${(file.size / 1024).toFixed(1)} KB)</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                fileList.appendChild(fileItem);
            });
        });

        // Remove file function
        function removeFile(button) {
            button.parentElement.remove();
        }
    </script>
@endpush