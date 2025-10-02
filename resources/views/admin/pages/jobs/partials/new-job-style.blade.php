<style>
    .new-job-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        margin-top: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #276515;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 10px;
    }

    .back-btn {
        background-color: #6b7280;
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        text-decoration: none;
        font-weight: 500;
        transition: 0.3s ease;
    }

    .back-btn:hover {
        background-color: #4b5563;
        color: white;
    }

    .form-section {
        background-color: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.75rem;
        transition: 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 0.2rem rgba(22, 163, 74, 0.25);
    }

    .btn-primary-custom {
        background-color: #276515;
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: 0.3s ease;
    }

    .btn-primary-custom:hover {
        background-color: #276515;
        color: white;
    }

    .btn-secondary-custom {
        background-color: #276515;
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background-color: #4b5563;
        color: white;
    }

    .btn-outline-custom {
        background-color: transparent;
        border: 1px solid #16a34a;
        color: #16a34a;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-custom:hover {
        background-color: #16a34a;
        color: white;
    }

    .icon-input {
        position: relative;
    }

    .icon-input i {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
    }

    .icon-input .form-control {
        padding-right: 3rem;
    }

    .toggle-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .toggle-btn {
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        background-color: white;
        color: #374151;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .toggle-btn.active {
        background-color: #276515;
        color: white;
        border-color: #276515;
    }

    .btn-custom{
        background-color: #ffffff;
        border: 1px solid #276515;
        color: #276515;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: 0.3s ease;
    }

    .product-item {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        position: relative;
    }

    .delete-item-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background-color: #ef4444;
        color: white;
        border: none;
        border-radius: 50%;
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .delete-item-btn:hover {
        background-color: #dc2626;
    }

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

    .fixed-bottom-bar {
        position: fixed;
        bottom: 0;
        left: 14.2rem;
        right: 0;
        background-color: white;
        border-top: 1px solid #e5e7eb;
        padding: .7rem 2rem;
        box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .total-summary {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-top: 1rem;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .total-row:last-child {
        font-weight: 600;
        border-top: 1px solid #e5e7eb;
        padding-top: 0.5rem;
        margin-top: 0.5rem;
    }
    .newjobs {
        padding-bottom: 8px;
        border-bottom: 1px solid #dadfe2;
        justify-content: space-between;
        align-items: center;
        display: flex;
        gap: 9rem;
    }
</style>