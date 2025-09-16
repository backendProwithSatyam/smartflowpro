@extends('admin.include.master')
@push('styles')
    <link href="{{asset('assets/src/plugins/src/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/src/plugins/css/light/fullcalendar/custom-fullcalendar.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/src/assets/css/light/components/modal.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/src/plugins/css/dark/fullcalendar/custom-fullcalendar.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/src/assets/css/dark/components/modal.css')}}" rel="stylesheet" type="text/css">
    <style>
        .calendar-popup {
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            min-width: 200px;
            padding: 15px;
            display: none;
        }
        .calendar-popup.show {
            display: block;
        }
        .popup-option {
            display: flex;
            align-items: center;
            padding: 10px;
            margin: 5px 0;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .popup-option:hover {
            background-color: #f8f9fa;
        }
        .popup-option i {
            margin-right: 10px;
            width: 20px;
        }
        .popup-option.job { color: #007bff; }
        .popup-option.request { color: #28a745; }
        .popup-option.quote { color: #ffc107; }
        .popup-option.invoice { color: #dc3545; }
        
        .calendar-date-indicator {
            position: absolute;
            top: 2px;
            right: 2px;
            font-size: 10px;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            gap: 1px;
        }
        .indicator-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }
        .indicator-dot.jobs { background-color: #007bff; }
        .indicator-dot.requests { background-color: #28a745; }
        .indicator-dot.quotes { background-color: #ffc107; }
        .indicator-dot.invoices { background-color: #dc3545; }
        
        .calendar-container {
            position: relative;
        }
        
        .fc-event {
            font-size: 11px;
            padding: 1px 3px;
            margin: 1px 0;
        }
        
        .fc-event.job-event { background-color: #007bff; border-color: #007bff; }
        .fc-event.request-event { background-color: #28a745; border-color: #28a745; }
        .fc-event.quote-event { background-color: #ffc107; border-color: #ffc107; color: #000; }
        .fc-event.invoice-event { background-color: #dc3545; border-color: #dc3545; }
    </style>
@endpush
@section('content')
    <div class="row layout-top-spacing layout-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="calendar-container">
                <div class="calendar"></div>
                
                <!-- Creation Popup -->
                <div class="calendar-popup" id="creationPopup">
                    <h6 class="mb-3">Create New Item</h6>
                    <div class="popup-option job" data-type="job">
                        <i class="fas fa-briefcase"></i>
                        <span>Create Job</span>
                    </div>
                    <div class="popup-option request" data-type="request">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Create Request</span>
                    </div>
                    <div class="popup-option quote" data-type="quote">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Create Quote</span>
                    </div>
                    <div class="popup-option invoice" data-type="invoice">
                        <i class="fas fa-receipt"></i>
                        <span>Create Invoice</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="dateInfo" class="mb-3">
                        <h6 id="selectedDate"></h6>
                    </div>
                    <div id="scheduleItems">
                        <!-- Items will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('assets/src/plugins/src/fullcalendar/fullcalendar.min.js')}}"></script>
    <script src="{{asset('assets/src/plugins/src/uuid/uuid4.min.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedDate = null;
            let popup = document.getElementById('creationPopup');
            
            // Initialize FullCalendar
            const calendarEl = document.querySelector('.calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                height: 'auto',
                dayMaxEvents: true,
                events: function(fetchInfo, successCallback, failureCallback) {
                    // Fetch events from server
                    fetch('/api/schedule-events')
                        .then(response => response.json())
                        .then(data => {
                            successCallback(data.events);
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            failureCallback(error);
                        });
                },
                dateClick: function(info) {
                    selectedDate = info.dateStr;
                    showCreationPopup(info.jsEvent, info.dateStr);
                },
                eventClick: function(info) {
                    showDetails(info.event.startStr);
                },
                dayCellDidMount: function(info) {
                    // Add indicators for each day
                    addDateIndicators(info);
                }
            });
            
            calendar.render();
            
            // Show creation popup
            function showCreationPopup(event, dateStr) {
                const rect = event.target.getBoundingClientRect();
                popup.style.left = (rect.left + window.scrollX) + 'px';
                popup.style.top = (rect.bottom + window.scrollY + 5) + 'px';
                popup.classList.add('show');
                
                // Store selected date
                popup.dataset.date = dateStr;
            }
            
            // Hide popup when clicking outside
            document.addEventListener('click', function(e) {
                if (!popup.contains(e.target) && !e.target.closest('.fc-day')) {
                    popup.classList.remove('show');
                }
            });
            
            // Handle popup option clicks
            popup.addEventListener('click', function(e) {
                const option = e.target.closest('.popup-option');
                if (option) {
                    const type = option.dataset.type;
                    const date = popup.dataset.date;
                    createNewItem(type, date);
                }
            });
            
            // Create new item and redirect
            function createNewItem(type, date) {
                const routes = {
                    'job': '{{ route("jobs.create") }}',
                    'request': '{{ route("requests.create") }}',
                    'quote': '{{ route("quotes.create") }}',
                    'invoice': '{{ route("invoices.create") }}'
                };
                
                const url = routes[type] + '?date=' + date;
                window.location.href = url;
            }
            
            // Add date indicators
            function addDateIndicators(info) {
                const dateStr = info.date.toISOString().split('T')[0];
                
                // Fetch data for this date
                fetch(`/api/schedule-data/${dateStr}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.counts && Object.values(data.counts).some(count => count > 0)) {
                            const indicator = document.createElement('div');
                            indicator.className = 'calendar-date-indicator';
                            
                            Object.entries(data.counts).forEach(([type, count]) => {
                                if (count > 0) {
                                    const dot = document.createElement('span');
                                    dot.className = `indicator-dot ${type}`;
                                    dot.title = `${count} ${type}`;
                                    indicator.appendChild(dot);
                                }
                            });
                            
                            info.el.appendChild(indicator);
                        }
                    })
                    .catch(error => console.error('Error fetching date data:', error));
            }
            
            // Show details modal
            function showDetails(dateStr) {
                fetch(`/api/schedule-details/${dateStr}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('selectedDate').textContent = 
                            new Date(dateStr).toLocaleDateString('en-US', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                        
                        const itemsContainer = document.getElementById('scheduleItems');
                        itemsContainer.innerHTML = '';
                        
                        if (data.items && data.items.length > 0) {
                            data.items.forEach(item => {
                                const itemElement = document.createElement('div');
                                itemElement.className = `card mb-2 border-start border-${getItemColor(item.type)} border-3`;
                                itemElement.innerHTML = `
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="card-title mb-1">${item.title}</h6>
                                                <small class="text-muted">${item.type.toUpperCase()}</small>
                                                ${item.client ? `<p class="mb-1"><small>Client: ${item.client}</small></p>` : ''}
                                                ${item.time ? `<p class="mb-0"><small>Time: ${item.time}</small></p>` : ''}
                                            </div>
                                            <span class="badge bg-${getItemColor(item.type)}">${item.status}</span>
                                        </div>
                                    </div>
                                `;
                                itemsContainer.appendChild(itemElement);
                            });
                        } else {
                            itemsContainer.innerHTML = '<p class="text-muted">No items scheduled for this date.</p>';
                        }
                        
                        new bootstrap.Modal(document.getElementById('detailsModal')).show();
                    })
                    .catch(error => {
                        console.error('Error fetching details:', error);
                        alert('Error loading details');
                    });
            }
            
            // Get color for item type
            function getItemColor(type) {
                const colors = {
                    'job': 'primary',
                    'request': 'success',
                    'quote': 'warning',
                    'invoice': 'danger'
                };
                return colors[type] || 'secondary';
            }
        });
    </script>
@endpush
