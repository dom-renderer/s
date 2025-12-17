@extends('layouts.app',['title' => $title, 'subTitle' => $subTitle,'datatable' => true, 'select2' => true])

@section('content')

<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">Vehicle Type Management</h1>
        <p class="mt-2">Manage vehicle types and their details</p>
    </div>
    <div class="welcome-right">
        <a href="{{ route('vehicle-types.create') }}" class="btn blue-btn d-flex gap-2">
            <img src="{{ asset('ui/images/+(1).svg') }}" alt="">
            Add New Vehicle Type
        </a>
    </div>
</div>
<div class="dash-md1">
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="status-box flx-manage mb-4">
                <div class="st-left">
                    <h3 class="h-14 mb-2">Total Types</h3>
                    <span class="h-20 fw-bold">{{ $all }}</span>
                </div>
                <div class="st-img bg-1">
                    <img src="{{ asset('ui/images/user-top1.svg') }}" alt="">
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="status-box flx-manage mb-4">
                <div class="st-left">
                    <h3 class="h-14 mb-2">Active Types</h3>
                    <span class="h-20 fw-bold">{{ $active }}</span>
                </div>
                <div class="st-img bg-5">
                    <img src="{{ asset('ui/images/user-top2.svg') }}" alt="">
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="status-box flx-manage mb-4">
                <div class="st-left">
                    <h3 class="h-14 mb-2">Inactive Types</h3>
                    <span class="h-20 fw-bold">{{ $inactive }}</span>
                </div>
                <div class="st-img bg-6">
                    <img src="{{ asset('ui/images/user-top4.svg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="filter-box border-main padding-bx mb-4">
    <div class="flietr-left">
        <div class="search-filter">
            <img src="{{ asset('ui/images/search.svg') }}" alt="">
            <input type="text" id="filter-name" class="form-control form-control-sm" placeholder="Search vehicle types...">
        </div>
        <div class="custom-select-wrap">
            <select id="filter-status" class="form-select custom-select-arrow">
                <option selected value="">Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
    </div>
    <div class="filter-rgt">
        <button class="btn grey-btn"> <img src="{{ asset('ui/images/filter-icon.svg') }}" alt=""> Export</button>
        <button class="btn grey-btn"><img src="{{ asset('ui/images/export-icon.svg') }}" alt=""> More Filters</button>
    </div>
</div>
<div class="common-table boder-only">
    <table id="datatables-reponsive" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function () {
        let dataTable = $('#datatables-reponsive').DataTable({
            pageLength : 10,
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route(Request::route()->getName()) }}",
                "type": "GET",
                "data" : {
                    filter_status: function() {
                        return $("#filter-status").val();
                    },
                    filter_name: function () {
                        return $('#filter-name').val();
                    }
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'title',
                },
                {
                    data: 'description',
                    orderable: false,
                },
                {
                    data: 'status',
                    orderable: false,
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                }
            ],
            language: {
                paginate: {
                    previous: "<i class='fa fa-chevron-left'></i>",
                    next: "<i class='fa fa-chevron-right'></i>"
                }
            }
        });

        $('#filter-status').select2({
            placeholder: 'Select status',
            width: '100%'
        });

        $('#filter-name').on('keyup', function() {
            dataTable.ajax.reload();
        });

        $('#filter-status').on('change', function() {
            dataTable.ajax.reload();
        });

        $(document).on('click', '#deleteRow', function () {
            let url = $(this).data('row-route');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire('Deleted!', response.success, 'success');
                                dataTable.ajax.reload();
                            } else if (response.error) {
                                Swal.fire('Error', response.error, 'error');
                            }
                        },
                        error: function (xhr) {
                            let msg = 'An error occurred.';
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                msg = xhr.responseJSON.error;
                            }
                            Swal.fire('Error', msg, 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

