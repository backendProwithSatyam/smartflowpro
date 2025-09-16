<style>
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e0e0e0;
        font-weight: 600;
        color: #495057;
    }

    .hoverable-section {
        position: relative;
        transition: all 0.3s ease;
        min-height: 100px;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 20px;
        cursor: pointer;
    }

    .hoverable-section:hover {
        border-color: #16a34a;
        background-color: #f0fdf4;
    }

    .hoverable-section .add-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 48px;
        color: #16a34a;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .hoverable-section:hover .add-icon {
        opacity: 0.7;
    }

    .hoverable-section .content {
        transition: opacity 0.3s ease;
    }

    .hoverable-section:hover .content {
        opacity: 0.3;
    }

    .bottom-bar {
        position: fixed;
        bottom: 0;
        left: 14.2rem;
        right: 0;
        background: white;
        border-top: 1px solid #e0e0e0;
        padding: 15px;
        z-index: 1050;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    }

    .file-item {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 8px 12px;
        margin: 5px;
        display: inline-flex;
        align-items: center;
        font-size: 14px;
    }

    .file-item .remove-file {
        margin-left: 8px;
        cursor: pointer;
        color: #dc3545;
    }

    .content-with-data {
        background-color: #e8f4fd;
        border: 2px solid #007bff;
    }

    .schedule-disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    .inline-form {
        display: none;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-top: 15px;
        background-color: #fff;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
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