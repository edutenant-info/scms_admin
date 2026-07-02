@extends('admin.layouts.master', ['title' => 'Edit Blood Group'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.blood-groups.index') }}">Blood Groups</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Blood Group</div>
            <div class="pst">{{ $item->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.blood-groups.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.demographic.blood-groups._form')
    </form>
</div>
@endsection
