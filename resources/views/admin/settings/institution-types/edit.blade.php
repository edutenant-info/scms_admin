@extends('admin.layouts.master', ['title' => 'Edit Institution Type'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.institution-types.index') }}">Institution Types</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Institution Type</div>
            <div class="pst">{{ $type->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.institution-types.update', $type) }}">
        @csrf
        @method('PUT')
        @include('admin.settings.institution-types._form')
    </form>
</div>
@endsection
