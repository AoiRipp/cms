@extends('layouts.app')

@section('title', 'Edit Facility')

@section('content')
<div class="row">
  <div class="col s12 m8">
    <form action="{{ route('facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="input-field">
        <input type="text" id="name" name="name" value="{{ old('name', $facility->name) }}" required>
        <label for="name" class="active">Facility Name</label>
      </div>

      <div class="file-field input-field">
        <div class="btn">
          <span>Upload New Icon</span>
          <input type="file" name="icon" accept="image/*">
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text">
        </div>
      </div>

      @if($facility->icon)
        <p>Current Icon:</p>
        <img src="{{ asset('storage/' . $facility->icon) }}" alt="{{ $facility->name }}" width="80">
      @endif

      <div class="switch mt-3">
        <label>
          Inactive
          <input type="hidden" name="status" value="0">
          <input type="checkbox" name="status" value="1" {{ old('status', $facility->status) ? 'checked' : '' }}>
          <span class="lever"></span>
          Active
        </label>
      </div>

      <div class="mt-2">
        <button type="submit" class="btn waves-effect waves-light">
          <i class="material-icons left">save</i> Update
        </button>
        <a href="{{ route('facilities.index') }}" class="btn-flat">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
