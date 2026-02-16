@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Edit Success Story') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('success-stories.update', $successStory->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Use PUT or PATCH for updating -->

                        <!-- Success Story Name -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Name') }}</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $successStory->name) }}" required>
                                @error('name')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">
                                {{ translate('Description') }}
                                <p class="fs-10">({{ translate('Max 900 Characters') }})</p>
                            </label>
                            <div class="col-md-9">
                                <textarea name="description" rows="8" class="form-control" maxlength="900">{{ old('description', $successStory->description) }}</textarea>
                                @error('description')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Image File Upload -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Image') }}</label>
                            <div class="col-md-9">
                                <label for="name">{{ translate('Image File ') }}
                                    <small>({{ translate('120x80') }})</small></label>
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="image" class="selected-files"
                                        value="{{ old('image', $successStory->image) }}">
                                </div>
                                <div class="file-preview box sm">
                                    @if ($successStory->image)
                                        <img src="{{ asset($successStory->image) }}" alt="Current Image" class="img-fluid">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
