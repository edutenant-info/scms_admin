@extends('admin.layouts.master', ['title' => 'Edit Nationality'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.nationalities.index') }}">Nationalities</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Nationality</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.nationalities.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.demographic.nationalities._form')
    </form>
</div>
@endsection
