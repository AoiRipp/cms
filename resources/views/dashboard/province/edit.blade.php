@extends('layouts.app')

@section('title', 'Edit Province')

@section('content')
<div class="row">
  <div class="col s12 m8">
    <form action="{{ route('provinces.update', $province) }}" method="POST">
      @csrf @method('PUT')
      <div class="input-field">
        <input type="text" id="name" name="name" value="{{ $province->name }}" required>
        <label for="name" class="active">Province Name</label>
      </div>
      <div class="switch">
        <label>
          Inactive
          <input type="hidden" name="status" value="0">
          <input type="checkbox" name="status" value="1" {{ $province->status ? 'checked' : '' }}>
          <span class="lever"></span>
          Active
        </label>
      </div>
      <div class="mt-2">
        <button type="submit" class="btn waves-effect waves-light">
          <i class="material-icons left">save</i> Update
        </button>
        <a href="{{ route('provinces.index') }}" class="btn-flat">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
