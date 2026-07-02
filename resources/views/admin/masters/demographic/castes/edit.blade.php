@extends('admin.layouts.master', ['title' => 'Edit Caste'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.castes.index') }}">Castes</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Caste</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.castes.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.demographic.castes._form')
    </form>
</div>
@endsection
