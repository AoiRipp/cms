@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="section">
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

            {{-- Title --}}
            <div class="input-field col s12">
                <input id="title" type="text" name="title" value="{{ old('title', $product->title) }}" required>
                <label for="title" class="active">Title</label>
            </div>

            {{-- Description --}}
            <div class="input-field col s12">
                <textarea id="description" class="materialize-textarea" name="description">{{ old('description', $product->description) }}</textarea>
                <label for="description" class="active">Description</label>
            </div>
            <div class="input-field col s12">
                <input id="metalink" type="text" name="metalink"
                    value="{{ old('metalink', $product->metalink ?? '') }}" required>
                <label for="metalink">Metalink (Slug, no spaces)</label>
                <small class="helper-text">Use only lowercase letters, numbers, dashes (-), and underscores (_)</small>
            </div>

            {{-- Meta --}}
            <div class="input-field col s6">
                <input id="meta_title" type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}">
                <label for="meta_title" class="active">Meta Title</label>
            </div>
            <div class="input-field col s6">
                <input id="meta_tags" type="text" name="meta_tags" value="{{ old('meta_tags', $product->meta_tags) }}">
                <label for="meta_tags" class="active">Meta Tags</label>
            </div>
            <div class="input-field col s12">
                <textarea id="meta_description" class="materialize-textarea" name="meta_description">{{ old('meta_description', $product->meta_description) }}</textarea>
                <label for="meta_description" class="active">Meta Description</label>
            </div>

            {{-- Price --}}
            <div class="input-field col s6">
                <i class="prefix" style="font-size:14px;top:0.8rem;">Rp</i>
                <input id="price_display" type="text"
                    value="{{ old('price', isset($product->price) ? number_format($product->price, 0, ',', '.') : '') }}"
                    oninput="formatPrice(this)" required>
                <input id="price" type="hidden" name="price"
                    value="{{ old('price', $product->price ?? '') }}">
                <label for="price_display" class="active">Price</label>
            </div>

            {{-- Luas & Rooms --}}
            <div class="input-field col s6">
                <input type="number" name="luas_tanah" value="{{ old('luas_tanah', $product->luas_tanah) }}">
                <label class="active">Luas Tanah (m²)</label>
            </div>
            <div class="input-field col s6">
                <input type="number" name="luas_bangunan" value="{{ old('luas_bangunan', $product->luas_bangunan) }}">
                <label class="active">Luas Bangunan (m²)</label>
            </div>
            <div class="input-field col s6">
                <input type="number" name="kamar_tidur" value="{{ old('kamar_tidur', $product->kamar_tidur) }}">
                <label class="active">Kamar Tidur</label>
            </div>
            <div class="input-field col s6">
                <input type="number" name="kamar_mandi" value="{{ old('kamar_mandi', $product->kamar_mandi) }}">
                <label class="active">Kamar Mandi</label>
            </div>

            {{-- Province & Regency --}}
            <div class="input-field col s6">
                <select id="province" name="province_id" required>
                    <option value="" disabled>Choose Province</option>
                    @foreach($provinces as $province)
                    <option value="{{ $province->id }}" {{ $province->id == old('province_id', $product->province_id) ? 'selected' : '' }}>
                        {{ $province->name }}
                    </option>
                    @endforeach
                </select>
                <label class="active">Province</label>
            </div>

            <div class="input-field col s6">
                <select id="regency" name="regency_id" required>
                    <option value="" disabled>Choose Regency</option>
                    @foreach($regencies as $regency)
                    <option value="{{ $regency->id }}" {{ $regency->id == old('regency_id', $product->regency_id) ? 'selected' : '' }}>
                        {{ $regency->name }}
                    </option>
                    @endforeach
                </select>
                <label class="active">Regency</label>
            </div>

            {{-- Category --}}
            <div class="input-field col s6">
                <select name="category_id" required>
                    <option value="" disabled selected>Choose Category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
                <label>Category</label>
            </div>

            {{-- Promos --}}
            <div class="input-field col s6">
                <select name="promos[]" multiple>
                    @foreach($promos as $promo)
                    <option value="{{ $promo->id }}" {{ in_array($promo->id, $product->promos->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $promo->title }}
                    </option>
                    @endforeach
                </select>
                <label class="active">Promos</label>
            </div>

            {{-- Facilities --}}
            <div class="input-field col s6">
                <select name="facilities[]" multiple>
                    @foreach($facilities as $facility)
                    <option value="{{ $facility->id }}" {{ in_array($facility->id, $product->facilities->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $facility->name }}
                    </option>
                    @endforeach
                </select>
                <label class="active">Facilities</label>
            </div>

            {{-- Attributes --}}
            <div class="col s12">
                <label class="active">Attributes</label>
                <div id="attributes-wrapper">
                    {{-- Existing attributes for edit --}}
                    @if(isset($product))
                    @foreach($product->attributes as $i => $attr)
                    <div class="row attribute-row">
                        <div class="input-field col s5">
                            <select name="attributes[{{ $i }}][id]" required>
                                <option value="" disabled>Choose Attribute</option>
                                @foreach($attributes as $attribute)
                                <option value="{{ $attribute->id }}"
                                    {{ $attribute->id == $attr->id ? 'selected' : '' }}>
                                    {{ $attribute->name }}
                                </option>
                                @endforeach
                            </select>
                            <label>Attribute</label>
                        </div>
                        <div class="input-field col s5">
                            <input type="text"
                                name="attributes[{{ $i }}][value]"
                                value="{{ $attr->pivot->value ?? '' }}"
                                placeholder="Enter value">
                            <label class="active">Value</label>
                        </div>
                        <div class="col s2">
                            <button type="button" class="btn red remove-attr">✕</button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                <button type="button" id="add-attribute" class="btn green mt-2">
                    + Add Attribute
                </button>
            </div>


            {{-- Existing Images --}}
            <div class="col s12">
                <p>Existing Images:</p>
                <div class="row">
                    @foreach($product->images as $img)
                    <div class="col s3">
                        <img src="{{ asset('storage/' . $img->path) }}" class="responsive-img" alt="Product image">
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- New Images --}}
            <div class="file-field input-field col s12">
                <div class="btn">
                    <span>Upload More Images</span>
                    <input type="file" name="images[]" multiple accept="image/*">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Upload additional images">
                </div>
            </div>

            <div class="col s12 mt-2">
                <button type="submit" class="btn waves-effect waves-light">
                    <i class="material-icons left">save</i> Update
                </button>
                <a href="{{ route('products.index') }}" class="btn-flat">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const priceInput = document.getElementById('price_display');
        if (priceInput.value) {
            formatPrice(priceInput);
        }
    });

    function formatPrice(input) {
        let raw = input.value.replace(/\D/g, ''); // only numbers
        if (raw) {
            input.value = new Intl.NumberFormat('id-ID').format(raw);
            document.getElementById('price').value = raw; // update hidden input
        } else {
            input.value = '';
            document.getElementById('price').value = '';
        }
    }
