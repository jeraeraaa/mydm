@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Activity Categories</h5>
                        </div>
                        <!-- Add Category Button that opens the modal -->
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal"
                            data-bs-target="#createCategoryModal">
                            +&nbsp; Add Category
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                        style="width: 120px;">
                                        Actions
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Category Name
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategori as $category)
                                    <tr>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <!-- Edit Category -->
                                                <a href="{{ route('kategori-kegiatan.edit', $category->id_kategori_kegiatan) }}"
                                                    class="btn btn-link p-0 m-0">
                                                    <i class="fas fa-edit text-secondary"></i>
                                                </a>

                                                <!-- Delete Category -->
                                                <form
                                                    action="{{ route('kategori-kegiatan.destroy', $category->id_kategori_kegiatan) }}"
                                                    method="POST" class="d-inline-block d-flex align-items-center m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link p-0 m-0"
                                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                                        <i class="fas fa-trash text-secondary"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $category->nama_kategori }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success mt-2 mx-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger mt-2 mx-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Modal for Creating New Category -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Category Creation Form -->
                    <form action="{{ route('kategori-kegiatan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
