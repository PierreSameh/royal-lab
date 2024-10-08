@extends('Admin.layouts.main')

@section("title", "Branchs")

@php
    $branchs = App\Models\Branch::all();
@endphp

@section("content")
<style>
    #dataTable_wrapper{
        width: 100%
    }
</style>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('branches.title')</h1>
    <a href="{{ route("admin.branches.add") }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> @lang('branches.create_branch')
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive" style="width: 100%;">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="width: 100%;">
                <thead>
                    <tr>
                        <th>@lang('branches.address')</th>
                        <th>@lang('branches.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($branchs as $cat)
                        <tr>
                            <td>{{ $cat->address }}</td>
                            <td>
                                <a href="{{ route("admin.branches.edit", ["id" => $cat->id]) }}" class="btn btn-success">@lang('branches.edit')</a>
                                <a href="{{ route("admin.branches.delete.confirm", ["id" => $cat->id]) }}" class="btn btn-danger">@lang('branches.delete')</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endSection

@section("scripts")
<script src="{{ asset('/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('/admin/js/demo/datatables-demo.js') }}"></script>
@endSection
