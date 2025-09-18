@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="section">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            {{-- Title --}}
            <div class="input-field col s12">
                <input id="title" type="text" name="title" value="{{ old('title') }}" required>
                <label for="title">Title</label>
            </div>

            {{-- Description --}}
            <div class="input-field col s12">
                <textarea id="description" class="materialize-textarea" name="description">{{ old('description') }}</textarea>
                <label for="description">Description</label>
            </div>

            <div class="input-field col s12">
                <input id="metalink" type="text" name="metalink"
                    value="{{ old('metalink', $product->metalink ?? '') }}" required>
                <label for="metalink">Metalink (Slug, no spaces)</label>
                <small class="helper-text">Use only lowercase letters, numbers, dashes (-), and underscores (_)</small>
            </div>

            {{-- Meta --}}
            <div class="input-field col s6">
                <input id="meta_title" type="text" name="meta_title" value="{{ old('meta_title') }}">
                <label for="meta_title">Meta Title</label>
            </div>
            <div class="input-field col s6">
                <input id="meta_tags" type="text" name="meta_tags" value="{{ old('meta_tags') }}">
                <label for="meta_tags">Meta Tags</label>
            </div>
            <div class="input-field col s12">
                <textarea id="meta_description" class="materialize-textarea" name="meta_description">{{ old('meta_description') }}</textarea>
                <label for="meta_description">Meta Description</label>
            </div>

            <div class="input-field col s6">
                <i class="prefix" style="font-size:14px;top:0.8rem;width:2rem;">Rp</i>
                <input id="price_display" type="text"
                    value="{{ old('price', $product->price ?? '') }}"
                    oninput="formatPrice(this)" required>
                <input id="price" type="hidden" name="price"
                    value="{{ old('price', $product->price ?? '') }}">
                <label for="price_display">Price</label>
            </div>

            {{-- Luas & Rooms --}}
            <div class="input-field col s6">
                <input type="number" name="luas_tanah" value="{{ old('luas_tanah') }}">
                <label>Luas Tanah (m²)</label>
            </div>
            <div class="input-field col s6">
                <input type="number" name="luas_bangunan" value="{{ old('luas_bangunan') }}">
                <label>Luas Bangunan (m²)</label>
            </div>
            <div class="input-field col s6">
                <input type="number" name="kamar_tidur" value="{{ old('kamar_tidur') }}">
                <label>Kamar Tidur</label>
            </div>
            <div class="input-field col s6">
                <input type="number" name="kamar_mandi" value="{{ old('kamar_mandi') }}">
                <label>Kamar Mandi</label>
            </div>

            {{-- Province & Regency --}}
            <div class="input-field col s6">
                <select id="province" name="province_id" required>
                    <option value="" disabled selected>Choose Province</option>
                    @foreach($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
                <label>Province</label>
            </div>

            <div class="input-field col s6">
                <select id="regency" name="regency_id" required>
                    <option value="" disabled selected>Choose Regency</option>
                </select>
                <label>Regency</label>
            </div>

            {{-- Category --}}
            <div class="input-field col s6">
                <select name="category_id" required>
                    <option value="" disabled selected>Choose Category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <label>Category</label>
            </div>

            {{-- Promos --}}
            <div class="input-field col s6">
                <select name="promos[]" multiple>
                    @foreach($promos as $promo)
                    <option value="{{ $promo->id }}">{{ $promo->title }}</option>
                    @endforeach
                </select>
                <label>Promos</label>
            </div>

            {{-- Facilities --}}
            <div class="input-field col s6">
                <select name="facilities[]" multiple>
                    @foreach($facilities as $facility)
                    <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                    @endforeach
                </select>
                <label>Facilities</label>
            </div>

            {{-- YouTube Embed --}}
            <div class="input-field col s12">
                <input type="text" name="youtube_embed" 
                    value="{{ old('youtube_embed', $product->youtube_embed ?? '') }}">
                <label for="youtube_embed">YouTube Embed (iframe code or link)</label>
            </div>

            {{-- Google Map --}}
            <div class="input-field col s12">
                <textarea name="google_map" class="materialize-textarea">{{ old('google_map', $product->google_map ?? '') }}</textarea>
                <label for="google_map">Google Map Embed (iframe code)</label>
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


            {{-- Images --}}
            <div class="file-field input-field col s12">
                <div class="btn">
                    <span>Upload Images</span>
                    <input type="file" name="images[]" multiple accept="image/*">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Upload one or more images">
                </div>
            </div>

            <div class="col s12 mt-2">
                <button type="submit" class="btn waves-effect waves-light">
                    <i class="material-icons left">save</i> Save
                </button>
                <a href="{{ route('products.index') }}" class="btn-flat">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('metalink').addEventListener('input', function () {
        this.value = this.value
            .toLowerCase()
            .replace(/\s+/g, '-')      // replace spaces with -
            .replace(/[^a-z0-9-_]/g, ''); // remove invalid chars
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
                    M.FormSelect.init(regencySelect); // reinit materialize select
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