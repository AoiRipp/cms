@extends('layouts.app')

@section('title', 'Facilities')

@section('content')
<div class="section">
  <div class="row mb-2">
    <div class="col s12">
      <a href="{{ route('facilities.create') }}" class="btn waves-effect waves-light">
        <i class="material-icons left">add</i> Add Facility
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
      <span class="card-title">Facility List</span>
      <table class="highlight responsive-table">
        <thead>
          <tr>
            <th>Icon</th>
            <th>Name</th>
            <th>Status</th>
            <th class="center-align">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($facilities as $facility)
            <tr>
              <td>
                @if($facility->icon_path)
                  <img src="{{ asset('storage/' . $facility->icon_path) }}" 
                       alt="{{ $facility->name }}" 
                       width="40" height="40" 
                       style="object-fit: contain;">
                @else
                  <span class="grey-text">No Icon</span>
                @endif
              </td>
              <td>{{ $facility->name }}</td>
              <td>
                <span class="badge {{ $facility->status ? 'green' : 'red' }} white-text">
                  {{ $facility->status ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="center-align">
                <a href="{{ route('facilities.edit', $facility) }}" class="btn-small blue">
                  <i class="material-icons">edit</i>
                </a>
                <form action="{{ route('facilities.destroy', $facility) }}" 
                      method="POST" 
                      style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-small red" onclick="return confirm('Delete this facility?')">
                    <i class="material-icons">delete</i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="center-align">No facilities found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <div class="center-align mt-2">
        {{ $facilities->links('vendor.pagination.materialize') }}
      </div>
    </div>
  </div>
</div>
@endsection
