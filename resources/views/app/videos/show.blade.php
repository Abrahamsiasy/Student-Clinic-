@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('videos.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.videos.show_title')
                </h4>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>@lang('crud.videos.inputs.path')</h5>
                        @if (isset($video->path))
                            <div class="card">
                                <div class="card-body">
                                    <video width="400" controls>
                                        <source src="{{ \Storage::url($video->path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        @else
                            <span>-</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h5>@lang('crud.videos.inputs.title')</h5>
                        <span>{{ $video->title ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.videos.inputs.desc')</h5>
                        <span>{{ $video->desc ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.videos.inputs.status')</h5>
                        <span>{{ $video->status ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.videos.inputs.path')</h5>
                        @if ($video->path)
                            <a href="{{ \Storage::url($video->path) }}" target="blank"><i
                                    class="icon ion-md-download"></i>&nbsp;Download</a>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('videos.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Video::class)
                        <a href="{{ route('videos.create') }}" class="btn btn-light">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
