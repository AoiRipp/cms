@extends('layouts.app')

@section('title', 'Create Promo')

@section('content')
<div class="section">
  <div class="card">
    <div class="card-content">
      <span class="card-title">Add New Promo</span>

      <form action="{{ route('promos.store') }}" method="POST">
        @csrf

        <div class="input-field">
          <input type="text" name="title" id="title" value="{{ old('title') }}" required>
          <label for="title">Title</label>
          @error('title') <span class="red-text">{{ $message }}</span> @enderror
        </div>

        <div class="input-field">
          <textarea name="description" id="description" class="materialize-textarea">{{ old('description') }}</textarea>
          <label for="description">Description</label>
          @error('description') <span class="red-text">{{ $message }}</span> @enderror
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
          <a href="{{ route('promos.index') }}" class="btn-flat">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
