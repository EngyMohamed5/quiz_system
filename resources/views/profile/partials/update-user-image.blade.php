<section>
    @include('sweetalert::alert')
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update profile picture') }}
        </h2>
    </header>

    <form method="post" action="{{ route('profile.update_image') }}" enctype="multipart/form-data" class="mt-6 space-y-6 ">
        @csrf
        @method('patch')
        <div class="mb-3">
            <div class="mb-2">
                <label class="form-label">Profile picture</label>
            </div>
            <input type="file" class="form-control" name="image">
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
