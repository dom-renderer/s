@extends('layouts.app',['title' => $title, 'subTitle' => $subTitle,'datatable' => true, 'select2' => true, 'datepicker' => true])

@section('content')

<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">Role Management</h1>
        <p class="mt-2">Manage system roles and permissions</p>
    </div>
    <div class="welcome-right">
        <a href="{{ route('roles.create') }}" class="btn blue-btn d-flex gap-2">
            <img src="{{ asset('ui/images/+(1).svg') }}" alt="">
            Add New Role
        </a>
    </div>
</div>
<div class="filter-box border-main padding-bx mb-4">
    <div class="flietr-left">
        <div class="search-filter">
            <img src="{{ asset('ui/images/search.svg') }}" alt="">
            <input type="text" id="filter-name" class="form-control form-control-sm" placeholder="Search roles...">
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
                <th>Name</th>
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

        $('#filter-name').on('keyup', function() {
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