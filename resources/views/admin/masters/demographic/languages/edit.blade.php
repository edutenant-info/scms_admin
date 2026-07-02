@extends('admin.layouts.master', ['title' => 'Edit Language'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.languages.index') }}">Languages</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Language</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.languages.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.demographic.languages._form')
    </form>
</div>
@endsection
