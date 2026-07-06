@extends('admin.layouts.master', ['title' => 'Edit Elective'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.electives.index') }}">Electives</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Elective</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.electives.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.academic.electives._form')
    </form>
</div>
@endsection
