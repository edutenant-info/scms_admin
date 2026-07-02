@extends('admin.layouts.master', ['title' => 'Edit Master Category'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.master-categories.index') }}">Master Categories</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Master Category</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.master-categories.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.fees.master-categories._form')
    </form>
</div>
@endsection
