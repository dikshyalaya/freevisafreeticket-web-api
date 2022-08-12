<!--Right Side Content-->
<div class="col-xl-4 col-lg-4 col-md-12">
    <div class="card">
        <div class="card-body">
            <form action="/news" method="get">
            <div class="input-group">
                <input type="text" class="form-control br-tl-3  br-bl-3" placeholder="Search" name="search">
                <div class="input-group-append ">
                    <button type="submit" class="btn btn-primary br-tr-3  br-br-3">
                        Search
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Categories</h3>
        </div>
        <div class="card-body p-0">
            <div class="list-catergory">
                <div class="item-list">
                    <ul class="list-group mb-0">
                        @foreach ($news_categories as $item)   
                        <li class="list-group-item">
                            <a href="/news?category={{$item->id}}" class="text-dark">
                                {{$item->title}}
                                <span class="badgetext badge badge-pill badge-light mb-0 mt-1">
                                    {{DB::table('manage_news_categories')->where('category_id',$item->id)->count()}}
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
</div>
<!--/Right Side Content-->