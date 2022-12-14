@extends('layouts.admin.app')

@section('title', 'Edit Attachment')

@section('content_header')
    <x-admin.title
        text="Edit Attachment"
    />
@stop

@section('content')
    <form action="{{ route('admin.attachments.update', $attachment) }}" method="POST" class="general-ajax-submit">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{$attachment->original_name}}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type</label>
                            <input type="text" class="form-control" value="{{$attachment->type}}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Size</label>
                            <input type="text" class="form-control" value="{{$attachment->getSize()}}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Group</label>
                            <input type="text" class="form-control" value="{{$attachment->group}}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Alt</label>
                            <x-admin.multi-lang-input name="alt" :model="$attachment" />
                            <span data-input="alt" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <x-admin.multi-lang-input name="title" :model="$attachment" />
                            <span data-input="title" class="input-error"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>URL</label>
                            <a href="{{$attachment->url}}" target="_blank" class="form-control">{{$attachment->url}}</a>
                            @if ($attachment->type == 'image')
                                <img style="max-width:100%;max-height:300px" src="{{$attachment->url}}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success min-w-100">Save</button>
        <a href="{{ route('admin.attachments.index') }}" class="btn btn-outline-secondary text-dark min-w-100">Cancel</a>
    </form>
@endsection
