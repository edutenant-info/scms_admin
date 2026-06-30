@extends('admin.layouts.master', ['title' => 'Edit Institution'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.institutions.index') }}">Institutions</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ route('admin.institutions.show', $institution) }}">{{ $institution->name }}</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Institution</div>
            <div class="pst">{{ $institution->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.institutions.update', $institution) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.modules.institution._form')
    </form>
</div>
@endsection
