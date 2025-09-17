@extends('layouts.app')

@section('title', 'Property Attributes')

@section('content')
<div class="section">
  <div class="row mb-2">
    <div class="col s12">
      <a href="{{ route('attributes.create') }}" class="btn waves-effect waves-light">
        <i class="material-icons left">add</i> Add Attribute
      </a>
    </div>
  </div>

  {{-- Flash messages --}}
  @if(session('success'))
    <div class="card green lighten-4 green-text text-darken-4">
      <div class="card-content">{{ session('success') }}</div>
    </div>
  @endif

  <div class="card">
    <div class="card-content">
      <span class="card-title">Attributes List</span>
      <table class="highlight responsive-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Unit</th>
            <th>Status</th>
            <th class="center-align">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($attributes as $attribute)
            <tr>
              <td>{{ $attribute->name }}</td>
              <td>{{ $attribute->unit ?? '-' }}</td>
              <td>
                <span class="badge {{ $attribute->active ? 'green' : 'red' }} white-text">
                  {{ $attribute->active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="center-align">
                <a href="{{ route('attributes.edit', $attribute) }}" class="btn-small blue">
                  <i class="material-icons">edit</i>
                </a>
                <form action="{{ route('attributes.destroy', $attribute) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-small red" onclick="return confirm('Delete this attribute?')">
                    <i class="material-icons">delete</i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="4" class="center-align">No attributes found.</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="center-align mt-2">
        {{ $attributes->links('vendor.pagination.materialize') }}
      </div>
    </div>
  </div>
</div>
@endsection
