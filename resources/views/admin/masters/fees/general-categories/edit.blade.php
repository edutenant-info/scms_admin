@extends('admin.layouts.master', ['title' => 'Edit General Category'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.general-categories.index') }}">General Categories</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit General Category</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.general-categories.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.fees.general-categories._form')
    </form>
</div>
@endsection
