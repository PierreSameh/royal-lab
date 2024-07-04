@extends('Admin.layouts.main')

@section("title", __('cities.delete_title'))
@section("loading_txt", __('cities.delete_loading'))

@section("content")
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('cities.delete_heading')</h1>
    <a href="{{ route("admin.cities.show") }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> @lang('cities.back_button')
    </a>
</div>

<div class="card p-3 mb-3" id="cities_wrapper">
    <div class="card-header mb-3">
        <h3 class="text-danger text-center mb-0">@lang('cities.confirm_delete')</h3>
    </div>
    <div class="d-flex justify-content-between" style="gap: 16px">
        <div class="w-100">
            <div class="form-group w-100">
                <label for="name" class="form-label">@lang('cities.name_label')</label>
                <input type="text" class="form-control" id="name" disabled  placeholder="@lang('cities.name_placeholder')" v-model="name">
            </div>
        </div>
    </div>
    <div class="form-group w-100 d-flex justify-content-center" style="gap: 16px">
        <a href="{{ route("admin.cities.show") }}" class="btn btn-secondary w-25">@lang('cities.cancel_button')</a>
        <button class="btn btn-danger w-25" @click="deleteCat">@lang('cities.delete_button')</button>
    </div>
</div>

@endSection

@section("scripts")
<script>
const { createApp, ref } = Vue

createApp({
    data() {
        return {
            id: '{{ $city->id }}',
            name: '{{ $city->name }}',
        }
    },
    methods: {
        async deleteCat() {
            $('.loader').fadeIn().css('display', 'flex')
            try {
                const response = await axios.post(`{{ route("admin.cities.delete") }}`, {
                    id: this.id
                });
                if (response.data.status === true) {
                    document.getElementById('errors').innerHTML = ''
                    let error = document.createElement('div')
                    error.classList = 'success'
                    error.innerHTML = response.data.message
                    document.getElementById('errors').append(error)
                    $('#errors').fadeIn('slow')
                    setTimeout(() => {
                        $('.loader').fadeOut()
                        $('#errors').fadeOut('slow')
                        window.location.href = '{{ route("admin.cities.show") }}'
                    }, 1300);
                } else {
                    $('.loader').fadeOut()
                    document.getElementById('errors').innerHTML = ''
                    $.each(response.data.errors, function (key, value) {
                        let error = document.createElement('div')
                        error.classList = 'error'
                        error.innerHTML = value
                        document.getElementById('errors').append(error)
                    });
                    $('#errors').fadeIn('slow')
                    setTimeout(() => {
                        $('#errors').fadeOut('slow')
                    }, 5000);
                }

            } catch (error) {
                document.getElementById('errors').innerHTML = ''
                let err = document.createElement('div')
                err.classList = 'error'
                err.innerHTML = '@lang('cities.server_error')'
                document.getElementById('errors').append(err)
                $('#errors').fadeIn('slow')
                $('.loader').fadeOut()

                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3500);

                console.error(error);
            }
        }
    },
}).mount('#cities_wrapper')
</script>
@endSection
