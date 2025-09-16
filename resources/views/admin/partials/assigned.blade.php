@push('styles')
    <style>
        .assigned-user {
            background-color: #e9ecef;
            border-radius: 20px;
            padding: 8px 15px;
            display: inline-flex;
            align-items: center;
            font-size: 14px;
        }

        .assign-btn {
            background-color: transparent;
            border: 2px dashed #16a34a;
            border-radius: 20px;
            padding: 8px 15px;
            display: inline-flex;
            align-items: center;
            font-size: 14px;
            color: #6c757d;
            cursor: pointer;
        }

        .assign-btn:hover {
            border-color: #16a34a;
            color: #16a34a;
        }
    </style>
@endpush
<label class="form-label">Assign to</label>
<div class="d-flex align-items-center">
    <div id="assignedUser" class="assigned-user me-2" style="display: none;">
        <i class="bi bi-person-circle me-1"></i>
        <span id="assignedUserName">John Doe</span>
        <i class="bi bi-x ms-2" onclick="removeAssignment()" style="cursor: pointer;"></i>
    </div>
    <div id="assignButton" class="assign-btn" onclick="showUserDropdown()">
        <i class="bi bi-plus me-1"></i>
        Assign to someone
    </div>
</div>

<div id="userDropdown" class="mt-2 p-3 border rounded" style="display: none;">
    <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="userOption" id="user1" onclick="assignUser('John Doe')">
        <label class="form-check-label" for="user1">John Doe</label>
    </div>
    <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="userOption" id="user2" onclick="assignUser('Jane Smith')">
        <label class="form-check-label" for="user2">Jane Smith</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="userOption" id="user3" onclick="assignUser('Mike Johnson')">
        <label class="form-check-label" for="user3">Mike Johnson</label>
    </div>
</div>
@push('scripts')
    <script>
        function toggleScheduleOptions() {
            const scheduleLater = document.getElementById('scheduleLater');
            const scheduleInputs = document.getElementById('scheduleInputs');
            const anytimeSchedule = document.getElementById('anytimeSchedule');

            if (scheduleLater.checked) {
                scheduleInputs.classList.add('schedule-disabled');
                anytimeSchedule.checked = false;
            } else {
                scheduleInputs.classList.remove('schedule-disabled');
            }
        }

        function toggleTimeInputs() {
            const anytimeSchedule = document.getElementById('anytimeSchedule');
            const timeInputs = document.getElementById('timeInputs');
            const scheduleLater = document.getElementById('scheduleLater');

            if (anytimeSchedule.checked) {
                timeInputs.style.display = 'none';
                scheduleLater.checked = false;
                document.getElementById('scheduleInputs').classList.remove('schedule-disabled');
            } else {
                timeInputs.style.display = 'block';
            }
        }

        function showUserDropdown() {
            document.getElementById('userDropdown').style.display = 'block';
        }

        function assignUser(userName) {
            if (userName) {
                document.getElementById('assignedUserName').textContent = userName;
                document.getElementById('assignedUser').style.display = 'block';
                document.getElementById('assignButton').style.display = 'none';
                document.getElementById('userDropdown').style.display = 'none';
            }
        }

        function removeAssignment() {
            document.getElementById('assignedUser').style.display = 'none';
            document.getElementById('assignButton').style.display = 'block';
            document.getElementById('userDropdown').style.display = 'none';
        }
    </script>
@endpush