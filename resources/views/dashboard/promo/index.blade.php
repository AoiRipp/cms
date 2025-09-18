@extends('layouts.app')

@section('title', 'Promos')

@section('content')
<div class="section">
  <div class="row mb-2">
    <div class="col s12">
      <a href="{{ route('promos.create') }}" class="btn waves-effect waves-light">
        <i class="material-icons left">add</i> Add Promo
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
      <span class="card-title">Promo List</span>
      <table class="highlight responsive-table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th class="center-align">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($promos as $promo)
            <tr>
              <td>{{ $promo->title }}</td>
              <td>{{ $promo->description }}</td>
              <td>
                <span class="badge {{ $promo->status ? 'green' : 'red' }} white-text">
                  {{ $promo->status ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="center-align">
                <a href="{{ route('promos.edit', $promo) }}" class="btn-small blue">
                  <i class="material-icons">edit</i>
                </a>
                <form action="{{ route('promos.destroy', $promo) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-small red" onclick="return confirm('Delete this promo?')">
                    <i class="material-icons">delete</i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="4" class="center-align">No promos found.</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="center-align mt-2">
        {{ $promos->links('vendor.pagination.materialize') }}
      </div>
    </div>
  </div>
</div>
@endsection
