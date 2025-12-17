@extends('layouts.app', ['title' => $title, 'subTitle' => $subTitle, 'datatable' => true, 'select2' => true, 'datepicker' => true])

@section('content')

    <div class="welcome-box">
        <div class="welcome-left">
            <h1 class="h-30 clr-blue fw-bold">User Management</h1>
            <p class="mt-2">Manage system users, roles & permissions</p>
        </div>
        <div class="welcome-right">
            <button class="btn blue-btn d-flex gap-2">
                <img src="{{ asset('ui/images/+(1).svg') }}" alt="">
                Add User
            </button>
        </div>
    </div>
    <div class="dash-md1">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="status-box flx-manage mb-4">
                    <div class="st-left">
                        <h3 class="h-14 mb-2">Total Users</h3>
                        <span class="h-20 fw-bold">6</span>
                    </div>
                    <div class="st-img bg-1">
                        <img src="{{ asset('ui/images/user-top1.svg') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="status-box flx-manage mb-4">
                    <div class="st-left">
                        <h3 class="h-14 mb-2">Active Users</h3>
                        <span class="h-20 fw-bold">2</span>
                    </div>
                    <div class="st-img bg-5">
                        <img src="{{ asset('ui/images/user-top2.svg') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="status-box flx-manage mb-4">
                    <div class="st-left">
                        <h3 class="h-14 mb-2">Pending Users</h3>
                        <span class="h-20 fw-bold">0</span>
                    </div>
                    <div class="st-img bg-4">
                        <img src="{{ asset('ui/images/user-top3.svg') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="status-box flx-manage mb-4">
                    <div class="st-left">
                        <h3 class="h-14 mb-2">Inactive Users</h3>
                        <span class="h-20 fw-bold">2</span>
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
                    <input type="text" class="form-control form-control-sm" placeholder="Search users...">
                </div>
                <div class="custom-select-wrap">
                    <select class="form-select custom-select-arrow">
                        <option selected>Roles</option>
                        <option value="1">Option One</option>
                        <option value="2">Option Two</option>
                        <option value="3">Option Three</option>
                    </select>
                </div>
                <div class="custom-select-wrap">
                    <select class="form-select custom-select-arrow">
                        <option selected>Status</option>
                        <option value="1">Option One</option>
                        <option value="2">Option Two</option>
                        <option value="3">Option Three</option>
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
                        <th>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                            </div>
                        </th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
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
                pageLength: 10,
                searching: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route(Request::route()->getName()) }}",
                    type: "GET",
                    data: {
                        filter_status: function () {
                            return $("#filter-status").val();
                        },
                        filter_role: function () {
                            return $('#filter-role').val();
                        },
                        filter_department: function () {
                            return $('#filter-department').val();
                        },
                        filter_name: function () {
                            return $('#filter-name').val();
                        }
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'phone_number' },
                    { data: 'roles' },
                    { data: 'status' },
                    { data: 'action', orderable: false, searchable: false }
                ],
                language: {
                    paginate: {
                        previous: "<i class='fa fa-chevron-left'></i>",  // Left arrow
                        next: "<i class='fa fa-chevron-right'></i>"      // Right arrow
                    }
                }
            });


            $('#filter-status').select2({
                placeholder: 'Select status',
                width: '100%'
            });

            $('#filter-role').select2({
                placeholder: 'Select roles',
                width: '100%'
            });

            $('#filter-department').select2({
                placeholder: 'Select departments',
                width: '100%'
            });

            $('#btn-search').on('click', function () {
                dataTable.ajax.reload();
            });

            $('#btn-clear').on('click', function () {
                $('#filter-status').val(null).trigger('change');
                $('#filter-role').val(null).trigger('change');
                $('#filter-department').val(null).trigger('change');
                $('#filter-name').val(null);

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

            jQuery('.previous .page-link').text('');
        });

    </script>
@endpush