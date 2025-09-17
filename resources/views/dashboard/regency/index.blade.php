@extends('layouts.app')

@section('title', 'Regencies')

@section('content')
<div class="section">
  <div class="row mb-2">
    <div class="col s12">
      <a href="{{ route('regencies.create') }}" class="btn waves-effect waves-light">
        <i class="material-icons left">add</i> Add Regency
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
      <span class="card-title">Regency List</span>
      <table class="highlight responsive-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Province</th>
            <th>Status</th>
            <th class="center-align">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($regencies as $regency)
            <tr>
              <td>{{ $regency->name }}</td>
              <td>{{ $regency->province->name }}</td>
              <td>
                <span class="badge {{ $regency->status ? 'green' : 'red' }} white-text">
                  {{ $regency->status ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="center-align">
                <a href="{{ route('regencies.edit', $regency) }}" class="btn-small blue">
                  <i class="material-icons">edit</i>
                </a>
                <form action="{{ route('regencies.destroy', $regency) }}" method="POST" style="display:inline;">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-small red" onclick="return confirm('Delete this regency?')">
                    <i class="material-icons">delete</i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="4" class="center-align">No regencies found.</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="center-align mt-2">
        {{ $regencies->links('vendor.pagination.materialize') }}
      </div>
    </div>
  </div>
</div>
@endsection
