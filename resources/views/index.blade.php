@extends('master')

@section('content')
<div class="container" x-data="{ posts: [] }" x-init="posts = await (await fetch('/api/blog')).json()">
    <template x-for="post in posts">
        <div class="box">
            <article class="media">
                <div class="media-left">
                    <figure class="image is-64x64">
                        <img :src="'https://ui-avatars.com/api/?name=' + post.author" alt="Image">
                    </figure>
                </div>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <a :href="'{{ url('/post') }}/' + post.id"><strong x-text="post.title"></strong></a> @<small x-text="post.author"></small>
                            <br>
                            <span x-html="post.content"></span>
                        </p>
                    </div>
                </div>
            </article>
        </div>
    </template>
    <form method="post" action="{{url('/api/blog')}}">
        <div class="field">
            <label class="label">Název článku</label>
            <div class="control">
                <input class="input" type="text" name="title" placeholder="Název článku">
            </div>
        </div>
        <div class="field">
            <label class="label">Autor</label>
            <div class="control">
                <input class="input" type="text" name="author" placeholder="Jan Novák">
            </div>
        </div>
        <div class="field">
            <label class="label">Obsah</label>
            <div class="control">
                <textarea class="textarea" name="content" placeholder="Lorem ipsum.."></textarea>
            </div>
        </div>
        <button type="submit" class="button is-primary">Odeslat</button>
    </form>
</div>
@endsection
