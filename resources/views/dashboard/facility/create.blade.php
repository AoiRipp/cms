@extends('layouts.app')

@section('title', 'Add Facility')

@section('content')
<div class="row">
  <div class="col s12 m8">
    <form action="{{ route('facilities.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="input-field">
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        <label for="name">Facility Name</label>
      </div>

      <div class="file-field input-field">
        <div class="btn">
          <span>Upload Icon</span>
          <input type="file" name="icon" accept="image/*">
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text">
        </div>
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
        <a href="{{ route('facilities.index') }}" class="btn-flat">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
