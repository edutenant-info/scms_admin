@extends('admin.layouts.master', ['title' => 'Edit Standard'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.standards.index') }}">Standards</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Standard</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.standards.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.academic.standards._form')
    </form>
</div>
@endsection