</script>
<script>
    document.getElementById('metalink').addEventListener('input', function () {
        this.value = this.value
            .toLowerCase()
            .replace(/\s+/g, '-')      // replace spaces with -
            .replace(/[^a-z0-9-_]/g, ''); // remove invalid chars
    });
    document.addEventListener('DOMContentLoaded', function() {
        const provinceSelect = document.getElementById('province');
        const regencySelect = document.getElementById('regency');

        provinceSelect.addEventListener('change', function() {
            fetch(`/api/regencies?province_id=${this.value}`)
                .then(res => res.json())
                .then(data => {
                    regencySelect.innerHTML = '<option disabled selected>Choose Regency</option>';
                    data.forEach(reg => {
                        let opt = document.createElement('option');
                        opt.value = reg.id;
                        opt.textContent = reg.name;
                        regencySelect.appendChild(opt);
                    });
                    M.FormSelect.init(regencySelect);
                });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('attributes-wrapper');
        const addBtn = document.getElementById('add-attribute');

        let index = wrapper.querySelectorAll('.attribute-row').length;

        function refreshAttributeOptions() {
            const selected = Array.from(wrapper.querySelectorAll('select'))
                .map(s => s.value)
                .filter(v => v !== "");

            wrapper.querySelectorAll('select').forEach(select => {
                const currentValue = select.value;
                select.querySelectorAll('option').forEach(opt => {
                    if (opt.value && selected.includes(opt.value) && opt.value !== currentValue) {
                        opt.disabled = true;
                    } else {
                        opt.disabled = false;
                    }
                });
            });
            M.FormSelect.init(wrapper.querySelectorAll('select'));
        }

        addBtn.addEventListener('click', function() {
            const row = document.createElement('div');
            row.classList.add('row', 'attribute-row');
            row.innerHTML = `
            <div class="input-field col s5">
                <select name="attributes[${index}][id]" required>
                    <option value="" disabled selected>Choose Attribute</option>
                    @foreach($attributes as $attribute)
                        <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                    @endforeach
                </select>
                <label>Attribute</label>
            </div>
            <div class="input-field col s5">
                <input type="text" name="attributes[${index}][value]" placeholder="Enter value">
                <label>Value</label>
            </div>
            <div class="col s2">
                <button type="button" class="btn red remove-attr">✕</button>
            </div>
        `;
            wrapper.appendChild(row);
            M.FormSelect.init(row.querySelectorAll('select'));
            index++;
            refreshAttributeOptions();
        });

        wrapper.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-attr')) {
                e.target.closest('.attribute-row').remove();
                refreshAttributeOptions();
            }
        });

        wrapper.addEventListener('change', function(e) {
            if (e.target.tagName === 'SELECT') {
                refreshAttributeOptions();
            }
        });

        refreshAttributeOptions();
    });
</script>
@endpush