@extends('layout/main')
@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Struk</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Tanggal</th>
                                        <th>User Id</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
                                        <th>Alamat</th>
                                        <th>Produk Id</th>
                                        <th>Nama Produk</th>
                                        <th>Harga Produk</th>
                                        <th>QTY</th>
                                        <th>Jasa Pengiriman</th>
                                        <th>Biaya Pengiriman</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getstruk as $g)
                                        <tr>
                                            <td>{{ $g->id }}</td>
                                            <td>{{ $g->tgl }}</td>
                                            <td>{{ $g->user_id }}</td>
                                            <td>{{ $g->name }}</td>
                                            <td>{{ $g->email }}</td>
                                            <td>{{ $g->telepon }}</td>
                                            <td>
                                                <div style="max-height: 100px; max-width: 300px; overflow-y: auto; white-space: normal; margin: 0; padding: 0; line-height: 1.2; text-align: justify;">
                                                    {{ $g->alamat }}
                                                </div>
                                            </td>
                                            <td>{{ $g->produk_id }}</td>
                                            <td>{{ $g->nama_produk }}</td>
                                            <td>{{ $g->harga_produk }}</td>
                                            <td>{{ $g->qty }}</td>
                                            <td>{{ $g->jasa_pengiriman }}</td>
                                            <td>{{ $g->biaya_pengiriman }}</td>
                                            <td>{{ $g->total_harga }}</td>
                                            <td>{{ $g->status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection