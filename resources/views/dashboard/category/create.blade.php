@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="section">
  <div class="row">
    <div class="col s12 m8">
      <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <div class="input-field">
          <input id="name" type="text" name="name" value="{{ old('name') }}" required>
          <label for="name">Category Name</label>
          @error('name')<span class="red-text">{{ $message }}</span>@enderror
        </div>
        <div class="input-field">
          <textarea id="description" name="description" class="materialize-textarea">{{ old('description') }}</textarea>
          <label for="description">Description</label>
        </div>
        <button type="submit" class="btn waves-effect waves-light">Save</button>
        <a href="{{ route('categories.index') }}" class="btn-flat">Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
