@extends('layouts.app')

@section('title','Settings')

@section('content')
<div class="section">
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Banner --}}
        <div class="file-field input-field">
            <div class="btn">
                <span>Upload Banner</span>
                <input type="file" name="banner[]" multiple accept="image/*">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Upload one or more banners">
            </div>
            @if(!empty($settings['banner']))
                <div class="row mt-2">
                    @foreach(json_decode($settings['banner'], true) as $img)
                        <div class="col s2">
                            <img src="{{ Storage::disk('storage')->url($img) }}" style="width:100%;border-radius:8px;">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Contact Info --}}
        <div class="input-field">
            <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}">
            <label>Phone</label>
        </div>
        <div class="input-field">
            <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}">
            <label>Email</label>
        </div>
        <div class="input-field">
            <textarea name="contact_address" class="materialize-textarea">{{ $settings['contact_address'] ?? '' }}</textarea>
            <label>Address</label>
        </div>

        <button type="submit" class="btn">Save</button>
    </form>
</div>
@endsection
