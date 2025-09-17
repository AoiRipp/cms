@extends('layouts.app')

@section('title', 'Create Attribute')

@section('content')
<div class="section">
  <div class="card">
    <div class="card-content">
      <span class="card-title">Add New Attribute</span>

      <form action="{{ route('attributes.store') }}" method="POST">
        @csrf

        <div class="input-field">
          <input type="text" name="name" id="name" value="{{ old('name') }}" required>
          <label for="name">Name</label>
          @error('name') <span class="red-text">{{ $message }}</span> @enderror
        </div>

        <div class="input-field">
          <input type="text" name="unit" id="unit" value="{{ old('unit') }}">
          <label for="unit">Unit (optional)</label>
          @error('unit') <span class="red-text">{{ $message }}</span> @enderror
        </div>

        <div class="switch">
          <label>
              Inactive
              <input type="hidden" name="status" value="0">
              <input type="checkbox" name="status" value="1" checked>
              <span class="lever"></span>
              Active
          </label>
        </div>

        <div class="mt-2">
          <button type="submit" class="btn waves-effect waves-light">
            <i class="material-icons left">save</i> Save
          </button>
          <a href="{{ route('attributes.index') }}" class="btn-flat">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
