@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Create tile
    </div>

    <div class="card-body">
        <form action="{{ route("admin.tiles.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="title">Title*</label>
                <input type="text" id="title" name="title" class="form-control" required="" value="{{ old('title', isset($tile) ? $tile->title : '') }}">
            </div>
            <div class="form-group {{ $errors->has('duration') ? 'has-error' : '' }}">
                <label for="name">duration*</label>
                <input type="text" id="duration" name="duration" class="form-control" required="" value="{{ old('duration', isset($tile) ? $tile->duration : '') }}">
            </div>
            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                <label for="name">price*</label>
                <input type="text" id="price" name="price" class="form-control" required="" value="{{ old('price', isset($tile) ? $tile->price : '') }}">
            </div>
            <div class="form-group {{ $errors->has('popup_title') ? 'has-error' : '' }}">
                <label for="name">popup_title*</label>
                <input type="text" id="popup_title" name="popup_title" class="form-control" required="" value="{{ old('popup_title', isset($tile) ? $tile->popup_title : '') }}">
            </div>
            <div class="form-group {{ $errors->has('popup_description') ? 'has-error' : '' }}">
                <label for="name">popup_description*</label>
                <textarea id="popup_description" name="popup_description" class="form-control ckeditor">{{ old('popup_description', isset($tile) ? $tile->popup_description : '') }}</textarea>
            </div>
            <div class="form-group {{ $errors->has('popup_second_title') ? 'has-error' : '' }}">
                <label for="name">popup_second_title*</label>
                <input type="text" id="popup_second_title" name="popup_second_title" class="form-control" required="" value="{{ old('popup_second_title', isset($tile) ? $tile->popup_second_title : '') }}" />
            </div>
            <div class="form-group {{ $errors->has('popup_first_bullets') ? 'has-error' : '' }}">
                <label for="name">popup_first_bullets*</label>
                <textarea id="popup_first_bullets" name="popup_first_bullets" class="form-control ckeditor">{{ old('popup_first_bullets', isset($tile) ? $tile->popup_first_bullets : '') }}</textarea>
            </div>
            <div class="form-group {{ $errors->has('popup_second_title') ? 'has-error' : '' }}">
                <label for="name">popup_third_title*</label>
                <input type="text" id="popup_third_title" name="popup_third_title" class="form-control" required="" value="{{ old('popup_third_title', isset($tile) ? $tile->popup_third_title : '') }}" />
            </div>
            <div class="form-group {{ $errors->has('popup_second_bullets') ? 'has-error' : '' }}">
                <label for="name">popup_second_bullets*</label>
                <textarea id="popup_second_bullets" name="popup_second_bullets" class="form-control ckeditor">{{ old('popup_second_bullets', isset($tile) ? $tile->popup_second_bullets : '') }}</textarea>
            </div>
            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                <label for="name">category*</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" <?php echo old('category_id', isset($tile) ? 'selected' : ''); ?>>{{$category->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection