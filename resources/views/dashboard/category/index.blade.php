@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="section">
  <div class="row">
    <div class="col s12">
      <a href="{{ route('categories.create') }}" class="btn waves-effect waves-light">
        <i class="material-icons left">add</i>Add Category
      </a>
      <table class="highlight responsive-table mt-2">
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $category)
            <tr>
              <td>{{ $category->name }}</td>
              <td>{{ $category->description }}</td>
              <td>{{ $category->created_at->format('Y-m-d') }}</td>
              <td>
                <a href="{{ route('categories.edit', $category) }}" class="btn-small">
                  <i class="material-icons">edit</i>
                </a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-small red">
                    <i class="material-icons">delete</i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="center-align">No categories found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <div class="center-align mt-2">
        {{ $categories->links('vendor.pagination.materialize') }}
      </div>
    </div>
  </div>
</div>
@endsection
