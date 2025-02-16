<x-sidebar>
<div class="board_area vh-100 w-100 m-auto d-flex">
  <div class="post_view w-75 mt-5 mb-5">
    <!-- <p class="w-75 m-auto">投稿一覧</p> -->
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
        @foreach($post->subCategories as $sub_category)
        <div><span class="sub_categories_tag badge">{{ $sub_category->sub_category }}</span></div>
        @endforeach
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="">{{ $post_comment->commentCounts($post->id)->count() }}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area w-25">
    <div class="m-4">
      <div class="d-grid gap-2">
        <button class="post_btn btn w-100 mb-3" type="button"><a href="{{ route('post.input') }}">投稿</a></button>
      </div>
      <div class="input-group mb-3">
        <input type="text" class="form-control keyword_search" placeholder="キーワードを検索" name="keyword" form="postSearchRequest" aria-describedby="button-addon2">
        <div class="input-group-append">
          <input type="submit" class="keyword_search_btn btn" id="button-addon2" value="検索" form="postSearchRequest">
        </div>
      </div>
      <div class="btns-group w-100 d-flex justify-content-between">
        <input type="submit" name="like_posts" class="like_post_btn btn" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="my_post_btn btn" value="自分の投稿" form="postSearchRequest">
      </div>
      <div class="mt-3">
        <span>カテゴリー検索</span>
        <div class="accordion">
          <div class="accordion-container">
            <div class="accordion-item mt-2">
              <ul>
                @foreach($categories as $category)
                <li class="main_categories" category_id="{{ $category->id }}">
                  <span class="accordion-title js-accordion-title">{{ $category->main_category }}</span>
                  <ul class="is-close">
                    @foreach($category->subCategories as $sub_category)
                    <li class="sub_categories" category_id="{{ $sub_category->id }}">
                      <input type="submit" name="category_word" class="" value="{{ $sub_category->sub_category }}" form="postSearchRequest">
                    </li>
                    @endforeach
                  </ul>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
</x-sidebar>
