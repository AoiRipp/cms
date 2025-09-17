@extends('layouts.app')

@section('title', 'Edit Promo')

@section('content')
<div class="section">
  <div class="card">
    <div class="card-content">
      <span class="card-title">Edit Promo</span>

      <form action="{{ route('promos.update', $promo) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="input-field">
          <input type="text" name="title" id="title" value="{{ old('title', $promo->title) }}" required>
          <label for="title" class="active">Title</label>
          @error('title') <span class="red-text">{{ $message }}</span> @enderror
        </div>

        <div class="input-field">
          <textarea name="description" id="description" class="materialize-textarea">{{ old('description', $promo->description) }}</textarea>
          <label for="description" class="active">Description</label>
          @error('description') <span class="red-text">{{ $message }}</span> @enderror
        </div>

        <div class="switch mt-3">
          <label>
            Inactive
            <input type="hidden" name="status" value="0">
            <input type="checkbox" name="status" value="1" {{ old('status', $promo->status) ? 'checked' : '' }}>
            <span class="lever"></span>
            Active
          </label>
        </div>

        <div class="mt-2">
          <button type="submit" class="btn waves-effect waves-light">
            <i class="material-icons left">save</i> Update
          </button>
          <a href="{{ route('promos.index') }}" class="btn-flat">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
