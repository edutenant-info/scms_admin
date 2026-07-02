@extends('admin.layouts.master', ['title' => 'Edit Combination'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.combinations.index') }}">Combinations</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Combination</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.combinations.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.academic.combinations._form')
    </form>
</div>
@endsection
