<x-admin-layout>
    <x-slot name="content">
        <section class="py-5">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>Edit Product</h2>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">← Back to Products</a>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="price" class="form-label fw-bold">Price ($) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                                   id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="stock_quantity" class="form-label fw-bold">Stock Quantity <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                                   id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
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
                                                @foreach(['vegetables', 'fruits', 'dairy', 'bakery', 'beverages', 'snacks', 'meat', 'seafood', 'frozen', 'other'] as $type)
                                                    <option value="{{ $type }}" {{ old('type', $product->type) == $type ? 'selected' : '' }}>
                                                        {{ ucfirst($type) }}
                                                    </option>
                                                @endforeach
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
                                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                        @if($product->image_url)
                                            <div class="mb-2">
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="rounded" style="max-height: 150px;">
                                            </div>
                                        @endif
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Leave empty to keep current image. Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="description" class="form-label fw-bold">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                                        <button type="submit" class="btn btn-primary px-4">Update Product</button>
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