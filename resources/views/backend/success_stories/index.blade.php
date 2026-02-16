@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Success Stories') }}</h1>
            </div>
            {{-- @can('add_success_story') --}}
            <div class="col-md-6 text-md-right">
                <a href="{{ route('success-stories.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Success Story') }}</span>
                </a>
            </div>
            {{-- @endcan --}}
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_success_stories" action="" method="GET">
            <div class="d-sm-flex justify-content-between mx-4">

                <div class="d-flex mt-3">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm h-100" name="search"
                            @isset($search) value="{{ $search }}" @endisset
                            placeholder="Type & Enter">
                    </div>
                </div>
            </div>
        </form>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th data-breakpoints="lg">#</th>
                        <th data-breakpoints="lg">{{ translate('Name') }}</th>
                        <th data-breakpoints="lg">{{ translate('Image') }}</th>
                        <th data-breakpoints="lg">{{ translate('Description') }}</th>
                        <th class="">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($successStories as $key => $story)
                        <tr>
                            <td>{{ $key + 1 + ($successStories->currentPage() - 1) * $successStories->perPage() }}</td>

                            <td>
                                <p class="text-truncate-2">{{ Str::limit($story->name, 20) }}</p>
                            </td>
                            <td><img src="{{ uploaded_asset($story->image) }}" alt="{{ $story->name }}" width="50"
                                    height="50"></td>
                            <td>
                                <p class="text-truncate-2">{{ Str::limit($story->description, 20) }}</p>
                            </td>
                            <td>

                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                    href="{{ route('success-stories.edit', $story->id) }}"
                                    title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                    data-href="{{ route('success-stories.destroy', $story->id) }}"
                                    title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $successStories->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection


@section('modal')
    @include('modals.delete_modal')

    <div class="modal fade success-story-view-modal" id="modal-basic">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Success Story Description') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body success-story-view">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ translate('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script type="text/javascript">
        $(document).on('click', '.confirm-delete', function(e) {
            e.preventDefault(); // Prevent default link behavior
            var deleteUrl = $(this).data('href'); // Get the delete URL from the data-href attribute
            $('#delete-link').attr('href', deleteUrl); // Set the delete URL to the modal's delete link
            $('#delete-modal').modal('show'); // Show the delete modal
        });
    </script>
@endsection
