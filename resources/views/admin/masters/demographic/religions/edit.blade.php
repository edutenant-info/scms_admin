@extends('admin.layouts.master', ['title' => 'Edit Religion'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.religions.index') }}">Religions</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Religion</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.religions.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.demographic.religions._form')
    </form>
</div>
@endsection
