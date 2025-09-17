@extends('layouts.app')

@section('title', 'Provinces')

@section('content')
<div class="section">
  <div class="row mb-2">
    <div class="col s12">
      <a href="{{ route('provinces.create') }}" class="btn waves-effect waves-light">
        <i class="material-icons left">add</i> Add Province
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="card green lighten-4 green-text text-darken-4">
      <div class="card-content">{{ session('success') }}</div>
    </div>
  @endif

  <div class="card">
    <div class="card-content">
      <span class="card-title">Province List</span>
      <table class="highlight responsive-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Status</th>
            <th class="center-align">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($provinces as $province)
            <tr>
              <td>{{ $province->name }}</td>
              <td>
                <span class="badge {{ $province->status ? 'green' : 'red' }} white-text">
                  {{ $province->status ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="center-align">
                <a href="{{ route('provinces.edit', $province) }}" class="btn-small blue">
                  <i class="material-icons">edit</i>
                </a>
                <form action="{{ route('provinces.destroy', $province) }}" method="POST" style="display:inline;">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-small red" onclick="return confirm('Delete this province?')">
                    <i class="material-icons">delete</i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="3" class="center-align">No provinces found.</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="center-align mt-2">
        {{ $provinces->links('vendor.pagination.materialize') }}
      </div>
    </div>
  </div>
</div>
@endsection
