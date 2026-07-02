@extends('admin.layouts.master', ['title' => 'Edit Section'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.sections.index') }}">Sections</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Section</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.sections.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.academic.sections._form')
    </form>
</div>
@endsection
