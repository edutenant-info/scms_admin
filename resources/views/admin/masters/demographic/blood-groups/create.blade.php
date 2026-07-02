@extends('admin.layouts.master', ['title' => 'New Blood Group'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.blood-groups.index') }}">Blood Groups</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Blood Group</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.blood-groups.store') }}">
        @csrf
        @include('admin.masters.demographic.blood-groups._form')
    </form>
</div>
@endsection
