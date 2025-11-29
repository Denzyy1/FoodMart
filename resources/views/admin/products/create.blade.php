<x-admin-layout>
    <x-slot name="content">
        <section class="py-5">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>Add New Product</h2>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">← Back to Products</a>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="price" class="form-label fw-bold">Price ($) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                                   id="price" name="price" value="{{ old('price') }}" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="stock_quantity" class="form-label fw-bold">Stock Quantity <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                                   id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required>
                                            @error('stock_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="type" class="form-label fw-bold">Product Type <span class="text-danger">*</span></label>
                                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                                <option value="">Select Type</option>
                                                <option value="vegetables" {{ old('type') == 'vegetables' ? 'selected' : '' }}>Vegetables</option>
                                                <option value="fruits" {{ old('type') == 'fruits' ? 'selected' : '' }}>Fruits</option>
                                                <option value="dairy" {{ old('type') == 'dairy' ? 'selected' : '' }}>Dairy</option>
                                                <option value="bakery" {{ old('type') == 'bakery' ? 'selected' : '' }}>Bakery</option>
                                                <option value="beverages" {{ old('type') == 'beverages' ? 'selected' : '' }}>Beverages</option>
                                                <option value="snacks" {{ old('type') == 'snacks' ? 'selected' : '' }}>Snacks</option>
                                                <option value="meat" {{ old('type') == 'meat' ? 'selected' : '' }}>Meat</option>
                                                <option value="seafood" {{ old('type') == 'seafood' ? 'selected' : '' }}>Seafood</option>
                                                <option value="frozen" {{ old('type') == 'frozen' ? 'selected' : '' }}>Frozen</option>
                                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="category_id" class="form-label fw-bold">Category</label>
                                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label fw-bold">Product Image</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="description" class="form-label fw-bold">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                                        <button type="submit" class="btn btn-success px-4">
                                            <svg width="20" height="20" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                            </svg>
                                            Add Product
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-slot>
</x-admin-layout>