<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">Bordered Table</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <div class="mb-3">
                    {{-- <button type="button" class="btn btn-success add-button" data-bs-toggle="modal" data-bs-target="#crudModal">+ Tambah data</button> --}}
                    <button type="button" class="btn btn-success add-button">+ Tambah data</button>
                </div>
                @foreach ($customersPaginate as $customer)
                    <tr class="align-middle">
                        <td class="customerId">{{ $loop->iteration }}</td>
                        <td>{{ $customer->customer_name }}</td>
                        <td>{{ $customer->full_address }}</td>
                        <td>{{ $customer?->user?->phone ?? 'Nomor telepon tidak tersedia' }}</td>
                        <td>
                            <button class="btn btn-warning edit-button" data-id="{{ $customer->id }}">Edit</button>
                            <button class="btn btn-danger delete-button" data-id="{{ $customer->id }}">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-end">
            {{-- <li class="page-item"><a class="page-link" href="{{ $customersPaginate->previousPageUrl }}">&laquo;</a></li> --}}
            {!! $customersPaginate->links() !!}
            {{-- <li class="page-item"><a class="page-link" href="#">&raquo;</a></li> --}}
        </ul>
    </div>
</div>
