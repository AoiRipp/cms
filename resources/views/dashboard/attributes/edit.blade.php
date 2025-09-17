@extends('layouts.app')

@section('title', 'Edit Attribute')

@section('content')
<div class="section">
  <div class="card">
    <div class="card-content">
      <span class="card-title">Edit Attribute</span>

      <form action="{{ route('attributes.update', $attribute) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="input-field">
          <input type="text" name="name" id="name" value="{{ old('name', $attribute->name) }}" required>
          <label for="name" class="active">Name</label>
          @error('name') <span class="red-text">{{ $message }}</span> @enderror
        </div>

        <div class="input-field">
          <input type="text" name="unit" id="unit" value="{{ old('unit', $attribute->unit) }}">
          <label for="unit" class="active">Unit (optional)</label>
          @error('unit') <span class="red-text">{{ $message }}</span> @enderror
        </div>

        <div class="switch mt-3">
          <label>
            Inactive
            <input type="hidden" name="status" value="0">
            <input type="checkbox" name="status" value="1" {{ old('status', $attribute->status) ? 'checked' : '' }}>
            <span class="lever"></span>
            Active
          </label>
        </div>

        <div class="mt-2">
          <button type="submit" class="btn waves-effect waves-light">
            <i class="material-icons left">save</i> Update
          </button>
          <a href="{{ route('attributes.index') }}" class="btn-flat">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
