<x-sidebar>
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">
    <div class="">
      <p class="mb-0">カテゴリー</p>
      <select class="post_form w-100" form="postCreate" name="post_category_id">
        @foreach($main_categories as $main_category)
        <optgroup label="{{ $main_category->main_category }}">
          @foreach($main_category->subCategories as $sub_category)
        <!-- サブカテゴリー表示 -->
         <option value="{{ $sub_category->id }}" label="{{ $sub_category->sub_category }}"></option>
          @endforeach
        </optgroup>
        @endforeach
      </select>
    </div>
    <div class="mt-3">

      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span>
      @endif

      <p class="mb-0">タイトル</p>
      <input type="text" class="post_form w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
    </div>
    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span>
      @endif
      <p class="mb-0">投稿内容</p>
      <textarea class="post_form w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
    </div>
    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
    </div>
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
  </div>
  @can('admin')
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">
      <div class="">
        <p class="m-0">メインカテゴリー</p>

      @if($errors->first('main_category_name'))
      <span class="error_message">{{ $errors->first('main_category_name') }}</span>
      @endif

        <input type="text" class="post_form w-100" name="main_category_name" form="mainCategoryRequest">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0 mt-2" form="mainCategoryRequest">
      </div>
      <!-- サブカテゴリー追加 -->
        <p class="m-0 mt-5">サブカテゴリー</p>

      @if($errors->first('sub_category_name'))
      <span class="error_message">{{ $errors->first('sub_category_name') }}</span>
      @endif

        <select class="post_form w-100" form="subCategoryRequest" name="main_category_id">
          @foreach($main_categories as $main_category)
          <option label="{{ $main_category->main_category }}" value="{{ $main_category->id }}"></option>
          @endforeach
        </select>
        <input type="text" class="post_form w-100 mt-2" name="sub_category_name" form="subCategoryRequest">
        <!-- nameタグはコントローラーのrequestの名前と一致させる formタグはformの送り先を指定してあげる -->

        <input type="submit" value="追加" class="w-100 btn btn-primary p-0 mt-2" form="subCategoryRequest">

      <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>
      <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">{{ csrf_field() }}</form>
    </div>
  </div>
  @endcan
</div>
</x-sidebar>
