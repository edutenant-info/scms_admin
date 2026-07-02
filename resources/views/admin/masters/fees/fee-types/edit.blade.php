@extends('admin.layouts.master', ['title' => 'Edit Fee Type'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.fee-types.index') }}">Fee Types</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Fee Type</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.fee-types.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.fees.fee-types._form')
    </form>
</div>
@endsection
