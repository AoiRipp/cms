@extends('layouts.app')

@section('title', 'Edit Regency')

@section('content')
<div class="row">
  <div class="col s12 m8">
    <form action="{{ route('regencies.update', $regency) }}" method="POST">
      @csrf @method('PUT')
      <div class="input-field">
        <select name="province_id" required>
          @foreach($provinces as $province)
            <option value="{{ $province->id }}" {{ $regency->province_id == $province->id ? 'selected' : '' }}>
              {{ $province->name }}
            </option>
          @endforeach
        </select>
        <label for="province_id">Province</label>
      </div>
      <div class="input-field">
        <input type="text" id="name" name="name" value="{{ $regency->name }}" required>
        <label for="name" class="active">Regency Name</label>
      </div>
      <div class="switch">
        <label>
          Inactive
          <input type="hidden" name="status" value="0">
          <input type="checkbox" name="status" value="1" {{ $regency->status ? 'checked' : '' }}>
          <span class="lever"></span>
          Active
        </label>
      </div>
      <div class="mt-2">
        <button type="submit" class="btn waves-effect waves-light">
          <i class="material-icons left">save</i> Update
        </button>
        <a href="{{ route('regencies.index') }}" class="btn-flat">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
